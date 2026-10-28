@extends('layouts.app')
@section('page-title', 'Tambah Galeri')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Main Content Card -->
    <div class="overflow-hidden rounded-2xl bg-white shadow-sm border border-gray-200">
        
        <!-- Header / Banner Cover -->
        <div class="relative bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-6 sm:px-8 sm:py-7">
            <div class="flex flex-row items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-white sm:text-2xl">Tambah Data Galeri</h2>
                    <p class="text-sm text-blue-100 mt-0.5">Formulir Penambahan Data Galeri.</p>
                </div>
                <!-- Tombol Kembali -->
                <a href="{{ route('galeri.index') }}" 
                   class="inline-flex items-center gap-2 rounded-xl bg-white/20 backdrop-blur-sm border border-white/30 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-white/30 transition flex-shrink-0" 
                   title="Kembali">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span class="hidden sm:inline">Kembali</span>
                </a>
            </div>
        </div>

        <form action="{{ route('galeri.store') }}" method="POST" enctype="multipart/form-data" class="p-4 md:p-6">
            @csrf

            <div class="mb-5">
                <label class="mb-1.5 block text-sm font-semibold text-gray-800">Judul Foto <span class="text-red-500">*</span></label>
                <input type="text" name="judul" value="{{ old('judul') }}" placeholder="Cth: Kegiatan belajar bersama"
                    class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="mb-5">
                <label class="mb-1.5 block text-sm font-semibold text-gray-800">Kategori <span class="text-red-500">*</span></label>
                <select name="kategori" id="kategori"
                    class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none"
                    required>
                    <option value="" disabled selected>Pilih Kategori</option>
                    <option class="text-gray-900" value="Umum">Umum</option>
                    <option class="text-gray-900" value="Fasilitas">Fasilitas Panti</option>
                </select>
            </div>

            <div class="mb-5">
                <label class="mb-1.5 block text-sm font-semibold text-gray-800">Deskripsi Foto <span class="text-red-500">*</span></label>
                <textarea name="deskripsi" rows="2"
                    class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder:text-gray-400"
                    required
                    placeholder="Masukkan deskripsi foto...">{{ old('deskripsi') }}</textarea>
            </div>

            <!-- Upload Foto Galeri -->
            <div class="mb-8">
                <label class="mb-1.5 block text-sm font-semibold text-gray-800">Upload Foto Galeri <span class="text-red-500">*</span></label>
                <input type="file" id="foto_input" name="foto" accept="image/*"
                    class="w-full text-sm text-gray-600 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100 cursor-pointer border border-gray-200 rounded-xl bg-gray-50"
                    required>
                <div id="preview_container" class="mt-3 hidden">
                    <img id="foto_preview" src="#" alt="Preview Foto" class="max-h-48 w-auto rounded-lg object-cover border border-gray-200 shadow-sm">
                    <button type="button" id="remove_preview" class="mt-2 text-sm text-red-600 hover:text-red-700 font-medium focus:outline-none">Hapus Foto</button>
                </div>
                <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG, JPEG. Maksimal 2MB.</p>
            </div>

            <div class="flex justify-center items-center gap-4 pt-6 border-t border-gray-200 mt-6 pb-2">
                <a href="{{ route('galeri.index') }}" class="rounded-xl bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 border border-gray-300 transition hover:bg-gray-300">
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    setupImagePreview('foto_input', 'preview_container', 'foto_preview', 'remove_preview');
});
</script>
@endpush
