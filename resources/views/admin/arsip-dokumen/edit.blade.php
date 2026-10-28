@extends('layouts.app')
@section('page-title', 'Arsip Dokumen Administrasi')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Main Content Card -->
    <div class="overflow-hidden rounded-2xl bg-white shadow-sm border border-gray-200">
        
        <!-- Header / Banner Cover -->
        <div class="relative bg-gradient-to-r from-amber-500 to-amber-600 px-6 py-6 sm:px-8 sm:py-7">
            <div class="flex flex-row items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-white sm:text-2xl">Edit Arsip Dokumen</h2>
                    <p class="text-sm text-amber-100 mt-0.5">perbarui berkas dokumen atau ubah metadata dokumen.</p>
                </div>
                <!-- Tombol Kembali -->
                <a href="{{ route('admin.arsip-dokumen.index') }}" 
                   class="inline-flex items-center gap-2 rounded-xl bg-white/20 backdrop-blur-sm border border-white/30 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-white/30 transition flex-shrink-0" 
                   title="Kembali">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span class="hidden sm:inline">Kembali</span>
                </a>
            </div>
        </div>

        <form action="{{ route('admin.arsip-dokumen.update', $arsip) }}" method="POST" enctype="multipart/form-data" class="p-4 md:p-6">
            @csrf
            @method('PUT')

            <!-- Pesan Error Validation -->
            @if($errors->any())
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm font-medium text-red-800">
                    <p class="font-bold mb-1">Terjadi kesalahan input:</p>
                    <ul class="list-disc list-inside text-xs space-y-0.5">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <h3 class="text-sm font-bold text-gray-800 mb-4 border-b border-gray-200 pb-2">Informasi & Metadata Dokumen</h3>

            <!-- Judul / Nama Dokumen -->
            <div class="mb-5">
                <label class="mb-1.5 block text-sm font-semibold text-gray-800">Judul / Nama Dokumen <span class="text-red-500">*</span></label>
                <input type="text" name="judul" required value="{{ old('judul', $arsip->judul) }}" placeholder="Contoh: Akta Notaris Pendirian Yayasan"
                       class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Nomor Dokumen & Kategori Dokumen -->
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 mb-5">
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-800">Nomor Dokumen / Surat</label>
                    <input type="text" name="nomor_dokumen" value="{{ old('nomor_dokumen', $arsip->nomor_dokumen) }}" placeholder="Contoh: 01/SK/MK/2026"
                           class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-800">Kategori Dokumen <span class="text-red-500">*</span></label>
                    <select name="kategori" required class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-800 invalid:text-gray-400 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="" disabled class="text-gray-400">Pilih Kategori...</option>
                        @foreach($kategoriList as $kat)
                            <option value="{{ $kat }}" @selected(old('kategori', $arsip->kategori) === $kat) class="text-gray-800 bg-white">{{ $kat }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Tanggal Dokumen -->
            <div class="mb-5">
                <label class="mb-1.5 block text-sm font-semibold text-gray-800">Tanggal Dokumen</label>
                <input type="date" name="tanggal_dokumen" value="{{ old('tanggal_dokumen', $arsip->tanggal_dokumen?->format('Y-m-d')) }}"
                       class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Keterangan / Deskripsi Singkat -->
            <div class="mb-5">
                <label class="mb-1.5 block text-sm font-semibold text-gray-800">Keterangan / Deskripsi Singkat</label>
                <textarea name="deskripsi" rows="3" placeholder="Catatan atau keterangan mengenai dokumen..."
                          class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('deskripsi', $arsip->deskripsi) }}</textarea>
            </div>

            <!-- Perbarui Berkas Dokumen (Opsional) -->
            <div class="mb-5 rounded-xl border border-amber-200 bg-amber-50/40 p-4">
                <label class="mb-1.5 block text-sm font-semibold text-gray-800">Perbarui Berkas Dokumen (Opsional)</label>
                <p class="text-xs text-gray-600 mb-2">
                    Berkas saat ini: <strong class="text-gray-900 font-mono">{{ $arsip->file_name_asli }}</strong> ({{ $arsip->formatted_file_size }}). Kosongkan jika tidak ingin mengganti berkas fisik.
                </p>
                <input type="file" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.png,.jpg,.jpeg"
                       class="w-full rounded-xl border border-gray-200 bg-white px-3 py-2 text-xs file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-amber-100 file:text-amber-700 hover:file:bg-amber-200 focus:outline-none">
                <p class="text-[11px] text-gray-400 mt-1">Format didukung: PDF, DOC, DOCX, XLS, XLSX, PNG, JPG (Maks. 10 MB).</p>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-center items-center gap-4 pt-6 border-t border-gray-200 mt-6 pb-2">
                <a href="{{ route('admin.arsip-dokumen.index') }}" class="rounded-xl bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 border border-gray-300 transition hover:bg-gray-300">
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