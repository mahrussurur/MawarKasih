@extends('admin.layouts.app')
@section('page-title', 'Data Kegiatan')
@section('title', 'Data Kegiatan | Panti Asuhan Mawar Kasih')

@section('content')
<div class="bg-gray-100 min-h-screen">
 
    <!-- Toolbar -->
    <div class="flex justify-between mb-4">
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('kegiatan.create') }}" class="inline-flex items-center gap-2 rounded-full bg-blue-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Kegiatan
            </a>
        </div>
    </div>

    <!-- Kotak Utama Konten -->
    <div class="bg-white rounded-[28px] shadow-sm border border-gray-100 p-6 mb-4">
        
        <div class="flex flex-col gap-4 border-b border-gray-200 py-4 lg:flex-row lg:items-center lg:justify-end">
            <!-- Search -->
            <form method="GET" action="{{ route('kegiatan.index') }}" class="flex w-full items-center gap-3 lg:w-auto">
                <label class="relative block w-full lg:w-[260px]">
                    <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-gray-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama kegiatan..."
                           class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent text-sm" />
                </label>
            </form>
        </div>

        <!-- Tabel Data -->
        @if($kegiatans->count() > 0)
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full min-w-[1200px] text-left divide-y divide-gray-200 text-sm border-b border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 font-semibold text-gray-700 text-center w-12">No</th>
                        <th class="px-6 py-4 font-semibold text-gray-700 w-20">Foto</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Judul Kegiatan</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Tanggal</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Deskripsi Singkat</th>
                        <th class="px-6 py-4 font-semibold text-gray-700 text-center sticky right-0 bg-gray-50 z-10 shadow-[inset_1px_0_0_#e5e7eb]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($kegiatans as $index => $item)
                        <tr class="hover:bg-gray-50 transition-colors group">
                            <td class="px-6 py-4 text-center text-gray-700">{{ $kegiatans->firstItem() + $index }}</td>
                            <td class="px-6 py-4 text-center">
                                    <button type="button"
                                            class="inline-flex"
                                            onclick="openImagePreview('{{ asset('storage/'. $item->foto_dokumentasi) }}')"
                                            aria-label="Perbesar foto kegiatan {{ $item->nama_kegiatan }}">
                                        <img src="{{ asset('storage/'. $item->foto_dokumentasi) }}"
                                            class="w-12 h-12 rounded object-cover mx-auto cursor-pointer transition duration-200 hover:scale-105"
                                            alt="Foto {{ $item->nama_kegiatan }}"
                                            title="Klik untuk perbesar">
                                    </button>
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900">{{ $item->nama_kegiatan }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                            <span class="text-gray-500">{{ \Carbon\Carbon::parse($item->tanggal_pelaksanaan)->format('d - m - Y') }}</span>
                            </td>
                            <td class="px-6 py-4 max-w-4 text-gray-700">
                                <span class="line-clamp-2 break-words">{{ $item->deskripsi }}</span>
                            </td>
                            <td class="px-6 py-4 text-center sticky right-0 bg-white group-hover:bg-gray-50 z-10 transition-colors shadow-[inset_1px_0_0_#e5e7eb]">
                                <div class="flex justify-center gap-1">
                                    <!-- Tombol Lihat Detail -->
                                    <a href="{{ route('kegiatan.show', $item->id) }}"
                                        class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-blue-500 bg-sky-100 text-blue-600 transition hover:bg-blue-500 hover:text-white"                                        title="Lihat Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </a>
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('kegiatan.edit', $item->id) }}"
                                        class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-amber-500 bg-yellow-100 text-amber-700 transition hover:bg-amber-500 hover:text-white"                                        title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </a>
                                    <!-- Tombol Hapus -->
                                    <button
                                        type="button"
                                        onclick="openDeleteModal(this)"
                                        data-delete-route="{{ route('kegiatan.destroy', $item->id) }}"
                                        data-name="{{ $item->nama_kegiatan }}"
                                        class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-red-600 bg-red-100 text-red-700 transition hover:bg-red-600 hover:text-white"
                                        title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($kegiatans->hasPages())
        <div class="flex flex-wrap items-center justify-end gap-1 mt-4">
            <a href="{{ $kegiatans->previousPageUrl() ?? '#' }}" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-gray-200 bg-gray-50 text-gray-600 transition hover:border-gray-300 hover:text-gray-900 {{ $kegiatans->onFirstPage() ? 'opacity-40 pointer-events-none' : '' }}">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </a>

            @foreach($kegiatans->getUrlRange(1, $kegiatans->lastPage()) as $page => $url)
                <a href="{{ $url }}" class="inline-flex h-9 min-w-[2.25rem] items-center justify-center rounded-xl border px-3 text-sm font-semibold transition {{ $page == $kegiatans->currentPage() ? 'border-blue-500 bg-blue-500 text-white' : 'border-gray-200 bg-gray-50 text-gray-700 hover:border-gray-300' }}">
                    {{ $page }}
                </a>
            @endforeach

            <a href="{{ $kegiatans->nextPageUrl() ?? '#' }}" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-gray-200 bg-gray-50 text-gray-600 transition hover:border-gray-300 hover:text-gray-900 {{ !$kegiatans->hasMorePages() ? 'opacity-40 pointer-events-none' : '' }}">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        @endif

        @else
        <div class="flex min-h-[300px] flex-col items-center justify-center gap-3 px-6 py-10 text-center text-gray-500">
            <p class="text-base font-semibold text-gray-900">Belum ada data kegiatan</p>
            <span class="text-sm text-gray-500">{{ request('search') ? 'Coba kata kunci lain' : 'Tambahkan data kegiatan pertama' }}</span>
        </div>
        @endif
    </div>
</div>

@include('admin.partials.modals')
@endsection
