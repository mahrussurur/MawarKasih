{{-- =========================================================================
     KEGIATAN INDEX — resources/views/public/pages/kegiatan/index.blade.php
     Controller : App\Http\Controllers\Public\KegiatanPublicController@index
     TODO       : Halaman ini belum dibuat lengkap.
                  Data yang perlu di-pass controller:
                    - $kegiatans : paginate dari model Kegiatan (ordered by tanggal desc)
                    - $kategoriList : distinct nilai kolom 'kategori' untuk filter
     ========================================================================= --}}

@extends('public.layouts.app')
@section('title', 'Kegiatan — Panti Asuhan Mawar Kasih')

@section('content')
<div class="bg-gray-50 py-20 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4" style="font-family:'Playfair Display',serif">Kegiatan Panti Asuhan</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">Ikuti dan dukung berbagai kegiatan positif yang kami lakukan bersama anak-anak panti asuhan.</p>
        </div>

        <!-- Kolom Pencarian -->
        <div class="max-w-2xl mx-auto mb-12">
            <form action="{{ route('public.kegiatan.index') }}" method="GET" class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kegiatan berdasarkan nama atau deskripsi..." class="w-full px-6 py-4 rounded-full border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all">
                <button type="submit" class="absolute right-2 top-2 bottom-2 bg-brand-600 hover:bg-brand-700 text-white rounded-full px-6 py-2 transition-all shadow-sm">
                    Cari
                </button>
            </form>
        </div>

        @if($kegiatans->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($kegiatans as $item)
                    <div class="bg-white rounded-[24px] shadow-sm hover:shadow-md transition-all overflow-hidden border border-gray-100 flex flex-col h-full">
                        <div class="relative h-56 overflow-hidden">
                            @if($item->foto_dokumentasi)
                                <img src="{{ asset('storage/' . $item->foto_dokumentasi) }}" alt="{{ $item->nama_kegiatan }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                            @else
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute top-4 left-4">
                                <span class="bg-white/90 backdrop-blur-sm px-3 py-1 text-xs font-semibold rounded-full text-brand-700 shadow-sm">
                                    {{ \Carbon\Carbon::parse($item->tanggal_pelaksanaan)->translatedFormat('d F Y') }}
                                </span>
                            </div>
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2">{{ $item->nama_kegiatan }}</h3>
                            <p class="text-gray-600 mb-6 line-clamp-3 text-sm flex-grow">
                                {{ Str::limit(strip_tags($item->deskripsi), 120) }}
                            </p>
                            <a href="{{ route('public.kegiatan.show', $item->id) }}" class="inline-flex justify-center items-center rounded-full bg-brand-50 text-brand-700 px-6 py-2.5 text-sm font-semibold transition hover:bg-brand-600 hover:text-white mt-auto">
                                Read More
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12 flex justify-center">
                {{ $kegiatans->withQueryString()->links() }}
            </div>
        @else
            <div class="bg-white rounded-3xl p-12 text-center border border-gray-200 shadow-sm">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Tidak ada kegiatan ditemukan</h3>
                <p class="text-gray-500">
                    @if(request('search'))
                        Kami tidak menemukan kegiatan yang cocok dengan pencarian "{{ request('search') }}".
                    @else
                        Belum ada data kegiatan yang dipublikasikan saat ini.
                    @endif
                </p>
                @if(request('search'))
                    <a href="{{ route('public.kegiatan.index') }}" class="mt-6 inline-flex rounded-full bg-brand-600 px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-700">Tampilkan Semua Kegiatan</a>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection