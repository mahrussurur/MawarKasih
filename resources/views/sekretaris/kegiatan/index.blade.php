@extends('layouts.app')
@section('page-title', 'Data Kegiatan')
@section('title', 'Data Kegiatan | Panti Asuhan Mawar Kasih')

@section('content')
<div>
 
    <!-- Kotak Utama Konten -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6">
        
        <div class="flex flex-col gap-4 border-b border-gray-200 pb-4 lg:flex-row lg:items-center lg:justify-end">
            <!-- Search -->
            <form method="GET" action="{{ route('sekretaris.kegiatan.index') }}" class="flex w-full items-center gap-3 lg:w-auto">
                <label class="relative block w-full lg:w-[260px]">
                    <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-gray-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama kegiatan..."
                           class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent text-sm" />
                </label>
            </form>
        </div>

        <!-- Card Grid -->
        @if($kegiatans->count() > 0)
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 mt-4">
            @foreach($kegiatans as $item)
            <div class="group flex flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition hover:shadow-md">
                <!-- Foto -->
                <div class="relative h-48 w-full overflow-hidden bg-gray-100">
                    <button type="button" class="h-full w-full outline-none" onclick="openImagePreview('{{ asset('storage/'. $item->foto_dokumentasi) }}')" aria-label="Perbesar foto kegiatan {{ $item->nama_kegiatan }}">
                        <img src="{{ asset('storage/'. $item->foto_dokumentasi) }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105" alt="Foto {{ $item->nama_kegiatan }}">
                    </button>
                    <div class="absolute right-3 top-3 rounded-full bg-white/90 px-2.5 py-1 text-xs font-semibold text-gray-700 shadow-sm backdrop-blur-sm">
                        {{ \Carbon\Carbon::parse($item->tanggal_pelaksanaan)->format('d M Y') }}
                    </div>
                </div>
                
                <!-- Konten -->
                <div class="flex flex-1 flex-col p-5">
                    <h3 class="mb-2 text-lg font-bold text-gray-900 line-clamp-1" title="{{ $item->nama_kegiatan }}">{{ $item->nama_kegiatan }}</h3>
                    
                    <!-- Aksi (hanya Show) -->
                    <div class="mt-auto flex items-center justify-end gap-2 border-t border-gray-100 pt-4">
                        <a href="{{ route('sekretaris.kegiatan.show', $item->id) }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-blue-400 bg-blue-50 text-blue-600 transition hover:bg-blue-600 hover:text-white" title="Lihat Detail">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @include('layouts.partials.admin._pagination', ['paginator' => $kegiatans])

        @else
        <div class="flex min-h-[300px] flex-col items-center justify-center gap-3 px-6 py-10 text-center text-gray-500">
            <p class="text-base font-semibold text-gray-900">Belum ada data kegiatan</p>
            <span class="text-sm text-gray-500">{{ request('search') ? 'Data "'. request('search') . '" tidak ditemukan' : 'Tidak ada data untuk ditampilkan' }}</span>
        </div>
        @endif
    </div>
</div>


@endsection
