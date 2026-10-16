@extends('layouts.app')
@section('page-title', 'Data Kegiatan')

@section('content')
<div class="max-w-3xl mx-auto overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm my-4">
        
        <div class="border-b border-gray-200 bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex justify-between items-center gap-4">
            <div class="min-w-0">
                <h2 class="text-lg font-bold text-white truncate">Detail Kegiatan</h2>
                <p class="text-xs md:text-sm text-gray-200">Informasi lengkap kegiatan.</p>
            </div>
            <a href="{{ route('sekretaris.kegiatan.index') }}" class="text-xs md:text-sm font-semibold text-white hover:text-gray-200 flex items-center transition-colors whitespace-nowrap">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="hidden sm:inline">Kembali</span>
            </a>
        </div>

        <div class="p-6 sm:p-6">
            <!-- Layout: Foto di atas -->
            <div class="flex flex-col gap-6 items-center">

                <!-- Foto Section -->
                <div class="flex flex-col items-center gap-3 flex-shrink-0">
                    <button type="button"
                            onclick="openImagePreview('{{ asset('storage/'.$kegiatan->foto_dokumentasi) }}')"
                            aria-label="Perbesar foto {{ $kegiatan->nama_kegiatan }}">
                        <img src="{{ asset('storage/'.$kegiatan->foto_dokumentasi) }}"
                            class="w-40 md:w-80 aspect-video rounded-lg border-2 border-gray-200 cursor-pointer transition duration-200 hover:scale-105"
                            alt="Foto {{ $kegiatan->nama_kegiatan }}"
                            title="Klik untuk perbesar">
                    </button>
                    <div class="text-center">
                        <span class="text-base md:text-lg font-bold text-gray-900 block truncate max-w-[180px] md:max-w-none">
                            {{ $kegiatan->nama_kegiatan }}
                        </span>
                        <span class="inline-block mt-1 px-3 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                            {{ \Carbon\Carbon::parse($kegiatan->tanggal_pelaksanaan)->translatedFormat('d F Y') }}
                        </span>
                    </div>
                </div>

                <div class="border-t border-gray-200 my-1 w-full"></div>

                <!-- Detail Section -->
                <div class="w-full space-y-2.5">
                    <!-- Deskripsi Lengkap -->
                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-28 flex-shrink-0">Deskripsi</span>
                            <span class="text-gray-400">:</span>
                            <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden prose prose-sm max-w-none">{!! $kegiatan->deskripsi ?? '-' !!}</span>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>



@endsection
