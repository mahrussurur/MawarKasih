<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PengelolaController extends Controller
{
    public function __construct(protected ImageService $imageService) {}

    public function index(Request $request, string $roleFilter)
    {
        $this->ensureSupportedRole($roleFilter);

        $query = User::where('role', $roleFilter)->latest();

        if ($this->usesPengelolaProfile($roleFilter)) {
            $query->with('profilPengelola');
        } elseif ($this->usesDonaturProfile($roleFilter)) {
            $query->with('profilDonatur');
        }

        if ($request->filled('search')) {
            $search = $request->string('search')->trim()->value();

            $query->where(function ($query) use ($search, $roleFilter) {
                $query->where('email', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%");

                if ($this->usesPengelolaProfile($roleFilter)) {
                    $query->orWhereHas('profilPengelola', function ($profileQuery) use ($search) {
                        $profileQuery->where('nama', 'like', "%{$search}%")
                            ->orWhere('no_hp', 'like', "%{$search}%");
                    });
                } elseif ($this->usesDonaturProfile($roleFilter)) {
                    $query->orWhereHas('profilDonatur', function ($profileQuery) use ($search) {
                        $profileQuery->where('nama', 'like', "%{$search}%")
                            ->orWhere('no_hp', 'like', "%{$search}%");
                    });
                }
            });
        }

        $users = $query->paginate(10)->withQueryString();
        $roleLabel = $this->roleLabel($roleFilter);
        $usesPengelolaProfile = $this->usesPengelolaProfile($roleFilter);
        $usesDonaturProfile = $this->usesDonaturProfile($roleFilter);

        return view('admin.pengelola.index', compact('users', 'roleFilter', 'roleLabel', 'usesPengelolaProfile', 'usesDonaturProfile'));
    }

    public function create(string $roleFilter)
    {
        $this->ensureSupportedRole($roleFilter);

        return view('admin.pengelola.create', [
            'roleFilter' => $roleFilter,
            'roleLabel' => $this->roleLabel($roleFilter),
            'usesPengelolaProfile' => $this->usesPengelolaProfile($roleFilter),
        ]);
    }

    public function store(Request $request, string $roleFilter)
    {
        $this->ensureSupportedRole($roleFilter);

        if ($this->usesDonaturProfile($roleFilter)) {
            return $this->storeDonatur($request);
        }

        $this->ensurePengelolaRole($roleFilter);
        $validated = $this->validatedPengelolaData($request);
        $storedFoto = null;

        try {
            DB::transaction(function () use ($request, $validated, $roleFilter, &$storedFoto) {
                if ($request->hasFile('foto')) {
                    $storedFoto = $this->imageService->uploadAndGenerateWebp($request->file('foto'), 'pengelola');
                }

                $user = User::create([
                    'username' => $validated['username'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'role' => $roleFilter,
                    'status' => 'aktif',
                ]);

                $user->profilPengelola()->create([
                    ...$this->profileData($validated, $storedFoto),
                ]);
            });
        } catch (\Throwable $exception) {
            if ($storedFoto) {
                $this->imageService->deleteImage($storedFoto);
            }

            throw $exception;
        }

        return redirect()->route('admin.pengelola.index', $roleFilter)
            ->with('success', $this->roleLabel($roleFilter).' berhasil ditambahkan.');
    }

    public function show(string $roleFilter, User $user)
    {
        $this->ensureSupportedRole($roleFilter);
        $this->ensureMatchingRole($roleFilter, $user);

        if ($this->usesPengelolaProfile($roleFilter)) {
            $user->load('profilPengelola');
        } elseif ($this->usesDonaturProfile($roleFilter)) {
            $user->load('profilDonatur');
        }

        $donasi = $roleFilter === 'donatur'
            ? $user->donasi()->latest()->take(10)->get()
            : null;

        return view('admin.pengelola.show', [
            'user' => $user,
            'roleFilter' => $roleFilter,
            'roleLabel' => $this->roleLabel($roleFilter),
            'usesPengelolaProfile' => $this->usesPengelolaProfile($roleFilter),
            'usesDonaturProfile' => $this->usesDonaturProfile($roleFilter),
            'donasi' => $donasi,
        ]);
    }

    public function edit(string $roleFilter, User $user)
    {
        $this->ensureSupportedRole($roleFilter);
        $this->ensureMatchingRole($roleFilter, $user);

        if ($this->usesPengelolaProfile($roleFilter)) {
            $user->load('profilPengelola');
        } elseif ($this->usesDonaturProfile($roleFilter)) {
            $user->load('profilDonatur');
        }

        return view('admin.pengelola.edit', [
            'user' => $user,
            'roleFilter' => $roleFilter,
            'roleLabel' => $this->roleLabel($roleFilter),
            'usesPengelolaProfile' => $this->usesPengelolaProfile($roleFilter),
            'usesDonaturProfile' => $this->usesDonaturProfile($roleFilter),
        ]);
    }

    public function update(Request $request, string $roleFilter, User $user)
    {
        $this->ensureSupportedRole($roleFilter);
        $this->ensureMatchingRole($roleFilter, $user);

        if ($this->usesDonaturProfile($roleFilter)) {
            return $this->updateDonatur($request, $user);
        }

        $validated = $this->validatedPengelolaData($request, $user);
        $profile = $user->profilPengelola()->firstOrNew([
            'user_id' => $user->id,
        ]);
        $oldFoto = $profile->foto;
        $storedFoto = null;

        try {
            DB::transaction(function () use ($request, $validated, $user, $profile, &$storedFoto) {
                if ($request->hasFile('foto')) {
                    $storedFoto = $this->imageService->uploadAndGenerateWebp($request->file('foto'), 'pengelola');
                }

                $effectiveFoto = $storedFoto ?? $profile->foto;

                $profile->fill($this->profileData($validated, $effectiveFoto))->save();
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

        return redirect()->route('admin.pengelola.index', $roleFilter)
            ->with('success', $this->roleLabel($roleFilter).' berhasil diperbarui.');
    }

    public function destroy(string $roleFilter, User $user)
    {
        $this->ensureSupportedRole($roleFilter);
        $this->ensureMatchingRole($roleFilter, $user);

        $foto = $this->usesPengelolaProfile($roleFilter)
            ? $user->profilPengelola?->foto
            : null;

        $user->delete();
        $this->imageService->deleteImage($foto);

        return redirect()->route('admin.pengelola.index', $roleFilter)
            ->with('success', $this->roleLabel($roleFilter).' berhasil dihapus.');
    }

    private function validatedPengelolaData(Request $request, ?User $user = null): array
    {
        $rules = [
            'nama' => ['required', 'string', 'max:255'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'tempat_lahir' => ['nullable', 'string', 'max:255'],
            'tanggal_lahir' => ['nullable', 'date'],
            'jabatan' => ['nullable', 'string', 'max:255'],
            'jenis_kelamin' => ['nullable', 'in:L,P'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string'],
        ];

        if (!$user) {
            $rules['username'] = ['required', 'string', 'max:255', 'unique:users,username'];
            $rules['email'] = ['required', 'email', 'max:255', 'unique:users,email'];
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
        }

        return $request->validate($rules);
    }

    private function profileData(array $validated, ?string $foto): array
    {
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

    private function storeDonatur(Request $request)
    {
        $validated = $this->validatedDonaturData($request);

        DB::transaction(function () use ($validated): void {
            $user = User::create([
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'donatur',
                'status' => 'aktif',
            ]);

            $user->profilDonatur()->create($this->donaturProfileData($validated));
        });

        return redirect()->route('admin.pengelola.index', 'donatur')
            ->with('success', 'Donatur berhasil ditambahkan.');
    }

    private function updateDonatur(Request $request, User $user)
    {
        $validated = $this->validatedDonaturData($request, $user);
        $profile = $user->profilDonatur()->firstOrNew([
            'user_id' => $user->id,
        ]);

        DB::transaction(function () use ($validated, $user, $profile): void {
            $profile->fill($this->donaturProfileData($validated))->save();
        });

        return redirect()->route('admin.pengelola.index', 'donatur')
            ->with('success', 'Donatur berhasil diperbarui.');
    }

    private function validatedDonaturData(Request $request, ?User $user = null): array
    {
        $rules = [
            'nama' => ['required', 'string', 'max:255'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string'],
        ];

        if (!$user) {
            $rules['username'] = ['required', 'string', 'max:255', 'unique:users,username'];
            $rules['email'] = ['required', 'email', 'max:255', 'unique:users,email'];
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
        }

        return $request->validate($rules);
    }

    private function donaturProfileData(array $validated): array
    {
        return [
            'nama' => $validated['nama'],
            'no_hp' => $validated['no_hp'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
        ];
    }

    private function ensureSupportedRole(string $roleFilter): void
    {
        abort_unless(in_array($roleFilter, ['pengasuh', 'bendahara', 'sekretaris', 'donatur'], true), 404);
    }

    private function ensurePengelolaRole(string $roleFilter): void
    {
        abort_unless($this->usesPengelolaProfile($roleFilter), 404);
    }

    private function ensureMatchingRole(string $roleFilter, User $user): void
    {
        abort_unless($user->role === $roleFilter, 403);
    }

    private function usesPengelolaProfile(string $roleFilter): bool
    {
        return in_array($roleFilter, ['pengasuh', 'bendahara', 'sekretaris'], true);
    }

    private function usesDonaturProfile(string $roleFilter): bool
    {
        return $roleFilter === 'donatur';
    }

    private function roleLabel(string $roleFilter): string
    {
        return ucfirst($roleFilter);
    }
}
