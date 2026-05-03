@extends('layouts.app') <!-- Sesuaikan dengan layout dashboard kalian -->

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md border border-gray-100 p-8">
        
        <div class="mb-8 border-b border-gray-100 pb-4">
            <h2 class="text-2xl font-bold text-gray-800">Tambah Kegiatan Baru</h2>
            <p class="text-gray-500 text-sm mt-1">Masukkan detail kegiatan panti asuhan di bawah ini.</p>
        </div>

        <!-- Perhatikan enctype="multipart/form-data", ini WAJIB agar bisa upload foto -->
        <form action="{{ route('kegiatan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Input Nama Kegiatan -->
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Nama Kegiatan</label>
                <input type="text" name="nama_kegiatan" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required placeholder="Contoh: Buka Puasa Bersama">
            </div>

            <!-- Input Tanggal -->
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Tanggal Pelaksanaan</label>
                <input type="date" name="tanggal_pelaksanaan" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <!-- Input Deskripsi -->
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Deskripsi Kegiatan</label>
                <textarea name="deskripsi" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required placeholder="Ceritakan detail kegiatan ini..."></textarea>
            </div>

            <!-- Input Foto -->
            <div class="mb-8">
                <label class="block text-gray-700 font-semibold mb-2">Foto Dokumentasi (Opsional)</label>
                <input type="file" name="foto_dokumentasi" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG, JPEG. Maksimal 2MB.</p>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('kegiatan.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-semibold transition-colors">Batal</a>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-colors">Simpan Kegiatan</button>
            </div>
        </form>

    </div>
</div>
@endsection