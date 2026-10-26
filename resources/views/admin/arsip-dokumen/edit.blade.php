@extends('layouts.app')

@section('title', 'Edit Arsip Dokumen')
@section('page-title', 'Edit Arsip Dokumen')

@section('content')
<div class="space-y-6 max-w-3xl mx-auto">

    <!-- Header & Back Button -->
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('admin.arsip-dokumen.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800 flex items-center gap-1">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Daftar Arsip
                </a>
            </div>
            <h2 class="text-xl font-extrabold text-gray-900">Perbarui Arsip Dokumen</h2>
            <p class="text-xs text-gray-500 mt-0.5">Ubah metadata dokumen atau perbarui berkas dokumen fisik.</p>
        </div>
    </div>

    @if($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm font-medium text-red-800">
            <p class="font-bold mb-1">Terjadi kesalahan input:</p>
            <ul class="list-disc list-inside text-xs space-y-0.5">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8">
        <form method="POST" action="{{ route('admin.arsip-dokumen.update', $arsip) }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Judul / Nama Dokumen <span class="text-red-500">*</span></label>
                <input type="text" name="judul" required value="{{ old('judul', $arsip->judul) }}"
                       class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Nomor Dokumen / Surat</label>
                    <input type="text" name="nomor_dokumen" value="{{ old('nomor_dokumen', $arsip->nomor_dokumen) }}" placeholder="Contoh: 01/SK/MK/2026"
                           class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Kategori Dokumen <span class="text-red-500">*</span></label>
                    <select name="kategori" required class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3.5 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                        @foreach($kategoriList as $kat)
                            <option value="{{ $kat }}" @selected(old('kategori', $arsip->kategori) === $kat)>{{ $kat }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Tanggal Dokumen</label>
                <input type="date" name="tanggal_dokumen" value="{{ old('tanggal_dokumen', $arsip->tanggal_dokumen?->format('Y-m-d')) }}"
                       class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Keterangan / Deskripsi Singkat</label>
                <textarea name="deskripsi" rows="3" placeholder="Catatan atau keterangan mengenai dokumen..."
                          class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20">{{ old('deskripsi', $arsip->deskripsi) }}</textarea>
            </div>

            <div class="rounded-xl border border-blue-100 bg-blue-50/50 p-4">
                <label class="block text-xs font-bold text-gray-800 mb-1">Perbarui Berkas Dokumen (Opsional)</label>
                <p class="text-xs text-gray-500 mb-2">
                    Berkas saat ini: <strong class="text-gray-900 font-mono">{{ $arsip->file_name_asli }}</strong> ({{ $arsip->formatted_file_size }}). Kosongkan jika tidak ingin mengganti berkas fisik.
                </p>
                <input type="file" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.png,.jpg,.jpeg"
                       class="w-full rounded-xl border border-gray-200 bg-white px-3 py-2 text-xs file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200 focus:outline-none">
                <p class="text-[11px] text-gray-400 mt-1">Format didukung: PDF, DOC, DOCX, XLS, XLSX, PNG, JPG (Maks. 10 MB).</p>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.arsip-dokumen.index') }}" class="rounded-xl px-4 py-2.5 text-sm font-semibold text-gray-600 hover:bg-gray-100 transition">Batal</a>
                <button type="submit" class="rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>

</div>
@endsection
