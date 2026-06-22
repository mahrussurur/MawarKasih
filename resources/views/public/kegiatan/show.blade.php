{{-- =========================================================================
     KEGIATAN SHOW — resources/views/public/pages/kegiatan/show.blade.php
     Controller : App\Http\Controllers\Public\KegiatanPublicController@show($id)
     TODO       : Halaman detail kegiatan — belum dibuat lengkap.
                  Data yang perlu di-pass:
                    - $kegiatan : instance model Kegiatan (findOrFail)
     ========================================================================= --}}

@extends('public.layouts.app')
@section('title', ($kegiatan->nama_kegiatan ?? 'Detail Kegiatan').' — Panti Asuhan Mawar Kasih')

@section('content')
<div class="bg-gray-50 py-12 lg:py-20 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <a href="{{ route('public.kegiatan.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-brand-600 mb-8 transition">
            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Daftar Kegiatan
        </a>

        <div class="bg-white rounded-[28px] overflow-hidden shadow-sm border border-gray-100">
            @if($kegiatan->foto_dokumentasi)
                <img src="{{ asset('storage/' . $kegiatan->foto_dokumentasi) }}" alt="{{ $kegiatan->nama_kegiatan }}" class="w-full h-80 md:h-[400px] object-cover">
            @else
                <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                    <svg class="w-16 h-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            @endif

            <div class="p-8 md:p-12">
                <div class="flex items-center gap-2 mb-4 text-brand-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="font-medium text-sm">{{ \Carbon\Carbon::parse($kegiatan->tanggal_pelaksanaan)->translatedFormat('l, d F Y') }}</span>
                </div>

                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-8 leading-tight" style="font-family:'Playfair Display',serif">
                    {{ $kegiatan->nama_kegiatan }}
                </h1>

                <div class="prose prose-lg max-w-none prose-brand text-gray-700 leading-relaxed">
                    {!! nl2br(e($kegiatan->deskripsi)) !!}
                </div>
                
                <div class="mt-12 pt-8 border-t border-gray-100 text-center">
                    <p class="text-gray-500 mb-6">Ingin mendukung kegiatan-kegiatan panti asuhan kami?</p>
                    <a href="{{ route('public.donasi.form') }}" class="inline-flex rounded-full bg-brand-600 px-8 py-3 text-sm font-semibold text-white transition hover:bg-brand-700 shadow-sm">
                        Donasi Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection