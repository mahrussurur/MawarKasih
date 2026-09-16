@extends('public.layouts.app')
@section('title', 'Kegiatan | Panti Asuhan Mawar Kasih')

@section('content')
@include('public.components.page-header', ['title' => 'Artikel Kegiatan'])
<div class="bg-gray-50 py-10 lg:py-16 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Kolom Pencarian -->
        <div class="max-w-7xl mx-auto mb-12">
            <form action="{{ route('public.kegiatan.index') }}" method="GET" class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau deskripsi kegiatan..." class="w-full pl-4 pr-20 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent text-sm">
                <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-brand-600">
                    <i data-lucide="search" class="w-5 h-5"></i>
                </button>
            </form>
        </div>

        @if($kegiatans->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($kegiatans as $item)
                    <article class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg border border-gray-100 hover:border-gray-200 transition-all duration-300 group flex flex-col h-full hover:-translate-y-1"
                        data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">

                        <!-- Gambar kegiatan -->
                        <div class="relative aspect-[16/10] overflow-hidden bg-gray-100">
                            @if($item->foto_dokumentasi)
                                <img src="{{ get_webp_url($item->foto_dokumentasi) }}"
                                    alt="{{ $item->nama_kegiatan }}"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                    loading="lazy">
                            @else
                                <!-- Placeholder jika gambar tidak tersedia -->
                                <div class="w-full h-full flex items-center justify-center bg-gray-50">
                                    <i data-lucide="image" class="w-10 h-10 text-gray-300"></i>
                                </div>
                            @endif

                            {{-- Floating date badge --}}
                            <div class="absolute top-3 left-3 bg-white/90 backdrop-blur-md text-gray-700 text-[11px] font-semibold px-3 py-1 rounded-lg shadow-sm flex items-center gap-1.5 border border-white/60">
                                <i data-lucide="clock" class="w-3.5 h-3.5 text-brand-600"></i>
                                <time datetime="{{ \Carbon\Carbon::parse($item->tanggal_pelaksanaan)->format('Y-m-d') }}">
                                    {{ \Carbon\Carbon::parse($item->tanggal_pelaksanaan)->translatedFormat('d M Y') }}
                                </time>
                            </div>
                        </div>

                        <!-- Konten kartu -->
                        <div class="p-5 sm:p-6 flex flex-col flex-grow">
                            <h3 class="font-bold text-gray-800 text-base sm:text-lg mb-2 line-clamp-2 uppercase group-hover:text-brand-600 transition-colors leading-snug">
                                <a href="{{ route('public.kegiatan.show', $item->id) }}">
                                    {{ $item->nama_kegiatan }}
                                </a>
                            </h3>

                            <p class="text-xs sm:text-sm text-gray-500 line-clamp-3 mb-5 leading-relaxed text-justify">
                                {{ Str::limit(strip_tags($item->deskripsi), 120) }}
                            </p>

                            <div class="mt-auto pt-4 border-t border-gray-50 flex items-center justify-end">
                                <a href="{{ route('public.kegiatan.show', $item->id) }}"
                                   class="inline-flex items-center gap-1.5 bg-brand-600 hover:bg-brand-700 text-white text-xs font-semibold px-4 py-2 rounded-xl shadow-sm hover:shadow transition-all duration-200 group/btn">
                                    <span>Selengkapnya</span>
                                    <i data-lucide="arrow-right" class="w-3.5 h-3.5 transition-transform group-hover/btn:translate-x-1"></i>
                                </a>
                            </div>
                        </div>

                    </article>
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
