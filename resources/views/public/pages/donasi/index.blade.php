{{-- =========================================================================
     DONASI INDEX — resources/views/public/pages/donasi/index.blade.php
     Controller : App\Http\Controllers\Public\DonasiPublicController@index
     TODO       : Halaman form donasi & info rekening — belum dibuat lengkap.
                  Data yang perlu di-pass controller:
                    - (opsional) $donasiTerbaru : koleksi Donasi terbaru untuk ditampilkan
     ========================================================================= --}}

@extends('public.layouts.app')
@section('title', 'Donasi — Panti Asuhan Mawar Kasih')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
    <h1 class="text-3xl font-bold text-gray-900 mb-4" style="font-family:'Playfair Display',serif">Donasi</h1>
    <p class="text-gray-500">Halaman ini sedang dalam pengembangan.</p>
    <a href="{{ route('public.home') }}" class="mt-6 inline-block text-primary-600 hover:underline">← Kembali ke Beranda</a>
</div>
@endsection