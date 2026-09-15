@extends('layouts.app')
@section('title', 'Upload Dokumen')
@section('page-title', 'Upload Dokumen')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('sekretaris.dokumen.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-500 hover:text-gray-800 transition">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Daftar Dokumen
        </a>
    </div>
    <form method="POST" action="{{ route('sekretaris.dokumen.store') }}" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8">
        @csrf
        <h3 class="text-lg font-bold text-gray-900 mb-6">Informasi Dokumen</h3>
        <div class="grid gap-5">
            <div>
                <label class="mb-1.5 block text-sm font-semibold text-gray-700">Judul Dokumen <span class="text-red-500">*</span></label>
                <input type="text" name="judul" value="{{ old('judul') }}" placeholder="Contoh: Surat Keputusan No. 001"
                       class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500" required />
                @error('judul') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-700">Nomor Dokumen</label>
                    <input type="text" name="nomor_dokumen" value="{{ old('nomor_dokumen') }}" placeholder="Contoh: SK/001/2025"
                           class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500" />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-700">Jenis Dokumen</label>
                    <input type="text" name="jenis_dokumen" value="{{ old('jenis_dokumen') }}" placeholder="Contoh: Surat Keputusan"
                           class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500" />
                </div>
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-semibold text-gray-700">Tanggal Dokumen</label>
                <input type="date" name="tanggal_dokumen" value="{{ old('tanggal_dokumen', date('Y-m-d')) }}"
                       class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500" />
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-semibold text-gray-700">File Dokumen <span class="text-red-500">*</span></label>
                <input type="file" name="file_dokumen" accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png"
                       class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500" required />
                <p class="mt-1 text-xs text-gray-500">Format: PDF, DOC, DOCX, XLS, XLSX, JPG, PNG. Maks. 5MB.</p>
                @error('file_dokumen') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-semibold text-gray-700">Keterangan</label>
                <textarea name="keterangan" rows="3" placeholder="Keterangan tambahan (opsional)..."
                          class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500">{{ old('keterangan') }}</textarea>
            </div>
        </div>
        <div class="mt-8 flex justify-end gap-3 border-t border-gray-100 pt-6">
            <a href="{{ route('sekretaris.dokumen.index') }}" class="rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">Batal</a>
            <button type="submit" class="rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 transition">Upload Dokumen</button>
        </div>
    </form>
</div>
@endsection
