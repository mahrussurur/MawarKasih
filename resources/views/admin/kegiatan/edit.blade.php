@extends('layouts.app') 
@section('page-title', 'Data Kegiatan')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Main Content Card -->
    <div class="overflow-hidden rounded-2xl bg-white shadow-sm border border-gray-200">
        
        <!-- Header / Banner Cover -->
        <div class="relative bg-gradient-to-r from-amber-500 to-amber-600 px-6 py-6 sm:px-8 sm:py-7">
            <div class="flex flex-row items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-white sm:text-2xl">Edit Profil Kegiatan</h2>
                    <p class="text-sm text-amber-100 mt-0.5">Perbarui informasi profil kegiatan.</p>
                </div>
                <!-- Tombol Kembali -->
                <a href="{{ route('kegiatan.index') }}" 
                   class="inline-flex items-center gap-2 rounded-xl bg-white/20 backdrop-blur-sm border border-white/30 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-white/30 transition flex-shrink-0" 
                   title="Kembali">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span class="hidden sm:inline">Kembali</span>
                </a>
            </div>
        </div>

        <form action="{{ route('kegiatan.update', $kegiatan->id) }}" method="POST" enctype="multipart/form-data" class="p-4 md:p-6">
            @csrf
            @method('PATCH')
            <!-- Input Nama Kegiatan -->
            <div class="mb-5">
                <label class="mb-1.5 block text-sm font-semibold text-gray-800">Nama Kegiatan <span class="text-red-500">*</span></label>
                <input type="text" name="nama_kegiatan" value="{{ old('nama_kegiatan', $kegiatan->nama_kegiatan) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm placeholder:text-gray-400" required>
            </div>
            <!-- Input Tanggal -->
            <div class="mb-5">
                <label class="mb-1.5 block text-sm font-semibold text-gray-800">Tanggal Pelaksanaan <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal_pelaksanaan" value="{{ old('tanggal_pelaksanaan', $kegiatan->tanggal_pelaksanaan) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm placeholder:text-gray-400" required>
            </div>
            <!-- Input Deskripsi -->
            <div class="mb-5">
                <label class="mb-1.5 block text-sm font-semibold text-gray-800">Deskripsi Kegiatan <span class="text-red-500">*</span></label>
                <input type="hidden" name="deskripsi" id="deskripsi_input">
                <div id="editor-container">{!! old('deskripsi', $kegiatan->deskripsi) !!}</div>
            </div>
            <!-- Input Foto -->
            <div class="mb-8">
                <label class="mb-1.5 block text-sm font-semibold text-gray-800">Foto Dokumentasi</label>
                @if($kegiatan->foto_dokumentasi)
                    <div class="mb-3">
                        <p class="text-xs text-gray-500 mb-1">Foto saat ini:</p>
                        <img src="{{ asset('storage/' . $kegiatan->foto_dokumentasi) }}" class="w-32 h-32 object-cover rounded-lg border border-gray-200">
                    </div>
                @endif
                <input type="file" name="foto_dokumentasi" accept="image/*" class="w-full text-sm text-gray-600 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100 cursor-pointer border border-gray-200 rounded-xl bg-gray-50">
                <p class="text-xs text-gray-500 mt-2">Biarkan kosong jika tidak ingin mengubah foto. Format: JPG, PNG, JPEG. Maksimal 2MB.</p>
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
    const quill = new Quill('#editor-container', {
        theme: 'snow',
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
