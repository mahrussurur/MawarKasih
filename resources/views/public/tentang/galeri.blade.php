@extends('public.layouts.app')
@section('title', 'Galeri | Panti Asuhan Mawar Kasih')

@section('content')
@include('public.components.page-header', ['title' => 'Galeri'])
<style>
    .fancybox__caption {
        position: absolute !important;
        bottom: 0 !important;
        left: 0 !important;
        right: 0 !important;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.9) 0%, rgba(0, 0, 0, 0.4) 70%, transparent 100%) !important;
        padding: 24px 16px !important;
        margin: 0 !important;
        text-align: center !important;
        color: #ffffff !important;
        z-index: 100 !important;
    }
    
    .fancybox__footer {
        background: #000000 !important;
        box-shadow: 0 -10px 30px rgba(0, 0, 0, 0.8);
        z-index: 150 !important;
        padding: 12px 0 !important;
    }

    .fancybox__thumbs {
        background: #000000 !important;
        z-index: 200 !important;
    }
</style>

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
                <div class="group relative bg-slate-900 rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 aspect-[16/10] sm:aspect-[4/3] md:aspect-[16/10] flex flex-col justify-end">

                    <a href="{{ asset('storage/' . $gallery->foto) }}" 
                       data-fancybox="gallery"
                       data-filename="{{ Str::slug($gallery->judul) }}.{{ pathinfo($gallery->foto, PATHINFO_EXTENSION) }}"
                       data-caption="<div class='max-w-xl mx-auto'><h4 class='font-bold text-base md:text-lg text-white mb-1 tracking-wide'>{{ $gallery->judul }}</h4>@if($gallery->deskripsi)<p class='text-xs md:text-sm text-gray-200 leading-relaxed'>{{ $gallery->deskripsi }}</p>@endif</div>"
                       class="absolute inset-0 z-10"
                       title="{{ $gallery->judul }}">
                       <span class="sr-only">Lihat Foto {{ $gallery->judul }}</span>
                    </a>

                    <img src="{{ asset('storage/' . $gallery->foto) }}" 
                         class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" 
                         alt="{{ $gallery->judul ?? 'Galeri Mawar Kasih' }}"
                         loading="lazy">

                    <div class="absolute inset-0 bg-gradient-to-t from-blue-900/90 via-blue-900/40 to-transparent z-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                    <div class="relative z-20 p-5 mt-auto text-center w-full pointer-events-none select-none opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-4 group-hover:translate-y-0">
                        @if($gallery->judul)
                            <h3 class="font-semibold text-white text-base md:text-lg mb-1 tracking-wide line-clamp-1 drop-shadow-md">
                                {{ $gallery->judul }}
                            </h3>
                        @endif
                    </div>
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

        @if($galleries->hasPages())
        <div class="mt-12 flex justify-center">
            {{ $galleries->links() }}
        </div>
        @endif
    </div>
</section>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />

<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Fancybox.bind('[data-fancybox="gallery"]', {
            Carousel: {
                infinite: true,
                transition: "slide"
            },
            Toolbar: {
                display: {
                    left: ["infobar"],
                    middle: [],
                    right: [
                        "slideshow",
                        "fullscreen",
                        "thumbs",
                        "zoom",
                        "download",
                        "close"
                    ],
                },
            },
        });
        
        // Intercept download button click to force the correct filename
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.f-button, .fancybox__button, button');
            if (!btn) return;
            
            const action = btn.getAttribute('data-action');
            const title = btn.getAttribute('title');
            
            if (action === 'download' || title === 'Download') {
                e.preventDefault();
                e.stopPropagation();
                
                if (typeof Fancybox !== 'undefined') {
                    const instance = Fancybox.getInstance();
                    if (instance) {
                        const slide = instance.getSlide();
                        if (slide && slide.triggerEl) {
                            const filename = slide.triggerEl.getAttribute('data-filename') || 'gambar.jpg';
                            const url = slide.src;
                            
                            // Download via blob to bypass browser URL naming fallback
                            fetch(url)
                              .then(res => res.blob())
                              .then(blob => {
                                  const blobUrl = window.URL.createObjectURL(blob);
                                  const a = document.createElement("a");
                                  a.style.display = 'none';
                                  a.href = blobUrl;
                                  a.download = filename;
                                  document.body.appendChild(a);
                                  a.click();
                                  window.URL.revokeObjectURL(blobUrl);
                                  document.body.removeChild(a);
                              })
                              .catch(() => {
                                  window.open(url, '_blank');
                              });
                        }
                    }
                }
            }
        }, true); // use capture phase to run before Fancybox's own listeners
        
        if (typeof lucide !== 'undefined' && lucide.createIcons) {
            lucide.createIcons();
        }
    });
</script>
@endsection