@extends('layouts.app')
@section('page-title', 'Arsip Dokumen Administrasi')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Main Content Card -->
    <div class="overflow-hidden rounded-2xl bg-white shadow-sm border border-gray-200">
        
        <!-- Header / Banner Cover -->
        <div class="relative bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-6 sm:px-8 sm:py-7">
            <div class="flex flex-row items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-white sm:text-2xl">Detail Arsip Dokumen</h2>
                    <p class="text-sm text-blue-100 mt-0.5">Informasi lengkap berkas dan arsip dokumen digital.</p>
                </div>
                <!-- Tombol Kembali -->
                <a href="{{ route('ketua.arsip-dokumen.index') }}" 
                   class="inline-flex items-center gap-2 rounded-xl bg-white/20 backdrop-blur-sm border border-white/30 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-white/30 transition flex-shrink-0" 
                   title="Kembali">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span class="hidden sm:inline">Kembali</span>
                </a>
            </div>
        </div>

        <!-- Layout Grid Content -->
        <div class="grid grid-cols-1 divide-y divide-gray-100 lg:grid-cols-3 lg:divide-x lg:divide-y-0">
            
            <!-- Left Column: Informasi Utama & Berkas -->
            <div class="p-6 sm:p-8 lg:col-span-2 space-y-8">
                
                <!-- Informasi Dokumen -->
                <section>
                    <h3 class="flex items-center text-base font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Informasi Dokumen
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Dokumen</p>
                            <p class="mt-1 text-sm font-bold text-gray-900">{{ $arsip->judul }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Dokumen</p>
                            <p class="mt-1 text-sm font-mono font-semibold text-gray-800">{{ $arsip->nomor_dokumen ?: '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Dokumen / Surat</p>
                            <p class="mt-1 text-sm font-semibold text-gray-800">
                                {{ $arsip->tanggal_dokumen ? $arsip->tanggal_dokumen->format('d F Y') : '-' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Diupload Oleh</p>
                            <p class="mt-1 text-sm font-semibold text-gray-800">
                                {{ $arsip->uploader?->nama ?? 'Admin LKSA' }}
                                <span class="block text-xs font-normal text-gray-500">({{ $arsip->uploader?->email ?? '-' }})</span>
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Informasi Berkas Digital -->
                <section>
                    <h3 class="flex items-center text-base font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        Informasi Berkas Digital
                    </h3>
                    <div class="rounded-xl border border-gray-200 bg-gray-50/50 p-4">
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
                </section>

                <!-- Keterangan / Catatan -->
                <section>
                    <h3 class="flex items-center text-base font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                        </svg>
                        Keterangan / Catatan
                    </h3>
                    <div class="bg-gray-50 p-5 rounded-xl border border-gray-100 text-sm text-gray-800 leading-relaxed break-words">
                        {{ $arsip->deskripsi ?: 'Tidak ada keterangan tambahan untuk dokumen ini.' }}
                    </div>
                </section>

            </div>

            <!-- Right Column: Meta Data & Tombol Aksi -->
            <div class="bg-gray-50/50 p-6 sm:p-8 space-y-8">
                
                <section>
                    <h3 class="flex items-center text-base font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Meta Data Arsip
                    </h3>
                    
                    <div class="space-y-5">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori Dokumen</p>
                            <p class="mt-1.5">
                                <span class="inline-flex items-center rounded-lg border border-blue-100 bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700">
                                    {{ $arsip->kategori }}
                                </span>
                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Upload</p>
                            <p class="mt-1.5">
                                <span class="inline-flex items-center gap-1.5 rounded-lg bg-gray-100 border border-gray-200 px-3 py-1 text-xs font-semibold text-gray-700">
                                    <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $arsip->created_at->format('d M Y, H:i') }} WIB
                                </span>
                            </p>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="pt-8 mt-8 border-t border-gray-200 space-y-3">
                        <a href="{{ route('ketua.arsip-dokumen.download', $arsip) }}" 
                           class="w-full inline-flex items-center justify-center gap-2 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-2.5 text-sm font-semibold text-emerald-600 shadow-sm transition hover:bg-emerald-600 hover:text-white">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Unduh Berkas
                        </a>
                    </div>
                </section>

            </div>

        </div>
    </div>
</div>
@endsection