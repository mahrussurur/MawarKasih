<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct(protected ImageService $imageService) {}

    public function edit(Request $request): View
    {
        $user = $request->user();
        $isDonatur = $user->role === 'donatur';
        $profileRelation = $isDonatur ? 'profilDonatur' : 'profilPegawai';

        $user->load($profileRelation);

        return view('admin.profile.edit', [
            'user' => $user,
            'profile' => $user->{$profileRelation},
            'isDonatur' => $isDonatur,
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();
        $isDonatur = $user->role === 'donatur';
        $profile = $isDonatur
            ? $user->profilDonatur()->firstOrNew(['user_id' => $user->id])
            : $user->profilPegawai()->firstOrNew(['user_id' => $user->id]);
        $oldFoto = $isDonatur ? null : $profile->foto;
        $storedFoto = null;

        try {
            DB::transaction(function () use ($request, $validated, $user, $profile, $isDonatur, &$storedFoto): void {
                if (! $isDonatur && $request->hasFile('foto')) {
                    $storedFoto = $this->imageService->uploadAndGenerateWebp($request->file('foto'), 'pegawai');
                }

                $accountData = [
                    'username' => $validated['username'],
                    'email' => $validated['email'],
                ];

                $user->update($accountData);
                $profile->fill($this->profileData($validated, $isDonatur, $storedFoto ?? $profile->foto ?? null))->save();
            });
        } catch (\Throwable $exception) {
            if ($storedFoto) {
                $this->imageService->deleteImage($storedFoto);
            }

            throw $exception;
        }

        if ($storedFoto && $oldFoto && $oldFoto !== $storedFoto) {
            $this->imageService->deleteImage($oldFoto);
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        $foto = $user->role === 'donatur' ? null : $user->profilPegawai?->foto;

        Auth::logout();

        $user->delete();
        $this->imageService->deleteImage($foto);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    private function profileData(array $validated, bool $isDonatur, ?string $foto): array
    {
        if ($isDonatur) {
            return [
                'nama' => $validated['nama'],
                'no_hp' => $validated['no_hp'] ?? null,
                'alamat' => $validated['alamat'] ?? null,
            ];
        }

        return [
            'foto' => $foto,
            'nama' => $validated['nama'],
            'tempat_lahir' => $validated['tempat_lahir'] ?? null,
            'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
            'jabatan' => $validated['jabatan'] ?? null,
            'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
            'no_hp' => $validated['no_hp'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
        ];
    }
}
