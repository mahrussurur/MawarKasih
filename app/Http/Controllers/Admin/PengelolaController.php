<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PengelolaController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Menampilkan daftar pengelola berdasarkan role.
     * $roleFilter: 'pengasuh' | 'bendahara' | 'sekretaris' | 'donatur'
     */
    public function index(Request $request, string $roleFilter)
    {
        $query = User::where('role', $roleFilter)->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(10)->withQueryString();
        $roleLabel = ucfirst($roleFilter);

        return view('admin.pengelola.index', compact('users', 'roleFilter', 'roleLabel'));
    }

    public function show(string $roleFilter, User $user)
    {
        abort_if($user->role !== $roleFilter, 403);

        // Untuk donatur, tampilkan riwayat donasinya
        $donasi = null;
        if ($roleFilter === 'donatur') {
            $donasi = $user->donasi()->latest()->take(10)->get();
        }

        return view('admin.pengelola.show', compact('user', 'roleFilter', 'donasi'));
    }

    public function edit(string $roleFilter, User $user)
    {
        abort_if($user->role !== $roleFilter, 403);
        return view('admin.pengelola.edit', compact('user', 'roleFilter'));
    }

    public function update(Request $request, string $roleFilter, User $user)
    {
        abort_if($user->role !== $roleFilter, 403);

        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $user->id,
            'no_hp'         => 'nullable|string|max:20',
            'alamat'        => 'nullable|string',
            'jabatan'       => 'nullable|string|max:255',
            'jenis_kelamin' => 'nullable|in:L,P',
            'tempat_lahir'  => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'status'        => 'required|in:aktif,tidak_aktif',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except(['foto', '_token', '_method', 'password']);

        if ($request->hasFile('foto')) {
            if ($user->foto) {
                $this->imageService->deleteImage($user->foto);
            }
            $data['foto'] = $this->imageService->uploadAndGenerateWebp($request->file('foto'), 'users');
        }

        $user->update($data);

        return redirect()->route('admin.pengelola.index', $roleFilter)->with('success', ucfirst($roleFilter) . ' berhasil diperbarui.');
    }

    public function destroy(string $roleFilter, User $user)
    {
        abort_if($user->role !== $roleFilter, 403);

        if ($user->foto) {
            $this->imageService->deleteImage($user->foto);
        }
        $user->delete();

        return redirect()->route('admin.pengelola.index', $roleFilter)->with('success', ucfirst($roleFilter) . ' berhasil dihapus.');
    }

    public function toggleStatus(string $roleFilter, User $user)
    {
        abort_if($user->role !== $roleFilter, 403);
        $user->update([
            'status' => $user->status === 'aktif' ? 'tidak_aktif' : 'aktif'
        ]);
        return back()->with('success', 'Status berhasil diubah.');
    }
}
