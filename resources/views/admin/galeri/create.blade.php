@extends('admin.layouts.app')
@section('page-title', 'Tambah Galeri')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md border border-gray-100 p-8">

        <div class="mb-8 border-b border-gray-100 pb-4">
            <h2 class="text-2xl font-bold text-gray-800">Tambah Foto Galeri</h2>
            <p class="text-gray-500 text-sm mt-1">Masukkan data foto umum atau fasilitas panti di bawah ini.</p>
        </div>

        <form action="{{ route('galeri.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Judul Foto</label>
                <input type="text" name="judul" value="{{ old('judul') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required placeholder="Contoh: Kegiatan belajar bersama">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Kategori</label>
                <select name="kategori" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="" disabled {{ old('kategori') ? '' : 'selected' }}>Pilih kategori</option>
                    <option value="umum" {{ old('kategori') === 'umum' ? 'selected' : '' }}>Umum</option>
                    <option value="fasilitas" {{ old('kategori') === 'fasilitas' ? 'selected' : '' }}>Fasilitas Panti</option>
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Deskripsi Foto</label>
                <textarea name="deskripsi" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required placeholder="Jelaskan konteks dan isi foto ini.">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="mb-8">
                <label class="block text-gray-700 font-semibold mb-2">Foto</label>
                <input type="file" name="foto" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required>
                <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG, JPEG. Maksimal 2MB.</p>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('galeri.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-semibold transition-colors">Batal</a>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-colors">Simpan Galeri</button>
            </div>
        </form>

    </div>
</div>
@endsection
