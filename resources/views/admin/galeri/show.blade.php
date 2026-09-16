@extends('layouts.app')
@section('page-title', 'Detail Galeri')

@section('content')
<div class="max-w-3xl mx-auto overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm my-4">

        <!-- Header -->
        <div class="border-b border-gray-200 bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex justify-between items-center gap-4">
            <div class="min-w-0">
                <h2 class="text-lg font-bold text-white truncate">Detail Galeri</h2>
                <p class="text-xs md:text-sm text-gray-200">Informasi lengkap galeri.</p>
            </div>
            <a href="{{ route('galeri.index') }}" class="text-xs md:text-sm font-semibold text-white hover:text-gray-200 flex items-center transition-colors whitespace-nowrap">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="hidden sm:inline">Kembali</span>
            </a>
        </div>

        <div class="p-6 sm:p-6">
            <div class="flex flex-col gap-6 items-center">

                <!-- Foto Section -->
                <div class="flex flex-col items-center gap-3 flex-shrink-0">
                    <button type="button"
                            onclick="openImagePreview('{{ asset('storage/'.$galeri->foto) }}')"
                            aria-label="Perbesar foto {{ $galeri->judul }}">
                        <img src="{{ asset('storage/'.$galeri->foto) }}"
                            class="w-40 md:w-80 aspect-video rounded-lg border-2 border-gray-200 cursor-pointer transition duration-200 hover:scale-105"
                            alt="Foto {{ $galeri->judul }}"
                            title="Klik untuk perbesar">
                    </button>
                    <div class="text-center">
                        <span class="text-base md:text-lg font-bold text-gray-900 block truncate max-w-[180px] md:max-w-none">
                            {{ $galeri->judul }}
                        </span>
                        <span class="inline-block mt-1 px-3 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                            {{ \Carbon\Carbon::parse($galeri->created_at)->translatedFormat('d F Y') }}
                        </span>
                        <span class="inline-block mt-1 px-3 py-0.5 rounded-full text-xs font-semibold {{ $galeri->kategori === 'Fasilitas' ? 'bg-emerald-100 text-emerald-700' : 'bg-sky-100 text-sky-700' }}">
                            {{ ucfirst($galeri->kategori) }}
                        </span>
                    </div>
                </div>

                <div class="border-t border-gray-200 my-1 w-full"></div>

                <!-- Detail Section -->
                <div class="w-full space-y-2.5">
                    <!-- Deskripsi -->
                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-28 flex-shrink-0">Deskripsi</span>
                            <span class="text-gray-400">:</span>
                            <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">{{ $galeri->deskripsi ?? '-' }}</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Tombol Aksi -->
            <div class="mt-6 pt-4 border-t border-gray-200 flex flex-wrap gap-3 justify-center">
                <a href="{{ route('galeri.edit', $galeri->id) }}" 
                class="rounded-xl px-5 py-2 text-sm font-semibold text-amber-600 border border-amber-500 bg-yellow-100 transition hover:bg-amber-500 hover:text-white">
                    Edit
                </a>
                <button type="button"
                        onclick="openDeleteModal(this)"
                        data-delete-route="{{ route('galeri.destroy', $galeri->id) }}"
                        data-name="{{ $galeri->judul }}"
                        class="rounded-xl px-5 py-2 text-sm font-semibold text-red-500 border border-red-500 bg-red-100 transition hover:bg-red-500 hover:text-white">
                    Hapus
                </button>
            </div>
            
        </div>
    </div>
</div>



@endsection
