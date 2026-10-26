@extends('layouts.app')
@section('page-title', 'Data Kegiatan')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Main Content Card -->
    <div class="overflow-hidden rounded-2xl bg-white shadow-sm border border-gray-200">
        
        <!-- Header / Banner Cover -->
        <div class="relative bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-6 sm:px-8 sm:py-7">
            <div class="flex flex-row items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-white sm:text-2xl">Detail Kegiatan</h2>
                    <p class="text-sm text-blue-100 mt-0.5">Informasi lengkap dokumentasi dan rincian pelaksanaan kegiatan.</p>
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

        <!-- Layout Grid Content -->
        <div class="grid grid-cols-1 divide-y divide-gray-100 lg:grid-cols-3 lg:divide-x lg:divide-y-0">
            
            <!-- Left Column: Dokumentasi & Deskripsi -->
            <div class="p-6 sm:p-8 lg:col-span-2 space-y-8">
                
                <!-- Foto Dokumentasi -->
                <section>
                    <h3 class="flex items-center text-base font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Foto Dokumentasi
                    </h3>
                    
                    <!-- Frame foto dengan aspect ratio tetap agar tidak gepeng -->
                    <div class="group relative w-full aspect-video overflow-hidden rounded-xl border border-gray-200 bg-gray-100 shadow-sm">
                        <img src="{{ asset('storage/'.$kegiatan->foto_dokumentasi) }}" 
                            alt="Foto {{ $kegiatan->nama_kegiatan }}"
                            class="h-full w-full object-cover cursor-pointer"
                            onclick="openImagePreview('{{ asset('storage/'.$kegiatan->foto_dokumentasi) }}')"
                            title="Klik untuk memperbesar">
                        <div class="absolute inset-0 bg-black/10 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none flex items-center justify-center">
                            <span class="bg-white/90 backdrop-blur-sm text-gray-800 text-xs font-semibold px-3 py-1.5 rounded-lg shadow-sm">Klik untuk memperbesar</span>
                        </div>
                    </div>
                </section>

                <!-- Deskripsi Kegiatan -->
                <section>
                    <h3 class="flex items-center text-base font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                        </svg>
                        Deskripsi Kegiatan
                    </h3>
                    <div class="bg-gray-50 p-5 rounded-xl border border-gray-100 text-sm text-gray-800 leading-relaxed prose prose-sm max-w-none">
                        {!! $kegiatan->deskripsi ?? '<span class="text-gray-400 italic">Tidak ada deskripsi tersedia.</span>' !!}
                    </div>
                </section>

            </div>

            <!-- Right Column: Ringkasan Info & Tombol Aksi -->
            <div class="bg-gray-50/50 p-6 sm:p-8 space-y-8">
                
                <section>
                    <h3 class="flex items-center text-base font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Informasi Pelaksanaan
                    </h3>
                    
                    <div class="space-y-5">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kegiatan</p>
                            <p class="mt-1 text-sm font-bold text-gray-900 leading-snug">{{ $kegiatan->nama_kegiatan }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pelaksanaan</p>
                            <p class="mt-1.5">
                                <span class="inline-flex items-center gap-1.5 rounded-lg bg-blue-50 border border-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ \Carbon\Carbon::parse($kegiatan->tanggal_pelaksanaan)->translatedFormat('d F Y') }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="pt-8 mt-8 border-t border-gray-200 space-y-3">
                        <a href="{{ route('kegiatan.edit', $kegiatan->id) }}" 
                           class="w-full inline-flex items-center justify-center gap-2 rounded-xl border border-amber-200 bg-amber-50 px-4 py-2.5 text-sm font-semibold text-amber-600 shadow-sm transition hover:bg-amber-500 hover:text-white">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit Kegiatan
                        </a>
                        <button type="button"
                                onclick="openDeleteModal(this)"
                                data-delete-route="{{ route('kegiatan.destroy', $kegiatan->id) }}"
                                data-name="{{ $kegiatan->nama_kegiatan }}"
                                class="w-full inline-flex items-center justify-center gap-2 rounded-xl border border-red-200 bg-red-50 px-4 py-2.5 text-sm font-semibold text-red-600 shadow-sm transition hover:bg-red-600 hover:text-white">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus Kegiatan
                        </button>
                    </div>
                </section>

            </div>

        </div>
    </div>
</div>
@endsection

@push('modals')
    @include('layouts.partials.admin.modals')
@endpush