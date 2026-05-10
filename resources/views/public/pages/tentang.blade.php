{{-- =========================================================================
     TENTANG — resources/views/public/pages/tentang.blade.php
     Controller : App\Http\Controllers\Public\ProfilOrfanatController@index
     TODO       : Halaman profil lembaga, visi misi, kontak — belum dibuat lengkap.
                  Data yang perlu di-pass controller:
                    - $pengasuh : koleksi model Pengasuh (dikelola admin)
     ========================================================================= --}}

@extends('public.layouts.app')
@section('title', 'Tentang Kami — Panti Asuhan Mawar Kasih')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
    <h1 class="text-3xl font-bold text-gray-900 mb-4" style="font-family:'Playfair Display',serif">Tentang Kami</h1>
    <p class="text-gray-500">Halaman ini sedang dalam pengembangan.</p>
    <a href="{{ route('public.home') }}" class="mt-6 inline-block text-primary-600 hover:underline">← Kembali ke Beranda</a>
</div>
@endsection