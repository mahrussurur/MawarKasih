@extends('public.layouts.app')
@section('title', 'Galeri | Panti Asuhan Mawar Kasih')

@section('content')

<!-- Gallery Grid Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="max-w-7xl mx-auto mb-12">
            <form action="{{ route('public.galeri.index') }}" method="GET" class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau deskripsi foto..." class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all placeholder:text-sm">
                <button type="submit" class="absolute right-1 top-1 bottom-1 bg-brand-600 hover:bg-brand-700 text-white rounded-lg px-4 py-1 transition-all shadow-sm">
                    Cari
                </button>
            </form>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($galleries as $gallery)
                <div class="group bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 flex flex-col h-full">
                    <a href="{{ asset('storage/' . $gallery->foto) }}" 
                       data-gallery="gallery"
                       class="gallery-link relative block overflow-hidden aspect-[4/3]">
                        <img src="{{ asset('storage/' . $gallery->foto) }}" 
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" 
                             alt="{{ $gallery->judul ?? 'Galeri Mawar Kasih' }}"
                             loading="lazy">
                        <div class="absolute inset-0 bg-brand-900/0 group-hover:bg-brand-900/20 transition-colors duration-300 flex items-center justify-center">
                            <div class="bg-white/90 text-brand-600 p-3 rounded-full opacity-0 group-hover:opacity-100 transform scale-50 group-hover:scale-100 transition-all duration-300 shadow-lg">
                                <i data-lucide="zoom-in" class="w-5 h-5"></i>
                            </div>
                        </div>
                    </a>
                    @if($gallery->judul || $gallery->deskripsi)
                    <div class="p-5 flex-1 flex flex-col">
                        <h3 class="font-bold text-slate-800 mb-2 line-clamp-1">{{ $gallery->judul }}</h3>
                        @if($gallery->deskripsi)
                            <p class="text-sm text-slate-500 mb-4 line-clamp-2 flex-1">
                                {{ $gallery->deskripsi }}
                            </p>
                        @endif
                        <div class="mt-auto flex items-center text-xs font-medium text-slate-400">
                            <i data-lucide="calendar" class="w-3.5 h-3.5 mr-1.5"></i>
                            {{ $gallery->created_at->format('d M Y') }}
                        </div>
                    </div>
                    @endif
                </div>
            @empty
                <div class="col-span-full py-20 flex flex-col items-center justify-center text-center bg-slate-50 rounded-3xl border border-slate-100 border-dashed">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mb-4 shadow-sm">
                        <i data-lucide="image-off" class="w-8 h-8 text-slate-300"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-800 mb-1">Belum Ada Galeri</h3>
                    <p class="text-slate-500 text-sm">Saat ini belum ada foto yang ditambahkan ke galeri publik.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($galleries->hasPages())
        <div class="mt-12 flex justify-center">
            {{ $galleries->links() }}
        </div>
        @endif
    </div>
</section>

<!-- Lightbox CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">

<!-- Lightbox JS -->
<script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const lightbox = GLightbox({
            selector: '.gallery-link',
            touchNavigation: true,
            loop: true,
            autoplayVideos: true,
            zoomable: true,
            descPosition: 'bottom',
        });
        
        // Initialize Lucide icons if function exists (re-init for dynamic content)
        if (typeof lucide !== 'undefined' && lucide.createIcons) {
            lucide.createIcons();
        }
    });
</script>
@endsection