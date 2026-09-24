@extends('layouts.app')
@section('page-title', 'Data Galeri')

@section('content')
<div>

    <div class="flex justify-between mb-4">
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('galeri.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Foto
            </a>
        </div>
    </div>

    <!-- Kotak Utama Konten -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6">
        
        <div class="flex flex-col gap-4 border-b border-gray-200 pb-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex flex-wrap gap-2">
                @php $activeKategori = $kategori ?? request('kategori', 'Semua'); @endphp

                <a href="{{ route('galeri.index', array_merge(request()->except(['kategori','page']), ['kategori' => 'Semua'])) }}"
                   class="inline-flex items-center gap-2 rounded-full border px-4 py-2 text-[11px] font-semibold transition {{ $activeKategori === 'Semua' ? 'bg-gray-900 text-white border-gray-900' : 'bg-gray-100 text-gray-600 border-gray-200 hover:bg-gray-200' }}">
                    Semua
                    <span class="rounded-full bg-white px-2 py-0.5 text-[10px] font-bold text-gray-600 shadow-sm">{{ $totalGaleri }}</span>
                </a>
                <a href="{{ route('galeri.index', array_merge(request()->except(['kategori','page']), ['kategori' => 'Fasilitas'])) }}"
                    class="inline-flex items-center gap-2 rounded-full border px-4 py-2 text-[11px] font-semibold transition {{ $activeKategori === 'Fasilitas' ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-emerald-100 text-emerald-800 border-emerald-100 hover:bg-emerald-200' }}">
                    Fasilitas
                    <span class="rounded-full bg-white px-2 py-0.5 text-[10px] font-bold text-gray-600 shadow-sm">{{ $totalFasilitas }}</span>
                </a>
                <a href="{{ route('galeri.index', array_merge(request()->except(['kategori','page']), ['kategori' => 'Umum'])) }}"
                    class="inline-flex items-center gap-2 rounded-full border px-4 py-2 text-[11px] font-semibold transition {{ $activeKategori === 'Umum' ? 'bg-gray-600 text-white border-gray-600' : 'bg-gray-100 text-gray-600 border-gray-200 hover:bg-gray-200' }}">
                    Umum
                    <span class="rounded-full bg-white px-2 py-0.5 text-[10px] font-bold text-gray-600 shadow-sm">{{ $totalUmum }}</span>
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
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 mt-4">
            @foreach($galeris as $galeri)
            <div class="group flex flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition hover:shadow-md">
                <!-- Foto -->
                <div class="relative h-48 w-full overflow-hidden bg-gray-100 flex items-center justify-center">
                    @if($galeri->foto)
                    <button type="button" class="h-full w-full outline-none" onclick="openImagePreview('{{ asset('storage/' . $galeri->foto) }}')" aria-label="Perbesar foto {{ $galeri->judul }}">
                        <img src="{{ asset('storage/' . $galeri->foto) }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105" alt="Foto {{ $galeri->judul }}">
                    </button>
                    @else
                    <span class="text-gray-400 text-sm">Kosong</span>
                    @endif
                    <div class="absolute right-3 top-3 rounded-full {{ $galeri->kategori === 'Fasilitas' ? 'bg-emerald-100 text-emerald-700' : 'bg-white/90 text-gray-700' }} px-2.5 py-1 text-xs font-semibold shadow-sm backdrop-blur-sm">
                        {{ ucfirst($galeri->kategori) }}
                    </div>
                </div>
                
                <!-- Konten -->
                <div class="flex flex-1 flex-col p-5">
                    <h3 class="mb-2 text-lg font-bold text-gray-900 line-clamp-1" title="{{ $galeri->judul }}">{{ $galeri->judul }}</h3>
                    
                    <!-- Aksi -->
                    <div class="mt-auto flex items-center justify-end gap-2 border-t border-gray-100 pt-4">
                        <a href="{{ route('galeri.show', $galeri->id) }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-blue-400 bg-blue-50 text-blue-600 transition hover:bg-blue-600 hover:text-white" title="Lihat Detail">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </a>
                        <a href="{{ route('galeri.edit', $galeri->id) }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-amber-400 bg-amber-50 text-amber-600 transition hover:bg-amber-500 hover:text-white" title="Edit">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </a>
                        <button type="button" onclick="openDeleteModal(this)" data-delete-route="{{ route('galeri.destroy', $galeri->id) }}" data-name="{{ $galeri->judul }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-red-400 bg-red-50 text-red-600 transition hover:bg-red-600 hover:text-white" title="Hapus">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @include('layouts.partials.admin._pagination', ['paginator' => $galeris])

        @else
        <div class="flex min-h-[300px] flex-col items-center justify-center gap-3 px-6 py-10 text-center text-gray-500">
            <p class="text-base font-semibold text-gray-900">Belum ada data galeri</p>
            <span class="text-sm text-gray-500">{{ request('search') ? 'Data "'. request('search') . '" tidak ditemukan' : 'Tambahkan data galeri' }}</span>
        </div>
        @endif
    </div>
</div>


@endsection
