@extends('layouts.app')
@section('page-title', 'Edit Donatur')

@section('content')
<div class="max-w-3xl mx-auto overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
        
        <!-- Header -->
        <div class="border-b border-gray-200 bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex justify-between items-center gap-4">
            <div class="min-w-0">
                <h2 class="text-lg font-bold text-white truncate">Edit Data Donatur</h2>
                <p class="text-xs md:text-sm text-gray-300">Ubah detail data donatur di bawah ini.</p>
            </div>
            <a href="{{ route('donatur.index') }}" class="text-xs md:text-sm font-semibold text-white hover:text-gray-400 flex items-center transition-colors whitespace-nowrap">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="hidden sm:inline">Kembali</span>
            </a>
        </div>

        <div class="p-4 md:p-6">
            <form action="{{ route('donatur.update', $donatur->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="mb-5">
                    <label class="text-sm font-bold text-gray-800 block mb-2">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama', $donatur->nama) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm placeholder:text-gray-400" required>
                </div>

                <div class="mb-5">
                    <label class="text-sm font-bold text-gray-800 block mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', $donatur->email) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm placeholder:text-gray-400" required>
                </div>

                <div class="mb-5">
                    <label class="text-sm font-bold text-gray-800 block mb-2">No. HP</label>
                    <input type="number" name="no_hp" value="{{ old('no_hp', $donatur->no_hp) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm placeholder:text-gray-400" required>
                </div>

                <div class="mb-5">
                    <label class="text-sm font-bold text-gray-800 block mb-2">Alamat</label>
                    <textarea name="alamat" rows="2" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm placeholder:text-gray-400" required>{{ old('alamat', $donatur->alamat) }}</textarea>
                </div>

                <div class="mb-8">
                    <label class="text-sm font-bold text-gray-800 block mb-2">Status</label>
                    <div class="flex gap-6 items-center">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status" value="aktif" class="w-4 h-4 text-blue-600 focus:ring-blue-500" {{ old('status', 'aktif') == 'aktif' ? 'checked' : '' }} required>
                            <span class="text-gray-700 font-medium">Aktif</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status" value="tidak_aktif" class="w-4 h-4 text-blue-600 focus:ring-blue-500" {{ old('status') == 'tidak_aktif' ? 'checked' : '' }}>
                            <span class="text-gray-700 font-medium">Tidak Aktif</span>
                        </label>
                    </div>
                </div>

                <div class="flex justify-center items-center gap-4 pt-6 border-t border-gray-200 mt-6 pb-2">
                    <a href="{{ route('donatur.index') }}" class="rounded-xl bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 border border-gray-300 transition hover:bg-gray-300">
                        Batal
                    </a>
                    <button type="submit" class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700">
                        Update
                    </button>
                </div>
        </div>
    </div>
@endsection
