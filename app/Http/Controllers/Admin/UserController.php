<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index(Request $request)
    {
        $query = User::latest();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(10)->withQueryString();
        $activeRole = $request->role;

        return view('admin.users.index', compact('users', 'activeRole'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'role'     => 'required|in:admin,bendahara,sekretaris,pengasuh,donatur',
            'status'   => 'required|in:aktif,tidak_aktif',
            'foto'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'jenis_kelamin' => 'nullable|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'no_hp'    => 'nullable|string|max:20',
        ]);

        $data = $request->except(['password', 'foto']);
        $data['password'] = Hash::make($request->password);

        if ($request->hasFile('foto')) {
            $data['foto'] = $this->imageService->uploadAndGenerateWebp($request->file('foto'), 'users');
        }

        User::create($data);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'role'     => 'required|in:admin,bendahara,sekretaris,pengasuh,donatur',
            'status'   => 'required|in:aktif,tidak_aktif',
            'foto'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'jenis_kelamin' => 'nullable|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'no_hp'    => 'nullable|string|max:20',
        ]);

        $data = $request->except(['password', 'foto', '_token', '_method']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto) {
                $this->imageService->deleteImage($user->foto);
            }
            $data['foto'] = $this->imageService->uploadAndGenerateWebp($request->file('foto'), 'users');
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        // Hapus foto jika ada
        if ($user->foto) {
            $this->imageService->deleteImage($user->foto);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }

    public function cetak(Request $request)
    {
        // Placeholder untuk fitur cetak PDF di masa mendatang
        abort(404, 'Fitur cetak belum tersedia.');
    }
}
