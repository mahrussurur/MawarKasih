@extends('layouts.app')
@section('page-title', 'Data Kegiatan')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
        
        <!-- Header / Tombol Kembali -->
        <div class="bg-gray-50 border-b border-gray-100 px-6 py-4 flex justify-between items-center">
            <div>
                <h2 class="text-lg font-bold text-gray-800">Detail Kegiatan</h2>
                <p class="text-sm text-gray-500">Informasi lengkap kegiatan.</p>
            </div>
            <a href="{{ route('kegiatan.index') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-800 flex items-center transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>

        <!-- Area Konten Utama -->
        <div class="p-6 sm:p-10">
            
            <!-- Area Foto Besar -->
            <div class="mb-8 w-full h-64 sm:h-96 bg-gray-100 rounded-lg overflow-hidden border border-gray-200 relative">
                @if($kegiatan->foto_dokumentasi)
                    <img src="{{ asset('storage/' . $kegiatan->foto_dokumentasi) }}" alt="{{ $kegiatan->nama_kegiatan }}" class="w-full h-full object-cover">
                @else
                    <div class="absolute inset-0 flex flex-col items-center justify-center text-gray-400">
                        <svg class="w-16 h-16 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="text-sm font-medium">Tidak ada foto dokumentasi</p>
                    </div>
                @endif
            </div>

            <!-- Judul & Tanggal -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $kegiatan->nama_kegiatan }}</h1>
                <div class="flex items-center text-sm font-medium text-[#1a56db]">
                    <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    {{ \Carbon\Carbon::parse($kegiatan->tanggal_pelaksanaan)->translatedFormat('l, d F Y') }}
                </div>
            </div>

            <!-- Garis Pemisah -->
            <hr class="border-gray-100 mb-6">

            <!-- Deskripsi Lengkap -->
            <div class="prose max-w-none text-gray-700 leading-relaxed">
                <h3 class="text-lg font-bold text-gray-800 mb-3">Deskripsi Kegiatan:</h3>
                <!-- nl2br digunakan agar enter/paragraf yang diketik admin terbaca rapi -->
                <p>{!! nl2br(e($kegiatan->deskripsi)) !!}</p> 
            </div>

        </div>
    </div>
</div>
@endsection