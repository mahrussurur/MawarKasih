<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DonaturController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'donatur')->with('profilDonatur')->latest();

        if ($request->filled('search')) {
            $search = $request->string('search')->trim()->value();
            $query->where(function ($q) use ($search) {
                $q->where('email', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhereHas('profilDonatur', function ($pq) use ($search) {
                      $pq->where('nama', 'like', "%{$search}%")
                         ->orWhere('no_hp', 'like', "%{$search}%");
                  });
            });
        }

        $donaturs = $query->paginate(10)->withQueryString();
        $totalDonatur = User::where('role', 'donatur')->count();

        return view('admin.donatur.index', compact('donaturs', 'totalDonatur'));
    }

    public function create()
    {
        return view('admin.donatur.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'donatur',
                'status' => 'aktif',
            ]);

            $user->profilDonatur()->create([
                'nama' => $validated['nama'],
                'no_hp' => $validated['no_hp'] ?? null,
                'alamat' => $validated['alamat'] ?? null,
            ]);
        });

        return redirect()->route('admin.donatur.index')
            ->with('success', 'Data Donatur berhasil ditambahkan.');
    }

    public function show(User $donatur)
    {
        abort_unless($donatur->role === 'donatur', 404);
        $donatur->load('profilDonatur');
        $donasi = $donatur->donasi()->latest()->take(10)->get();

        return view('admin.donatur.show', compact('donatur', 'donasi'));
    }

    public function edit(User $donatur)
    {
        abort_unless($donatur->role === 'donatur', 404);
        $donatur->load('profilDonatur');

        return view('admin.donatur.edit', compact('donatur'));
    }

    public function update(Request $request, User $donatur)
    {
        abort_unless($donatur->role === 'donatur', 404);

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($donatur->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($donatur->id)],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($validated, $donatur, $request) {
            $userUpdates = [
                'username' => $validated['username'],
                'email' => $validated['email'],
            ];
            if ($request->filled('password')) {
                $userUpdates['password'] = Hash::make($request->password);
            }
            if ($request->filled('status')) {
                $userUpdates['status'] = $request->status;
            }
            $donatur->update($userUpdates);

            $profile = $donatur->profilDonatur()->firstOrNew(['user_id' => $donatur->id]);
            $profile->fill([
                'nama' => $validated['nama'],
                'no_hp' => $validated['no_hp'] ?? null,
                'alamat' => $validated['alamat'] ?? null,
            ])->save();
        });

        return redirect()->route('admin.donatur.index')
            ->with('success', 'Data Donatur berhasil diperbarui.');
    }

    public function destroy(User $donatur)
    {
        abort_unless($donatur->role === 'donatur', 404);
        $donatur->delete();

        return redirect()->route('admin.donatur.index')
            ->with('success', 'Data Donatur berhasil dihapus.');
    }
}
