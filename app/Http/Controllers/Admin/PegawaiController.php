<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfilPegawai;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PegawaiController extends Controller
{
    public function __construct(protected ImageService $imageService) {}

    public function index(Request $request)
    {
        $query = ProfilPegawai::with('user')->latest();

        if ($request->filled('jabatan')) {
            $query->where('jabatan', $request->jabatan);
        }

        if ($request->filled('search')) {
            $search = $request->string('search')->trim()->value();
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('jabatan', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('username', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $pegawais = $query->paginate(10)->withQueryString();
        $totalPegawai = ProfilPegawai::count();

        return view('admin.pegawai.index', compact('pegawais', 'totalPegawai'));
    }

    public function create()
    {
        return view('admin.pegawai.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'nama' => ['required', 'string', 'max:255'],
            'jabatan' => ['required', 'string', 'max:255'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'tempat_lahir' => ['nullable', 'string', 'max:255'],
            'tanggal_lahir' => ['nullable', 'date'],
            'jenis_kelamin' => ['nullable', 'in:L,P'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string'],
        ];

        // Pengasuh tidak memiliki role login, hanya sebatas pengelolaan data pegawai
        $hasAccount = $request->boolean('buat_akun_login') && strtolower($request->jabatan) !== 'pengasuh';

        if ($hasAccount) {
            $rules['username'] = ['required', 'string', 'max:255', 'unique:users,username'];
            $rules['email'] = ['required', 'email', 'max:255', 'unique:users,email'];
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
            $rules['role'] = ['required', 'in:admin,ketua,bendahara'];
        }

        $validated = $request->validate($rules);
        $storedFoto = null;

        try {
            DB::transaction(function () use ($request, $validated, $hasAccount, &$storedFoto) {
                if ($request->hasFile('foto')) {
                    $storedFoto = $this->imageService->uploadAndGenerateWebp($request->file('foto'), 'pegawai');
                }

                $user = null;
                if ($hasAccount) {
                    $user = User::create([
                        'username' => $validated['username'],
                        'email' => $validated['email'],
                        'password' => Hash::make($validated['password']),
                        'role' => $validated['role'],
                        'status' => 'aktif',
                    ]);
                }

                ProfilPegawai::create([
                    'user_id' => $user?->id,
                    'foto' => $storedFoto,
                    'nama' => $validated['nama'],
                    'tempat_lahir' => $validated['tempat_lahir'] ?? null,
                    'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
                    'jabatan' => $validated['jabatan'],
                    'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
                    'no_hp' => $validated['no_hp'] ?? null,
                    'alamat' => $validated['alamat'] ?? null,
                ]);
            });
        } catch (\Throwable $e) {
            if ($storedFoto) {
                $this->imageService->deleteImage($storedFoto);
            }
            throw $e;
        }

        return redirect()->route('admin.pegawai.index')
            ->with('success', 'Data Pegawai berhasil ditambahkan.');
    }

    public function show(ProfilPegawai $pegawai)
    {
        $pegawai->load('user');
        return view('admin.pegawai.show', compact('pegawai'));
    }

    public function edit(ProfilPegawai $pegawai)
    {
        $pegawai->load('user');
        return view('admin.pegawai.edit', compact('pegawai'));
    }

    public function update(Request $request, ProfilPegawai $pegawai)
    {
        $rules = [
            'nama' => ['required', 'string', 'max:255'],
            'jabatan' => ['required', 'string', 'max:255'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'tempat_lahir' => ['nullable', 'string', 'max:255'],
            'tanggal_lahir' => ['nullable', 'date'],
            'jenis_kelamin' => ['nullable', 'in:L,P'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string'],
        ];

        $hasExistingAccount = (bool) $pegawai->user;
        $hasNewAccount = ! $hasExistingAccount
            && ($request->boolean('buat_akun_login') || $request->filled('username') || $request->filled('email'))
            && strtolower($request->jabatan) !== 'pengasuh';

        // Auto-fill role jika belum diisi tetapi jabatan sesuai
        if ($hasNewAccount && ! $request->filled('role') && in_array(strtolower($request->jabatan), ['admin', 'ketua', 'bendahara'])) {
            $request->merge(['role' => strtolower($request->jabatan)]);
        }

        if ($hasExistingAccount) {
            $rules['username'] = ['required', 'string', 'max:255', Rule::unique('users')->ignore($pegawai->user->id)];
            $rules['email'] = ['required', 'email', 'max:255', Rule::unique('users')->ignore($pegawai->user->id)];
            $rules['role'] = ['nullable', 'in:admin,ketua,bendahara'];
            if ($request->filled('password')) {
                $rules['password'] = ['nullable', 'string', 'min:8', 'confirmed'];
            }
        } elseif ($hasNewAccount) {
            $rules['username'] = ['required', 'string', 'max:255', 'unique:users,username'];
            $rules['email'] = ['required', 'email', 'max:255', 'unique:users,email'];
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
            $rules['role'] = ['required', 'in:admin,ketua,bendahara'];
        }

        $validated = $request->validate($rules);
        $oldFoto = $pegawai->foto;
        $storedFoto = null;

        try {
            DB::transaction(function () use ($request, $validated, $pegawai, $hasExistingAccount, $hasNewAccount, &$storedFoto) {
                if ($request->hasFile('foto')) {
                    $storedFoto = $this->imageService->uploadAndGenerateWebp($request->file('foto'), 'pegawai');
                }

                $effectiveFoto = $storedFoto ?? $pegawai->foto;

                $pegawaiUpdates = [
                    'foto' => $effectiveFoto,
                    'nama' => $validated['nama'],
                    'tempat_lahir' => $validated['tempat_lahir'] ?? null,
                    'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
                    'jabatan' => $validated['jabatan'],
                    'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
                    'no_hp' => $validated['no_hp'] ?? null,
                    'alamat' => $validated['alamat'] ?? null,
                ];

                if ($hasExistingAccount) {
                    $userUpdates = [
                        'username' => $validated['username'],
                        'email' => $validated['email'],
                    ];
                    if ($request->filled('password')) {
                        $userUpdates['password'] = Hash::make($validated['password']);
                    }
                    if ($request->filled('status')) {
                        $userUpdates['status'] = $request->status;
                    }
                    if (! empty($validated['role'])) {
                        $userUpdates['role'] = $validated['role'];
                    }
                    $pegawai->user->update($userUpdates);
                } elseif ($hasNewAccount) {
                    $newUser = User::create([
                        'username' => $validated['username'],
                        'email' => $validated['email'],
                        'password' => Hash::make($validated['password']),
                        'role' => $validated['role'],
                        'status' => $request->input('status', 'aktif'),
                    ]);
                    $pegawaiUpdates['user_id'] = $newUser->id;
                }

                $pegawai->update($pegawaiUpdates);
            });
        } catch (\Throwable $e) {
            if ($storedFoto) {
                $this->imageService->deleteImage($storedFoto);
            }
            throw $e;
        }

        if ($storedFoto && $oldFoto && $oldFoto !== $storedFoto) {
            $this->imageService->deleteImage($oldFoto);
        }

        return redirect()->route('admin.pegawai.index')
            ->with('success', 'Data Pegawai berhasil diperbarui.');
    }

    public function destroy(ProfilPegawai $pegawai)
    {
        if ($pegawai->user_id && $pegawai->user_id === Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $foto = $pegawai->foto;
        $user = $pegawai->user;

        $pegawai->delete();
        if ($user) {
            $user->delete();
        }

        if ($foto) {
            $this->imageService->deleteImage($foto);
        }

        return redirect()->route('admin.pegawai.index')
            ->with('success', 'Data Pegawai berhasil dihapus.');
    }
}
