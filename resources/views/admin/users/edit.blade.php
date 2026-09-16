@extends('layouts.app')

@section('page-title', 'Kelola Akun')
@section('title', 'Kelola Akun | Panti Asuhan Mawar Kasih')

@section('content')
<div class="mx-auto max-w-2xl overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
    <div class="flex items-center justify-between gap-4 border-b border-gray-200 bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
        <div>
            <h2 class="text-lg font-bold text-white">Kelola Akun</h2>
            <p class="text-sm text-blue-100">Profil dikelola dari menu data sesuai role.</p>
        </div>
        <a href="{{ route('users.index') }}" class="text-sm font-semibold text-white transition hover:text-blue-100">Kembali</a>
    </div>

    <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-5 p-6">
        @csrf
        @method('PATCH')

        <div class="rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-700">
            Role: <span class="font-semibold">{{ ucfirst($user->role) }}</span>
            <span class="ml-2 text-xs text-gray-500">Role tidak dapat diubah dari Data User.</span>
        </div>

        <div>
            <label for="username" class="mb-2 block text-sm font-bold text-gray-800">Username</label>
            <input id="username" type="text" name="username" value="{{ old('username', $user->username) }}" required autocomplete="username" class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500 @error('username') border-red-400 @enderror">
            @error('username')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="email" class="mb-2 block text-sm font-bold text-gray-800">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email" class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-400 @enderror">
            @error('email')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="password" class="mb-2 block text-sm font-bold text-gray-800">Password Baru</label>
            <input id="password" type="password" name="password" autocomplete="new-password" placeholder="Kosongkan jika tidak diubah" class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-400 @enderror">
            @error('password')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
        </div>

        <fieldset>
            <legend class="mb-2 block text-sm font-bold text-gray-800">Status Akun</legend>
            <div class="flex gap-6">
                <label class="flex items-center gap-2 text-sm text-gray-700"><input type="radio" name="status" value="aktif" @checked(old('status', $user->status) === 'aktif') required> Aktif</label>
                <label class="flex items-center gap-2 text-sm text-gray-700"><input type="radio" name="status" value="tidak_aktif" @checked(old('status', $user->status) === 'tidak_aktif')> Tidak Aktif</label>
            </div>
            @error('status')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
        </fieldset>

        <div class="flex justify-end">
            <button type="submit" class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">Simpan Akun</button>
        </div>
    </form>
</div>
@endsection
