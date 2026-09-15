@extends('layouts.app')
@section('title', 'Edit Dokumen')
@section('page-title', 'Edit Dokumen')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('admin.dokumen.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-500 hover:text-gray-800 transition">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Daftar Dokumen
        </a>
    </div>
    <form method="POST" action="{{ route('admin.dokumen.update', $dokumen->id) }}" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8">
        @csrf @method('PUT')
        <h3 class="text-lg font-bold text-gray-900 mb-6">Ubah Dokumen</h3>
        <div class="grid gap-5">
            <div>
                <label class="mb-1.5 block text-sm font-semibold text-gray-700">Judul Dokumen <span class="text-red-500">*</span></label>
                <input type="text" name="judul" value="{{ old('judul', $dokumen->judul) }}"
                       class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500" required />
                @error('judul') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-700">Nomor Dokumen</label>
                    <input type="text" name="nomor_dokumen" value="{{ old('nomor_dokumen', $dokumen->nomor_dokumen) }}"
                           class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500" />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-700">Jenis Dokumen</label>
                    <input type="text" name="jenis_dokumen" value="{{ old('jenis_dokumen', $dokumen->jenis_dokumen) }}"
                           class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500" />
                </div>
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-semibold text-gray-700">Tanggal Dokumen</label>
                <input type="date" name="tanggal_dokumen" value="{{ old('tanggal_dokumen', $dokumen->tanggal_dokumen?->format('Y-m-d')) }}"
                       class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500" />
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-semibold text-gray-700">Ganti File (opsional)</label>
                @if($dokumen->file_path)
                    <a href="{{ asset('storage/' . $dokumen->file_path) }}" target="_blank" class="mb-2 inline-flex items-center gap-1 text-xs text-blue-600 hover:underline">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        Lihat file saat ini
                    </a>
                @endif
                <input type="file" name="file_dokumen" accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png"
                       class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500" />
                <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ingin mengganti file.</p>
                @error('file_dokumen') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-semibold text-gray-700">Keterangan</label>
                <textarea name="keterangan" rows="3"
                          class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500">{{ old('keterangan', $dokumen->keterangan) }}</textarea>
            </div>
        </div>
        <div class="mt-8 flex justify-end gap-3 border-t border-gray-100 pt-6">
            <a href="{{ route('admin.dokumen.index') }}" class="rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">Batal</a>
            <button type="submit" class="rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 transition">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection

