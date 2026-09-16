@extends('layouts.app')

@section('title', 'Edit ' . $roleLabel)
@section('page-title', 'Edit ' . $roleLabel)

@section('content')
@php
    $profile = $usesPengelolaProfile ? $user->profilPengelola : $user->profilDonatur;
@endphp
<div class="mx-auto max-w-3xl">
    <div class="mb-4">
        <a href="{{ route('admin.pengelola.index', $roleFilter) }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-500 transition hover:text-gray-800">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Data {{ $roleLabel }}
        </a>
    </div>

    <form method="POST" action="{{ route('admin.pengelola.update', [$roleFilter, $user->id]) }}" enctype="multipart/form-data" class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
        @csrf @method('PUT')

        @if($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <ul class="ml-4 list-disc space-y-1">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <div class="space-y-5">
            <h3 class="border-b border-gray-100 pb-3 text-sm font-bold uppercase tracking-wide text-gray-500">Data Profil</h3>

            @if($usesPengelolaProfile)
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-700">Foto</label>
                    @if($profile?->foto)
                        <img src="{{ asset('storage/' . $profile->foto) }}" alt="Foto {{ $profile->nama }}" class="mb-2 h-16 w-16 rounded-xl object-cover" />
                    @endif
                    <input type="file" name="foto" accept="image/jpeg,image/png" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500" />
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-sm font-semibold text-gray-700">Nama <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama', $profile?->nama) }}" required class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-semibold text-gray-700">Jabatan</label>
                        <input type="text" name="jabatan" value="{{ old('jabatan', $profile?->jabatan) }}" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500" />
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-sm font-semibold text-gray-700">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $profile?->tempat_lahir) }}" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-semibold text-gray-700">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $profile?->tanggal_lahir?->format('Y-m-d')) }}" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500" />
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-sm font-semibold text-gray-700">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih</option>
                            <option value="L" @selected(old('jenis_kelamin', $profile?->jenis_kelamin) === 'L')>Laki-laki</option>
                            <option value="P" @selected(old('jenis_kelamin', $profile?->jenis_kelamin) === 'P')>Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-semibold text-gray-700">No. HP</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp', $profile?->no_hp) }}" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500" />
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-sm font-semibold text-gray-700">Nama <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama', $profile?->nama) }}" required class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-semibold text-gray-700">No. HP</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp', $profile?->no_hp) }}" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500" />
                    </div>
                </div>
            @endif

            <div>
                <label class="mb-1.5 block text-sm font-semibold text-gray-700">Alamat</label>
                <textarea name="alamat" rows="3" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500">{{ old('alamat', $profile?->alamat) }}</textarea>
            </div>

            <h3 class="border-b border-gray-100 pb-3 pt-3 text-sm font-bold uppercase tracking-wide text-gray-500">Akun Login</h3>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-700">Username <span class="text-red-500">*</span></label>
                    <input type="text" name="username" value="{{ old('username', $user->username) }}" required autocomplete="username" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500" />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-700">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500" />
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-700">Password Baru</label>
                    <input type="password" name="password" autocomplete="new-password" placeholder="Kosongkan jika tidak diubah" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500" />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-700">Status <span class="text-red-500">*</span></label>
                    <select name="status" required class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                        <option value="aktif" @selected(old('status', $user->status) === 'aktif')>Aktif</option>
                        <option value="tidak_aktif" @selected(old('status', $user->status) === 'tidak_aktif')>Tidak Aktif</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="mt-8 flex justify-end gap-3 border-t border-gray-100 pt-6">
            <a href="{{ route('admin.pengelola.index', $roleFilter) }}" class="rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">Batal</a>
            <button type="submit" class="rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
