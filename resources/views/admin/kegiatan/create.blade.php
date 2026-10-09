@extends('layouts.app')
@section('page-title', 'Data Kegiatan')


@section('content')
<div class="max-w-3xl mx-auto overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
        
        <!-- Header -->
        <div class="border-b border-gray-200 bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex justify-between items-center gap-4">
            <div class="min-w-0">
                <h2 class="text-lg font-bold text-white truncate">Tambah Data Kegiatan</h2>
                <p class="text-xs md:text-sm text-gray-300">Formulir Penambahan Data Kegiatan.</p>
            </div>
            <a href="{{ route('kegiatan.index') }}" class="text-xs md:text-sm font-semibold text-white hover:text-gray-400 flex items-center transition-colors whitespace-nowrap">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="hidden sm:inline">Kembali</span>
            </a>
        </div>

        <div class="p-4 md:p-6">
            <form action="{{ route('kegiatan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Input Nama Kegiatan -->
                <div class="mb-5">
                    <label class="text-sm font-bold text-gray-800 block mb-2">Nama Kegiatan <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_kegiatan" value="{{ old('nama_kegiatan') }}" placeholder="Nama Kegiatan..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm placeholder:text-gray-400" required>
                </div>

                <!-- Input Tanggal -->
                <div class="mb-5">
                    <label class="text-sm font-bold text-gray-800 block mb-2">Tanggal Pelaksanaan <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_pelaksanaan" value="{{ old('tanggal_pelaksanaan') }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm text-gray-500" required>
                </div>

                <!-- Input Deskripsi -->
                <div class="mb-5">
                    <label class="text-sm font-bold text-gray-800 block mb-2">Deskripsi Kegiatan <span class="text-red-500">*</span></label>
                    <input type="hidden" name="deskripsi" id="deskripsi_input">
                    <div id="editor-container">{!! old('deskripsi') !!}</div>
                </div>

                <!-- Input Foto -->
                <div class="mb-8">
                    <label class="text-sm font-bold text-gray-800 block mb-2">Upload Foto Kegiatan <span class="text-red-500">*</span></label>
                    <input type="file" id="foto_input" name="foto_dokumentasi" accept="image/*" class="w-full text-sm text-gray-600 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100 cursor-pointer border border-gray-200 rounded-xl bg-gray-50" required>
                    <div id="preview_container" class="mt-3 hidden">
                        <img id="foto_preview" src="#" alt="Preview Foto" class="max-h-48 w-auto rounded-lg object-cover border border-gray-200 shadow-sm">
                        <button type="button" id="remove_preview" class="mt-2 text-sm text-red-600 hover:text-red-700 font-medium focus:outline-none">Hapus Foto</button>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG, JPEG. Maksimal 2MB.</p>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex justify-center items-center gap-4 pt-6 border-t border-gray-200 mt-6 pb-2">
                    <a href="{{ route('kegiatan.index') }}" class="rounded-xl bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 border border-gray-300 transition hover:bg-gray-300">
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
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<style>
    .ql-toolbar.ql-snow {
        border-color: #e5e7eb;
        border-top-left-radius: 0.75rem;
        border-top-right-radius: 0.75rem;
        background-color: #f9fafb;
    }
    .ql-container.ql-snow {
        border-color: #e5e7eb;
        border-bottom-left-radius: 0.75rem;
        border-bottom-right-radius: 0.75rem;
        background-color: #f9fafb;
        min-height: 150px;
        font-family: inherit;
        font-size: 0.875rem;
    }
    .ql-editor {
        min-height: 150px;
    }
    .ql-editor.ql-blank::before {
        color: #9ca3af;
        font-style: normal;
    }
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    setupImagePreview('foto_input', 'preview_container', 'foto_preview', 'remove_preview');

    const quill = new Quill('#editor-container', {
        theme: 'snow',
        placeholder: 'Deskripsi Kegiatan...',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],
                [{ 'header': 1 }, { 'header': 2 }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link']
            ]
        }
    });

    const deskripsiInput = document.getElementById('deskripsi_input');
    const form = deskripsiInput.closest('form');

    form.addEventListener('submit', function(e) {
        if (quill.getText().trim().length === 0) {
            deskripsiInput.value = '';
        } else {
            deskripsiInput.value = quill.root.innerHTML;
        }
    });
});
</script>
@endpush
