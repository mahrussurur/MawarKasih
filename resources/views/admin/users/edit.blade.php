@extends('layouts.app')
@section('page-title', 'Data User')
@section('title', 'Edit User | Panti Asuhan Mawar Kasih')

@section('content')
<div class="max-w-3xl mx-auto overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

    <!-- Header -->
    <div class="border-b border-gray-200 bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex justify-between items-center gap-4">
        <div class="min-w-0">
            <h2 class="text-lg font-bold text-white truncate">Edit User</h2>
            <p class="text-xs md:text-sm text-gray-300">Ubah detail akun pengguna di bawah ini.</p>
        </div>
        <a href="{{ route('users.index') }}" class="text-xs md:text-sm font-semibold text-white hover:text-gray-400 flex items-center transition-colors whitespace-nowrap">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span class="hidden sm:inline">Kembali</span>
        </a>
    </div>

    <div class="p-4 md:p-6">
        <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            {{-- Nama Lengkap --}}
            <div class="mb-5">
                <label class="text-sm font-bold text-gray-800 block mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" placeholder="Masukkan Nama Lengkap..."
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm placeholder:text-gray-400 @error('name') border-red-400 @enderror" required>
                @error('name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            {{-- Username --}}
            <div class="mb-5">
                <label class="text-sm font-bold text-gray-800 block mb-2">Username <span class="text-red-500">*</span></label>
                <input type="text" name="username" value="{{ old('username', $user->username) }}" placeholder="Masukkan Username..."
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm placeholder:text-gray-400 @error('username') border-red-400 @enderror" required>
                @error('username')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            {{-- Email --}}
            <div class="mb-5">
                <label class="text-sm font-bold text-gray-800 block mb-2">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="Masukkan Email..."
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm placeholder:text-gray-400 @error('email') border-red-400 @enderror" required>
                @error('email')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            {{-- Password --}}
            <div class="mb-5">
                <label class="text-sm font-bold text-gray-800 block mb-2">Password Baru</label>
                <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password..."
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm placeholder:text-gray-400 @error('password') border-red-400 @enderror">
                <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah password. Minimal 8 karakter jika diisi.</p>
                @error('password')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            {{-- Role & Jabatan --}}
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 mb-5">
                <div>
                    <label class="text-sm font-bold text-gray-800 block mb-2">Role <span class="text-red-500">*</span></label>
                    <select name="role" class="w-full h-[48px] px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm appearance-none @error('role') border-red-400 @enderror" required>
                        @foreach(['admin' => 'Admin', 'bendahara' => 'Bendahara', 'sekretaris' => 'Sekretaris', 'pengasuh' => 'Pengasuh', 'donatur' => 'Donatur'] as $val => $label)
                            <option value="{{ $val }}" {{ old('role', $user->role) === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('role')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-sm font-bold text-gray-800 block mb-2">Jabatan</label>
                    <input type="text" name="jabatan" value="{{ old('jabatan', $user->jabatan) }}" placeholder="Contoh: Kepala Pengasuh..."
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm placeholder:text-gray-400">
                </div>
            </div>

            {{-- Status --}}
            <div class="mb-5">
                <label class="text-sm font-bold text-gray-800 block mb-2">Status <span class="text-red-500">*</span></label>
                <div class="flex gap-6 items-center">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="status" value="aktif" {{ old('status', $user->status) === 'aktif' ? 'checked' : '' }} class="w-4 h-4 text-blue-600 focus:ring-blue-500" required>
                        <span class="text-gray-700 font-medium">Aktif</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="status" value="tidak_aktif" {{ old('status', $user->status) === 'tidak_aktif' ? 'checked' : '' }} class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                        <span class="text-gray-700 font-medium">Tidak Aktif</span>
                    </label>
                </div>
            </div>

            {{-- Jenis Kelamin --}}
            <div class="mb-5">
                <label class="text-sm font-bold text-gray-800 block mb-2">Jenis Kelamin</label>
                <div class="flex gap-6 items-center">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="jenis_kelamin" value="L" {{ old('jenis_kelamin', $user->jenis_kelamin) === 'L' ? 'checked' : '' }} class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                        <span class="text-gray-700 font-medium">Laki-laki</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="jenis_kelamin" value="P" {{ old('jenis_kelamin', $user->jenis_kelamin) === 'P' ? 'checked' : '' }} class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                        <span class="text-gray-700 font-medium">Perempuan</span>
                    </label>
                </div>
            </div>

            {{-- Tempat & Tanggal Lahir --}}
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 mb-5">
                <div>
                    <label class="text-sm font-bold text-gray-800 block mb-2">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $user->tempat_lahir) }}" placeholder="Masukkan Tempat Lahir..."
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm placeholder:text-gray-400">
                </div>
                <div>
                    <label class="text-sm font-bold text-gray-800 block mb-2">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm text-gray-500">
                </div>
            </div>

            {{-- No HP --}}
            <div class="mb-5">
                <label class="text-sm font-bold text-gray-800 block mb-2">No. HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" placeholder="Contoh: 0812xxxxxxxx..."
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm placeholder:text-gray-400">
            </div>

            {{-- Alamat --}}
            <div class="mb-5">
                <label class="text-sm font-bold text-gray-800 block mb-2">Alamat</label>
                <textarea name="alamat" rows="3" placeholder="Masukkan Alamat lengkap..."
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm placeholder:text-gray-400 resize-none">{{ old('alamat', $user->alamat) }}</textarea>
            </div>

            {{-- Foto --}}
            <div class="mb-8">
                <label class="text-sm font-bold text-gray-800 block mb-2">Foto Profil</label>
                @if($user->foto)
                    <div class="mb-3">
                        <p class="text-sm text-gray-500 mb-1">Foto saat ini:</p>
                        <img src="{{ asset('storage/' . $user->foto) }}" class="w-32 h-32 object-cover rounded-lg border border-gray-200">
                    </div>
                @endif
                <input type="file" id="foto_input" name="foto" accept="image/*"
                    class="w-full text-sm text-gray-600 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100 cursor-pointer border border-gray-200 rounded-xl bg-gray-50">
                <div id="preview_container" class="mt-3 hidden">
                    <img id="foto_preview" src="#" alt="Preview Foto" class="max-h-48 w-auto rounded-lg object-cover border border-gray-200 shadow-sm">
                    <button type="button" id="remove_preview" class="mt-2 text-sm text-red-600 hover:text-red-700 font-medium focus:outline-none">Hapus Foto</button>
                </div>
                <p class="text-xs text-gray-500 mt-2">Biarkan kosong jika tidak ingin mengubah foto. Format: JPG, PNG, JPEG. Maksimal 2MB.</p>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-center items-center gap-4 pt-6 border-t border-gray-200 mt-6 pb-2">
                <a href="{{ route('users.index') }}" class="rounded-xl bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 border border-gray-300 transition hover:bg-gray-300">
                    Batal
                </a>
                <button type="submit" class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    setupImagePreview('foto_input', 'preview_container', 'foto_preview', 'remove_preview');
});
</script>
@endpush
