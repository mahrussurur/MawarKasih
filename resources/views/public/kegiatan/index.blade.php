@extends('public.layouts.app')
@section('title', 'Kegiatan | Panti Asuhan Mawar Kasih')

@section('content')
<div class="bg-gray-50 py-20 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Kolom Pencarian -->
        <div class="max-w-7xl mx-auto mb-12">
            <form action="{{ route('public.kegiatan.index') }}" method="GET" class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau deskripsi kegiatan..." class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all placeholder:text-sm">
                <button type="submit" class="absolute right-1 top-1 bottom-1 bg-brand-600 hover:bg-brand-700 text-white rounded-lg px-4 py-1 transition-all shadow-sm">
                    Cari
                </button>
            </form>
        </div>

        @if($kegiatans->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($kegiatans as $item)
                    <article class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 group flex flex-col h-full"
                        data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">

                        <!-- Gambar kegiatan -->
                        <div class="aspect-[16/10] overflow-hidden bg-gray-100">
                            @if($item->foto_dokumentasi)
                                <img src="{{ Storage::url($item->foto_dokumentasi) }}"
                                    alt="{{ $item->nama_kegiatan }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                    loading="lazy">
                            @else
                                <!-- Placeholder jika gambar tidak tersedia -->
                                <div class="w-full h-full flex items-center justify-center bg-gray-50">
                                    <i data-lucide="image" class="w-10 h-10 text-gray-300"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Konten kartu -->
                        <div class="p-5 flex flex-col flex-grow justify-between">
                            <div>
                                <!-- 1. Judul di bagian atas dengan gaya Uppercase -->
                                <h3 class="font-bold text-gray-700 text-base md:text-lg mb-2 line-clamp-2 uppercase group-hover:text-blue-600 transition-colors leading-snug">
                                    <a href="{{ route('public.kegiatan.show', $item->id) }}">
                                        {{ $item->nama_kegiatan }}
                                    </a>
                                </h3>

                                <!-- 2. Tanggal diletakkan di bawah Judul dengan icon Clock -->
                                <div class="flex items-center gap-1.5 text-xs text-gray-400 mb-3">
                                    <i data-lucide="clock" class="w-3.5 h-3.5 opacity-60"></i>
                                    <time datetime="{{ \Carbon\Carbon::parse($item->tanggal_pelaksanaan)->format('Y-m-d') }}">
                                        {{ \Carbon\Carbon::parse($item->tanggal_pelaksanaan)->translatedFormat('d F Y') }}
                                    </time>
                                </div>

                                <!-- 3. Deskripsi singkat -->
                                <p class="text-xs md:text-sm text-gray-500 line-clamp-3 mb-4 leading-relaxed">
                                    {{ Str::limit(strip_tags($item->deskripsi), 120) }}
                                </p>
                            </div>

                            <!-- 4. Tombol Read More di pojok kanan bawah -->
                            <div class="flex justify-end pt-2">
                                <a href="{{ route('public.kegiatan.show', $item->id) }}" 
                                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-4 py-1.5 rounded transition-colors duration-200">
                                    Read More
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