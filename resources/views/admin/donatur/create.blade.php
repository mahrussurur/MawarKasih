@extends('admin.layouts.app')
@section('page-title', 'Tambah Donatur')

@section('content')
<div class="p-4 md:p-6 bg-gray-100 min-h-screen">
    
    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow overflow-hidden">

        <!-- Header -->
        <div class="p-2 md:p-4 border-b border-gray-200 flex justify-between items-center gap-4 bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex justify-between items-center">
            <div class="min-w-0">
                <h2 class="text-lg font-bold text-white truncate">Tambah Data Donatur</h2>
                <p class="text-xs md:text-sm text-gray-300">Formulir Penambahan Data Donatur.</p>
            </div>
            <a href="{{ route('donatur.index') }}" class="text-xs md:text-sm font-semibold text-white hover:text-gray-400 flex items-center transition-colors whitespace-nowrap">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="hidden sm:inline">Kembali</span>
            </a>
        </div>

        <div class="p-4 md:p-6">
            <form action="{{ route('donatur.store') }}" method="POST">
                @csrf

                <div class="mb-5">
                    <label class="block text-gray-800 font-semibold mb-2">Nama Lengkap</label>
                    <input type="text" name="nama" placeholder="Masukkan Nama Lengkap..." value="{{ old('nama') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 placeholder:text-sm placeholder:text-gray-400" required>
                </div>

                <div class="mb-5">
                    <label class="block text-gray-800 font-semibold mb-2">Email</label>
                    <input type="email" name="email" placeholder="Masukkan Email..." value="{{ old('email') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 placeholder:text-sm placeholder:text-gray-400" required>
                </div>

                <div class="mb-5">
                    <label class="block text-gray-800 font-semibold mb-2">No. HP</label>
                    <input type="number" name="no_hp" placeholder="Masukkan No. HP..." value="{{ old('no_hp') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 placeholder:text-sm placeholder:text-gray-400" required>
                </div>

                <div class="mb-5">
                    <label class="block text-gray-800 font-semibold mb-2">Alamat</label>
                    <textarea name="alamat" rows="2" placeholder="Masukkan Alamat..." class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 placeholder:text-sm placeholder:text-gray-400" required>{{ old('alamat') }}</textarea>
                </div>

                <div class="mb-8">
                    <label class="block text-gray-800 font-semibold mb-2">Status</label>
                    <div class="flex gap-6 items-center">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status" value="aktif" class="w-4 h-4 text-blue-600 focus:ring-blue-500" required>
                            <span class="text-gray-700 font-medium">Aktif</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status" value="tidak_aktif" class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                            <span class="text-gray-700 font-medium">Tidak Aktif</span>
                        </label>
                    </div>
                </div>

                <div class="flex justify-center items-center gap-4 pt-6 border-t border-gray-200 mt-6 pb-2">
                    <a href="{{ route('donatur.index') }}" class="rounded-2xl bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 border border-gray-300  transition hover:bg-gray-300">
                        Batal
                    </a>
                    <button type="submit" class="rounded-2xl bg-blue-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-600">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
