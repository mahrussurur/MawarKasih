@extends('layouts.app')

@section('page-title', 'Data User')

@section('content')
<div class="max-w-3xl mx-auto overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
    <!-- Header -->
    <div class="border-b border-gray-200 bg-gradient-to-r from-amber-500 to-amber-600 px-6 py-4 flex justify-between items-center gap-4">
        <div>
            <h2 class="text-lg font-bold text-white">Edit Data User</h2>
            <p class="text-xs text-gray-200">Profil User dikelola dari menu data sesuai role.</p>
        </div>
        <a href="{{ route('users.index') }}" class="text-xs font-semibold text-white hover:text-gray-400 flex items-center transition-colors whitespace-nowrap">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span class="hidden sm:inline">Kembali</span>
        </a>
    </div>

    <div class="p-4 md:p-6">   
        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="mb-5">
                <label for="role" class="mb-2 block text-sm font-bold text-gray-800">Role <span class="text-red-500">*</span></label>
                <select id="role" name="role" required class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500 @error('role') border-red-400 @enderror">
                    <option value="admin" @selected(old('role', $user->role) === 'admin')>Admin</option>
                    <option value="bendahara" @selected(old('role', $user->role) === 'bendahara')>Bendahara</option>
                    <option value="sekretaris" @selected(old('role', $user->role) === 'sekretaris')>Sekretaris</option>
                    <option value="pengasuh" @selected(old('role', $user->role) === 'pengasuh')>Pengasuh</option>
                    <option value="donatur" @selected(old('role', $user->role) === 'donatur')>Donatur</option>
                </select>
                @error('role')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <div class="mb-5">
                <label for="username" class="mb-2 block text-sm font-bold text-gray-800">Username <span class="text-red-500">*</span></label>
                <input id="username" type="text" name="username" value="{{ old('username', $user->username) }}" required autocomplete="username" class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500 @error('username') border-red-400 @enderror">
                @error('username')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <div class="mb-5">
                <label for="email" class="mb-2 block text-sm font-bold text-gray-800">Email <span class="text-red-500">*</span></label>
                <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email" class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-400 @enderror">
                @error('email')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                <div>
                    <label for="password" class="mb-2 block text-sm font-bold text-gray-800">Password Baru</label>
                    <div class="relative">
                        <input id="password" type="password" name="password" autocomplete="new-password" placeholder="masukkan sandi baru" class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 pr-12 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-400 ring-1 ring-red-400 @enderror">
                        <button type="button" onclick="togglePassword('password', 'icon-eye-pw', 'icon-eye-off-pw')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors" aria-label="Tampilkan password">
                            <svg id="icon-eye-pw" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <circle cx="12" cy="12" r="3" stroke-width="2.5"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg id="icon-eye-off-pw" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.477 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">kosongkan jika tidak ingin mengubah password.</p>
                </div>

                <div>
                    <label for="password_confirmation" class="mb-2 block text-sm font-bold text-gray-800">Konfirmasi Password Baru</label>
                    <div class="relative">
                        <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" placeholder="Ulangi password baru" class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 pr-12 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button type="button" onclick="togglePassword('password_confirmation', 'icon-eye-conf', 'icon-eye-off-conf')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors" aria-label="Tampilkan konfirmasi password">
                            <svg id="icon-eye-conf" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <circle cx="12" cy="12" r="3" stroke-width="2.5"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg id="icon-eye-off-conf" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.477 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <fieldset>
                <legend class="mb-2 block text-sm font-bold text-gray-800">Status Akun</legend>
                <div class="flex gap-6">
                    <label class="flex items-center gap-2 text-sm text-gray-700"><input type="radio" name="status" value="aktif" @checked(old('status', $user->status) === 'aktif') required> Aktif</label>
                    <label class="flex items-center gap-2 text-sm text-gray-700"><input type="radio" name="status" value="tidak_aktif" @checked(old('status', $user->status) === 'tidak_aktif')> Tidak Aktif</label>
                </div>
                @error('status')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </fieldset>

            <div class="flex justify-center items-center gap-4 pt-6 border-t border-gray-200 mt-6 pb-2">
                    <a href="{{ route('users.index') }}" class="rounded-xl bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 border border-gray-300 transition hover:bg-gray-300">
                        Batal
                    </a>
                    <button type="submit" class="rounded-xl bg-green-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-green-700">
                        Simpan
                    </button>
                </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function togglePassword(inputId, iconOnId, iconOffId) {
        const input = document.getElementById(inputId);
        const iconOn = document.getElementById(iconOnId);
        const iconOff = document.getElementById(iconOffId);

        if (input.type === 'password') {
            input.type = 'text';
            iconOn.classList.add('hidden');
            iconOff.classList.remove('hidden');
        } else {
            input.type = 'password';
            iconOn.classList.remove('hidden');
            iconOff.classList.add('hidden');
        }
    }
</script>
@endpush
@endsection
