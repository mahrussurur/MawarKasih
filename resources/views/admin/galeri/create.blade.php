@extends('admin.layouts.app')
@section('page-title', 'Tambah Galeri')

@section('content')
<div class="p-4 md:p-6 bg-slate-100 h-full">

    <div class="max-w-3xl mx-auto overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <!-- Header -->
        <div class="p-2 md:p-4 border-b border-gray-200 flex justify-between items-center gap-4 bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex justify-between items-center">
            <div class="min-w-0">
                <h2 class="text-lg font-bold text-white truncate">Tambah Data Galeri</h2>
                <p class="text-xs md:text-sm text-gray-300">Formulir Penambahan Data Galeri.</p>
            </div>
            <a href="{{ route('galeri.index') }}" class="text-xs md:text-sm font-semibold text-white hover:text-gray-400 flex items-center transition-colors whitespace-nowrap">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="hidden sm:inline">Kembali</span>
            </a>
        </div>

        <div class="p-4 md:p-6">
            <form action="{{ route('galeri.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-5">
                    <label class="block text-gray-800 font-semibold mb-2">Judul Foto</label>
                    <input type="text" name="judul" value="{{ old('judul') }}" placeholder="Contoh: Kegiatan belajar bersama" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 placeholder:text-sm placeholder:text-gray-400" required>
                </div>

                <div class="mb-5">
                    <label class="block text-gray-800 font-semibold mb-2">Kategori</label>
                    <select name="kategori" id="kategori" 
                        class="w-full h-[46px] appearance-none border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm text-gray-400" 
                        required 
                        onchange="this.classList.remove('text-gray-400','text-sm'); this.classList.add('text-gray-900')">
                        
                        <option value="" disabled selected>Pilih Kategori</option>
                        <option class="text-gray-900" value="Umum">Umum</option>
                        <option class="text-gray-900" value="Fasilitas">Fasilitas Panti</option>
                    </select>
                </div>

                <div class="mb-5">
                    <label class="block text-gray-800 font-semibold mb-2">Deskripsi Foto</label>
                    <textarea name="deskripsi" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 placeholder:text-sm placeholder:text-gray-400" required placeholder="Jelaskan konteks dan isi foto ini.">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="mb-8">
                    <label class="block text-gray-800 font-semibold mb-2">Upload Foto Galeri</label>
                    <input type="file" name="foto" accept="image/*" class="w-full rounded-2xl file:mr-4 file:py-2 file:px-4 file:rounded-2xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-[#1a56db] hover:file:bg-blue-100 cursor-pointer" required>
                    <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG, JPEG. Maksimal 2MB.</p>
                </div>

                <div class="flex justify-center items-center gap-4 pt-6 border-t border-gray-200 mt-6 pb-2">
                    <a href="{{ route('galeri.index') }}" class="rounded-2xl bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 border border-gray-300  transition hover:bg-gray-300">Batal</a>
                    <button type="submit" class="rounded-2xl bg-blue-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-600">
                        Simpan
                    </button>
                </div>
            </form>

        </div>

    </div>
</div>
@endsection
