@extends('admin.layouts.app')
@section('page-title', 'Data Galeri')
@section('title', 'Data Galeri | Panti Asuhan Mawar Kasih')

@section('content')
<div class="bg-gray-100 min-h-screen">

    <div class="flex justify-between mb-4">
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('galeri.create') }}" class="inline-flex items-center gap-2 rounded-full bg-blue-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Foto
            </a>
        </div>
    </div>

    <!-- Kotak Utama Konten -->
    <div class="bg-white rounded-[28px] shadow-sm border border-gray-100 p-6 mb-4">
        
        <div class="flex flex-col gap-4 border-b border-gray-200 py-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex flex-wrap gap-2">
                @php $activeKategori = $kategori ?? request('kategori', 'semua'); @endphp

                <a href="{{ route('galeri.index', array_merge(request()->except(['kategori','page']), ['kategori' => 'semua'])) }}"
                   class="inline-flex items-center gap-2 rounded-full border px-4 py-2 text-[11px] font-semibold transition {{ $activeKategori === 'semua' ? 'bg-gray-900 text-white border-gray-900' : 'bg-gray-100 text-gray-600 border-gray-200 hover:bg-gray-200' }}">
                    Semua
                    <span class="rounded-full bg-white px-2 py-0.5 text-[10px] font-bold text-gray-600 shadow-sm">{{ $totalGaleri }}</span>
                </a>
                <a href="{{ route('galeri.index', array_merge(request()->except(['kategori','page']), ['kategori' => 'umum'])) }}"
                   class="inline-flex items-center gap-2 rounded-full border px-4 py-2 text-[11px] font-semibold transition {{ $activeKategori === 'umum' ? 'bg-sky-600 text-white border-sky-600' : 'bg-sky-100 text-sky-800 border-sky-100 hover:bg-sky-200' }}">
                    Umum
                    <span class="rounded-full bg-white px-2 py-0.5 text-[10px] font-bold text-gray-600 shadow-sm">{{ $totalUmum }}</span>
                </a>
                <a href="{{ route('galeri.index', array_merge(request()->except(['kategori','page']), ['kategori' => 'fasilitas'])) }}"
                   class="inline-flex items-center gap-2 rounded-full border px-4 py-2 text-[11px] font-semibold transition {{ $activeKategori === 'fasilitas' ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-emerald-100 text-emerald-800 border-emerald-100 hover:bg-emerald-200' }}">
                    Fasilitas
                    <span class="rounded-full bg-white px-2 py-0.5 text-[10px] font-bold text-gray-600 shadow-sm">{{ $totalFasilitas }}</span>
                </a>
            </div>

            <!-- Search -->
            <form method="GET" action="{{ route('galeri.index') }}" class="flex w-full items-center gap-3 lg:w-auto">
                <input type="hidden" name="kategori" value="{{ $activeKategori }}">
                <label class="relative block w-full lg:w-[260px]">
                    <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-gray-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul foto..."
                           class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent text-sm" />
                </label>
            </form>
        </div>

        <!-- Table data -->
        @if($galeris->count() > 0)
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full min-w-[1100px] text-left divide-y divide-gray-200 text-sm border-b border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 font-semibold text-gray-700 text-center w-12">No</th>
                        <th class="px-6 py-4 font-semibold text-gray-700 w-20">Foto</th>
                        <th class="px-6 py-4 font-semibold text-gray-700 w-60">Judul</th>
                        <th class="px-6 py-4 font-semibold text-gray-700 w-40">Kategori</th>
                        <th class="px-6 py-4 font-semibold text-gray-700 w-60">Deskripsi</th>
                        <th class="px-6 py-4 font-semibold text-gray-700 text-center w-20 sticky right-0 bg-gray-50 z-10 shadow-[inset_1px_0_0_#e5e7eb]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($galeris as $index => $galeri)
                        <tr class="hover:bg-gray-50 transition-colors group">
                            <td class="px-6 py-4 text-center text-gray-700">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 text-center">
                                @if($galeri->foto)
                                    <button type="button"
                                            class="inline-flex"
                                            onclick="openImagePreview('{{ asset('storage/' . $galeri->foto) }}')"
                                            aria-label="Perbesar foto {{ $galeri->judul }}">
                                        <img src="{{ asset('storage/' . $galeri->foto) }}"
                                             class="w-12 h-12 object-cover rounded shadow-sm cursor-pointer transition duration-200 hover:scale-105"
                                             alt="Foto {{ $galeri->judul }}"
                                             title="Klik untuk perbesar">
                                    </button>
                                @else
                                    <div class="w-12 h-12 bg-gray-100 rounded flex items-center justify-center text-xs text-gray-400 border border-gray-200">
                                        Kosong
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900">{{ $galeri->judul }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $galeri->kategori === 'fasilitas' ? 'bg-emerald-100 text-emerald-700' : 'bg-sky-100 text-sky-700' }}">
                                    {{ ucfirst($galeri->kategori) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 max-w-md text-gray-700">
                                <span class="line-clamp-2 break-words">{{ $galeri->deskripsi }}</span>
                            </td>
                            <td class="px-6 py-4 text-center sticky right-0 bg-white group-hover:bg-gray-50 z-10 transition-colors shadow-[inset_1px_0_0_#e5e7eb]">
                                <div class="flex justify-center gap-1">
                                    <a href="{{ route('galeri.show', $galeri->id) }}"
                                       class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-blue-500 bg-sky-100 text-blue-600 transition hover:bg-blue-500 hover:text-white"
                                       title="Lihat Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('galeri.edit', $galeri->id) }}"
                                       class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-amber-500 bg-yellow-100 text-amber-700 transition hover:bg-amber-500 hover:text-white"
                                       title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <button type="button"
                                            onclick="openDeleteModal(this)"
                                            data-delete-route="{{ route('galeri.destroy', $galeri->id) }}"
                                            data-name="{{ $galeri->judul }}"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-red-600 bg-red-100 text-red-700 transition hover:bg-red-600 hover:text-white"
                                            title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
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
        @if($galeris->hasPages())
        <div class="flex flex-wrap items-center justify-end gap-1 mt-4">
            <a href="{{ $galeri->previousPageUrl() ?? '#' }}" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-gray-200 bg-gray-50 text-gray-600 transition hover:border-gray-300 hover:text-gray-900 {{ $galeri->onFirstPage() ? 'opacity-40 pointer-events-none' : '' }}">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </a>

            @foreach($galeri->getUrlRange(1, $galeri->lastPage()) as $page => $url)
                <a href="{{ $url }}" class="inline-flex h-9 min-w-[2.25rem] items-center justify-center rounded-xl border px-3 text-sm font-semibold transition {{ $page == $galeri->currentPage() ? 'border-blue-500 bg-blue-500 text-white' : 'border-gray-200 bg-gray-50 text-gray-700 hover:border-gray-300' }}">
                    {{ $page }}
                </a>
            @endforeach

            <a href="{{ $galeri->nextPageUrl() ?? '#' }}" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-gray-200 bg-gray-50 text-gray-600 transition hover:border-gray-300 hover:text-gray-900 {{ !$galeri->hasMorePages() ? 'opacity-40 pointer-events-none' : '' }}">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        @endif

        @else
        <div class="flex min-h-[300px] flex-col items-center justify-center gap-3 px-6 py-10 text-center text-gray-500">
            <p class="text-base font-semibold text-gray-900">Belum ada data galeri</p>
            <span class="text-sm text-gray-500">{{ request('search') ? 'Coba kata kunci lain' : 'Tambahkan galeri pertama' }}</span>
        </div>
        @endif
    </div>
</div>

@include('admin.partials.modals')
@endsection
