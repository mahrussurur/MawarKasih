{{-- =========================================================================
     KEGIATAN SHOW — resources/views/public/pages/kegiatan/show.blade.php
     Controller : App\Http\Controllers\Public\KegiatanPublicController@show($id)
     TODO       : Halaman detail kegiatan — belum dibuat lengkap.
                  Data yang perlu di-pass:
                    - $kegiatan : instance model Kegiatan (findOrFail)
     ========================================================================= --}}

@extends('public.layouts.app')
@section('title', ($kegiatan->nama ?? 'Detail Kegiatan').' — Panti Asuhan Mawar Kasih')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
    <h1 class="text-3xl font-bold text-gray-900 mb-4" style="font-family:'Playfair Display',serif">
        {{ $kegiatan->nama ?? 'Detail Kegiatan' }}
    </h1>
    <p class="text-gray-500">Halaman ini sedang dalam pengembangan.</p>
    <a href="{{ route('public.kegiatan') }}" class="mt-6 inline-block text-primary-600 hover:underline">← Kembali ke Kegiatan</a>
</div>
@endsection