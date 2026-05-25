@extends('admin.layouts.app')
@section('page-title', 'Detail Galeri')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">

        <div class="bg-gray-50 border-b border-gray-100 px-6 py-4 flex justify-between items-center">
            <div>
                <h2 class="text-lg font-bold text-gray-800">Detail Galeri</h2>
                <p class="text-sm text-gray-500">Informasi lengkap foto galeri.</p>
            </div>
            <a href="{{ route('galeri.index') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-800 flex items-center transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>

        <div class="p-6 sm:p-10">
            <div class="mb-8 w-full h-64 sm:h-96 bg-gray-100 rounded-lg overflow-hidden border border-gray-200 relative">
                @if($galeri->foto)
                    <img src="{{ asset('storage/' . $galeri->foto) }}" alt="{{ $galeri->judul }}" class="w-full h-full object-cover">
                @else
                    <div class="absolute inset-0 flex flex-col items-center justify-center text-gray-400">
                        <svg class="w-16 h-16 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="text-sm font-medium">Tidak ada foto</p>
                    </div>
                @endif
            </div>

            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $galeri->judul }}</h1>
                <div class="flex items-center gap-2">
                    <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold {{ $galeri->kategori === 'fasilitas' ? 'bg-emerald-100 text-emerald-700' : 'bg-sky-100 text-sky-700' }}">
                        {{ ucfirst($galeri->kategori) }}
                    </span>
                </div>
            </div>

            <hr class="border-gray-100 mb-6">

            <div class="prose max-w-none text-gray-700 leading-relaxed">
                <h3 class="text-lg font-bold text-gray-800 mb-3">Deskripsi Foto:</h3>
                <p class="text-gray-700 leading-relaxed whitespace-pre-wrap break-words">{{ $galeri->deskripsi }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
