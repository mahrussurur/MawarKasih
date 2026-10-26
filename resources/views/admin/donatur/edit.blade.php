@extends('layouts.app')
@section('page-title', 'Data Donatur')

@section('content')
@php
    $profile = $donatur->profilDonatur;
@endphp
<div class="max-w-4xl mx-auto">
    <!-- Main Content Card -->
    <div class="overflow-hidden rounded-2xl bg-white shadow-sm border border-gray-200">
        
        <!-- Header / Banner Cover -->
        <div class="relative bg-gradient-to-r from-amber-500 to-amber-600 px-6 py-6 sm:px-8 sm:py-7">
            <div class="flex flex-row items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-white sm:text-2xl">Edit Profil Donatur</h2>
                    <p class="text-sm text-amber-100 mt-0.5">Perbarui informasi profil donatur.</p>
                </div>
                <!-- Tombol Kembali -->
                <a href="{{ route('admin.donatur.index') }}" 
                   class="inline-flex items-center gap-2 rounded-xl bg-white/20 backdrop-blur-sm border border-white/30 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-white/30 transition flex-shrink-0" 
                   title="Kembali">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span class="hidden sm:inline">Kembali</span>
                </a>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.donatur.update', $donatur->id) }}" class="p-4 md:p-6">
            @csrf
            @method('PUT')

            <div class="space-y-5">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-sm font-semibold text-gray-800">Nama <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama', $profile?->nama ?? $donatur->username) }}" required class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-semibold text-gray-800">No. HP</label>
                        <input type="tel" name="no_hp" value="{{ old('no_hp', $profile?->no_hp) }}" minlength="10" maxlength="15" placeholder="cth. 081234567890" pattern="[0-9]{10,15}" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        @error('no_hp')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-800">Alamat</label>
                    <textarea name="alamat" rows="3" class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('alamat', $profile?->alamat) }}</textarea>
                </div>

                <div class="border-t border-gray-200 pt-4">
                    <p class="text-xs font-bold uppercase tracking-wide text-gray-500 mb-4">Akun Login</p>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-sm font-semibold text-gray-800">Username <span class="text-red-500">*</span></label>
                            <input type="text" name="username" value="{{ old('username', $donatur->username) }}" required class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-semibold text-gray-800">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email', $donatur->email) }}" required class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 mt-4">
                        <div>
                            <label class="mb-1.5 block text-sm font-semibold text-gray-800">Status Akun</label>
                            <select name="status" class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="aktif" @selected(old('status', $donatur->status) === 'aktif')>Aktif</option>
                                <option value="nonaktif" @selected(old('status', $donatur->status) === 'nonaktif')>Nonaktif</option>
                            </select>
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-semibold text-gray-800">Password Baru</label>
                            <input type="password" name="password" placeholder="Kosongkan jika tidak diubah" class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-center items-center gap-4 pt-6 border-t border-gray-200 mt-6 pb-2">
                <a href="{{ route('admin.donatur.index') }}" class="rounded-xl bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 border border-gray-300 transition hover:bg-gray-300">
                    Batal
                </a>
                <button type="submit" class="rounded-xl bg-green-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-green-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
