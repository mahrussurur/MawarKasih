@extends('layouts.app')

@section('title', 'Detail Arsip Dokumen')
@section('page-title', 'Detail Arsip Dokumen')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">

    <!-- Header & Action Buttons -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('ketua.arsip-dokumen.index') }}" class="text-xs font-semibold text-teal-600 hover:text-teal-800 flex items-center gap-1">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Daftar Arsip
                </a>
            </div>
            <h2 class="text-xl font-extrabold text-gray-900">{{ $arsip->judul }}</h2>
            @if($arsip->nomor_dokumen)
                <p class="text-xs font-mono text-gray-500 mt-0.5">Nomor: {{ $arsip->nomor_dokumen }}</p>
            @endif
        </div>
        <div class="flex items-center gap-2">
            <!-- Download Button -->
            <a href="{{ route('ketua.arsip-dokumen.download', $arsip) }}" class="inline-flex items-center gap-2 rounded-xl bg-teal-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-teal-700 transition">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                <span>Unduh Berkas</span>
            </a>
        </div>
    </div>

    <!-- Kotak Utama Detail Arsip -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="border-b border-gray-100 bg-gray-50/70 px-6 py-4 flex items-center justify-between">
            <span class="inline-flex rounded-lg bg-teal-50 px-2.5 py-1 text-xs font-bold text-teal-700 ring-1 ring-inset ring-teal-600/20">
                Kategori: {{ $arsip->kategori }}
            </span>
            <span class="text-xs text-gray-500">
                Diupload pada {{ $arsip->created_at->format('d M Y, H:i') }} WIB
            </span>
        </div>

        <div class="p-6 space-y-6">
            <!-- Informasi Dokumen -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Judul Dokumen</h4>
                    <p class="text-base font-bold text-gray-900">{{ $arsip->judul }}</p>
                </div>
                <div>
                    <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Nomor Dokumen</h4>
                    <p class="text-sm font-mono font-medium text-gray-800">{{ $arsip->nomor_dokumen ?: '-' }}</p>
                </div>
                <div>
                    <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Tanggal Dokumen / Surat</h4>
                    <p class="text-sm font-medium text-gray-800">
                        {{ $arsip->tanggal_dokumen ? $arsip->tanggal_dokumen->format('d F Y') : '-' }}
                    </p>
                </div>
                <div>
                    <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Diupload Oleh</h4>
                    <p class="text-sm font-medium text-gray-800">
                        {{ $arsip->uploader?->nama ?? 'Admin LKSA' }}
                        <span class="text-xs text-gray-500">({{ $arsip->uploader?->email ?? '-' }})</span>
                    </p>
                </div>
            </div>

            <!-- Detail Berkas Digital -->
            <div class="rounded-xl border border-gray-200 bg-gray-50/50 p-4">
                <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-3">Informasi Berkas Digital</h4>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                    <div>
                        <span class="text-gray-500 block mb-0.5">Nama File Asli:</span>
                        <span class="font-semibold text-gray-900 break-all">{{ $arsip->file_name_asli }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block mb-0.5">Ukuran File:</span>
                        <span class="font-semibold text-gray-900">{{ $arsip->formatted_file_size }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block mb-0.5">Tipe MIME / Format:</span>
                        <span class="font-mono text-gray-800 uppercase">{{ $arsip->mime_type ?: 'Unknown' }}</span>
                    </div>
                </div>
            </div>

            <!-- Keterangan / Deskripsi -->
            <div>
                <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Keterangan / Catatan</h4>
                <div class="rounded-xl border border-gray-100 bg-gray-50 p-4 text-sm text-gray-700 leading-relaxed">
                    {{ $arsip->deskripsi ?: 'Tidak ada keterangan tambahan untuk dokumen ini.' }}
                </div>
            </div>
        </div>

        <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
            <span>Privat &amp; Rahasia • Dokumen Resmi LKSA Mawar Kasih</span>
            <a href="{{ route('ketua.arsip-dokumen.download', $arsip) }}" class="text-teal-600 hover:text-teal-800 font-bold flex items-center gap-1">
                Unduh Berkas Resmi &rarr;
            </a>
        </div>
    </div>

</div>
@endsection
