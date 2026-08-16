@extends('public.layouts.app')

@section('title', 'Beranda')
@section('meta_desc', 'Panti Asuhan Mawar Kasih - Menebar Kasih, Merangkai Harapan. Bersama kita hadirkan cinta, pendidikan, dan masa depan yang lebih baik untuk mereka.')

@section('content')

<section id="heroCarousel" class="group relative h-[calc(100svh-70px)] lg:h-[calc(100vh-70px)] overflow-hidden bg-gray-950" data-aos="fade">
    <div id="carouselTrack" class="relative w-full h-full flex">
        
        <div class="carousel-slide min-w-full relative h-full" aria-hidden="true">
            <img src="{{ asset('images/hero/slide-3.webp') }}" alt="Clone Last" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/20 lg:bg-black/35"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/20 to-black/80 lg:bg-gradient-to-r lg:from-black/80 lg:via-black/40 lg:to-transparent"></div>
        </div>

        <div class="carousel-slide min-w-full relative h-full">
            <img src="{{ asset('images/hero/slide-1.webp') }}" alt="Slide 1 - Panti Asuhan Mawar Kasih" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/20 lg:bg-black/35"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/20 to-black/80 lg:bg-gradient-to-r lg:from-black/80 lg:via-black/40 lg:to-transparent"></div>
        </div>

        <div class="carousel-slide min-w-full relative h-full">
            <img src="{{ asset('images/hero/slide-2.webp') }}" alt="Slide 2 - Panti Asuhan Mawar Kasih" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/20 lg:bg-black/35"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/20 to-black/80 lg:bg-gradient-to-r lg:from-black/80 lg:via-black/40 lg:to-transparent"></div>
        </div>

        <div class="carousel-slide min-w-full relative h-full">
            <img src="{{ asset('images/hero/slide-3.webp') }}" alt="Slide 3 - Panti Asuhan Mawar Kasih" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/20 lg:bg-black/35"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/20 to-black/80 lg:bg-gradient-to-r lg:from-black/80 lg:via-black/40 lg:to-transparent"></div>
        </div>

        <div class="carousel-slide min-w-full relative h-full" aria-hidden="true">
            <img src="{{ asset('images/hero/slide-1.webp') }}" alt="Clone First" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/20 lg:bg-black/35"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/20 to-black/80 lg:bg-gradient-to-r lg:from-black/80 lg:via-black/40 lg:to-transparent"></div>
        </div>

    </div>

    <!-- Wrapper utama -->
    <div class="absolute inset-0 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex lg:items-center z-10 pointer-events-none">
        
        <!-- Inner Container: Mobile (Flex-col, justify-between untuk pisah atas-bawah), Desktop (Normal block/tengah) -->
        <div class="pointer-events-auto w-full h-full flex flex-col justify-between pt-12 pb-6 lg:h-auto lg:block lg:py-0 max-w-xl mx-auto lg:mx-0">

            <!-- Boks Teks (Posisi Atas di Mobile) -->
            <div class="text-center lg:text-left flex flex-col items-center lg:items-start w-full">
                <span class="inline-block px-4 py-1.5 bg-white/10 backdrop-blur-sm border border-white/20 text-white text-[10px] sm:text-xs font-semibold uppercase tracking-widest rounded-full mb-4 lg:mb-5">
                    Lembaga Panti Asuhan Mawar Kasih
                </span>

                <h1 class="text-3xl sm:text-5xl lg:text-[3.4rem] font-extrabold !leading-tight text-white mb-3 lg:mb-5 drop-shadow-md">
                    Dikasihi untuk<br>
                    <span class="text-brand-400">Saling Mengasihi.</span>
                </h1>

                <p class="text-gray-200 text-sm sm:text-lg leading-relaxed drop-shadow">
                    Bersama kita hadirkan kasih sayang, pendidikan,<br class="hidden lg:block">
                    dan masa depan yang lebih baik untuk mereka.
                </p>
            </div>

            <!-- Boks Tombol (Posisi Bawah di Mobile) -->
            <div class="flex justify-center w-full lg:justify-start mt-auto lg:mt-8">
                <a href="{{ route('public.donasi.rekening') }}"
                    class="inline-flex items-center justify-center gap-2 bg-brand-600 hover:bg-brand-500 text-white font-semibold px-8 py-3.5 lg:px-6 lg:py-3 rounded-full transition-all duration-200 shadow-lg hover:shadow-brand-600/30 hover:-translate-y-0.5 w-[85%] sm:w-auto">
                    <i data-lucide="heart" class="w-4 h-4"></i>
                    Donasi Sekarang
                </a>
            </div>

        </div>
    </div>

    <!-- Navigasi Slider -->
    <button id="prevBtn" onclick="prevSlide()" class="hidden md:flex absolute left-6 top-1/2 -translate-y-1/2 z-40 w-8 h-12 bg-white/20 hover:bg-white/40 backdrop-blur-sm rounded-lg items-center justify-center transition-all duration-200 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto group-focus-within:opacity-100 group-focus-within:pointer-events-auto">
        <i data-lucide="chevron-left" class="w-6 h-6 text-white transition-transform hover:scale-110"></i>
    </button>

    <button id="nextBtn" onclick="nextSlide()" class="hidden md:flex absolute right-6 top-1/2 -translate-y-1/2 z-40 w-8 h-12 bg-white/20 hover:bg-white/40 backdrop-blur-sm rounded-lg items-center justify-center transition-all duration-200 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto group-focus-within:opacity-100 group-focus-within:pointer-events-auto">
        <i data-lucide="chevron-right" class="w-6 h-6 text-white transition-transform hover:scale-110"></i>
    </button>

</section>

<script>
    const track = document.getElementById('carouselTrack');
    const slides = document.querySelectorAll('.carousel-slide');
    
    let currentSlide = 1; 
    const realSlidesCount = 3;
    let isTransitioning = false;
    let autoSlideInterval;

    track.style.transform = `translateX(-${currentSlide * 100}%)`;

    function updateCarousel(animate = true) {
        if (animate) {
            track.style.transition = 'transform 0.7s ease-out';
        } else {
            track.style.transition = 'none';
        }
        track.style.transform = `translateX(-${currentSlide * 100}%)`;
    }

    track.addEventListener('transitionend', () => {
        isTransitioning = false;
        
        if (currentSlide > realSlidesCount) {
            track.style.transition = 'none';
            currentSlide = 1;
            track.style.transform = `translateX(-${currentSlide * 100}%)`;
        }
        
        if (currentSlide < 1) {
            track.style.transition = 'none';
            currentSlide = realSlidesCount;
            track.style.transform = `translateX(-${currentSlide * 100}%)`;
        }
    });

    function nextSlide() {
        if (isTransitioning) return;
        isTransitioning = true;
        currentSlide++;
        updateCarousel(true);
        resetAutoSlide();
    }

    function prevSlide() {
        if (isTransitioning) return;
        isTransitioning = true;
        currentSlide--;
        updateCarousel(true);
        resetAutoSlide();
    }

    function resetAutoSlide() {
        clearInterval(autoSlideInterval);
        autoSlideInterval = setInterval(nextSlide, 5000);
    }

    let touchStartX = 0;
    let touchEndX = 0;

    document.getElementById('heroCarousel').addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });

    document.getElementById('heroCarousel').addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        const swipeThreshold = 50;
        if (touchStartX - touchEndX > swipeThreshold) {
            nextSlide();
        } else if (touchEndX - touchStartX > swipeThreshold) {
            prevSlide();
        }
    }, { passive: true });

    window.addEventListener('load', resetAutoSlide);
</script>

<section class="py-6 bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8" data-aos="fade-up">

            <!-- Anak Asuh -->
            <div class="flex items-center gap-4 p-4">
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i data-lucide="users-round" class="w-6 h-6 text-blue-600"></i>
                </div>
                <div>
                    <!-- Angka dari controller: $stats['totalAnakAsuh'] -->
                    <div class="text-2xl font-extrabold text-gray-900">{{ $stats['totalAnakAsuh'] ?? '44' }}+</div>
                    <div class="text-sm font-semibold text-gray-700">Anak Asuh</div>
                    <div class="hidden lg:block text-xs text-gray-400">sedang kami bina dengan kasih</div>
                </div>
            </div>

            <!-- Pengurus -->
            <div class="flex items-center gap-4 p-4">
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i data-lucide="users" class="w-6 h-6 text-blue-600"></i>
                </div>
                <div>
                    <!-- Angka dari controller: $stats['totalPengasuh'] -->
                    <div class="text-2xl font-extrabold text-gray-900">{{ $stats['totalPengasuh'] ?? '6' }}+</div>
                    <div class="text-sm font-semibold text-gray-700">Pengurus</div>
                    <div class="hidden lg:block text-xs text-gray-400">berdedikasi melayani</div>
                </div>
            </div>

            <!-- Donatur -->
            <div class="flex items-center gap-4 p-4">
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i data-lucide="user-check" class="w-6 h-6 text-blue-600"></i>
                </div>
                <div>
                    <!-- Angka dari controller: $stats['totalDonatur'] -->
                    <div class="text-2xl font-extrabold text-gray-900">{{ $stats['totalDonatur'] ?? '0' }}+</div>
                    <div class="text-sm font-semibold text-gray-700">Donatur</div>
                    <div class="hidden lg:block text-xs text-gray-400">berbagi kebaikan bersama kami</div>
                </div>
            </div>

            <!-- Kegiatan Aktif -->
            <div class="flex items-center gap-4 p-4">
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i data-lucide="heart-handshake" class="w-6 h-6 text-blue-600"></i>
                </div>
                <div>
                    <!-- Angka dari controller: $stats['totalKegiatan'] -->
                    <div class="text-2xl font-extrabold text-gray-900">{{ $stats['totalDonasi'] ?? '0' }}+</div>
                    <div class="text-sm font-semibold text-gray-700">Donasi</div>
                    <div class="hidden lg:block text-xs text-gray-400">sepanjang tahun</div>
                </div>
            </div>

        </div>
    </div>
</section>

<section class="py-14 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header section sesuai dengan Screenshot 2026-06-09 212507.webp -->
        <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-10" data-aos="fade-up">
            <div>
                <div class="flex items-center gap-4 mb-1">
                    <span class="text-xs font-bold tracking-wider text-gray-400 uppercase">KEGIATAN</span>
                    <div class="h-[2px] w-14 bg-blue-600"></div>
                </div>
                <h2 class="text-2xl md:text-3xl font-extrabold text-gray-700 tracking-tight uppercase">
                    KEGIATAN TERKINI KAMI
                </h2>
            </div>
        </div>

        <!-- Grid kartu kegiatan (Diubah menjadi 3 kolom agar ukuran & proporsi pas dengan screenshot) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            @forelse ($kegiatans ?? [] as $kegiatan)
            <article class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 group flex flex-col h-full"
                data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">

                <!-- Gambar kegiatan -->
                <div class="aspect-[16/10] overflow-hidden bg-gray-100">
                    @if($kegiatan->foto_dokumentasi)
                        <img src="{{ get_webp_url($kegiatan->foto_dokumentasi) }}"
                            alt="{{ $kegiatan->judul }}"
                            class="w-full h-full object-cover"
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
                            <a href="{{ route('public.kegiatan.show', $kegiatan->id) }}">
                                {{ $kegiatan->nama_kegiatan }}
                            </a>
                        </h3>

                        <!-- 2. Tanggal diletakkan di bawah Judul dengan icon Clock -->
                        <div class="flex items-center gap-1.5 text-xs text-gray-400 mb-3">
                            <i data-lucide="clock" class="w-3.5 h-3.5 opacity-60"></i>
                            <time datetime="{{ \Carbon\Carbon::parse($kegiatan->tanggal_pelaksanaan)->format('Y-m-d') }}">
                                {{ \Carbon\Carbon::parse($kegiatan->tanggal_pelaksanaan)->translatedFormat('d F Y') }}
                            </time>
                        </div>

                        <!-- 3. Deskripsi singkat -->
                        <p class="text-xs md:text-sm text-gray-500 line-clamp-3 mb-4 leading-relaxed">
                            {{ $kegiatan->deskripsi }}
                        </p>
                    </div>

                    <!-- 4. Tombol Read More di pojok kanan bawah -->
                    <div class="flex justify-end pt-2">
                        <a href="{{ route('public.kegiatan.show', $kegiatan->id) }}" 
                           class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-4 py-1.5 rounded-xl transition-colors duration-200">
                            Read More
                        </a>
                    </div>
                </div>

            </article>

            @empty
            <div class="lg:col-span-3 py-12 text-center text-gray-400">
                <i data-lucide="calendar-x" class="w-12 h-12 mx-auto mb-3 opacity-40"></i>
                <p class="text-sm">Belum ada kegiatan yang dipublikasikan.</p>
            </div>

            @endforelse

        </div>
    </div>
</section>

<section class="py-14 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-10" data-aos="fade-up">
            <div>
                <div class="flex items-center gap-4 mb-1">
                    <span class="text-xs font-bold tracking-wider text-gray-400 uppercase">FASILITAS</span>
                    <div class="h-[2px] w-14 bg-blue-600"></div>
                </div>
                <h2 class="text-2xl md:text-3xl font-extrabold text-gray-700 tracking-tight uppercase">
                    FASILITAS KAMI
                </h2>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            @forelse($fasilitas ?? [] as $f)
            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 flex flex-col sm:flex-row gap-5 items-start transition-all duration-300 hover:shadow-md"
                data-aos="fade-up" data-aos-delay="{{ $loop->index * 60 }}">
                
                <div class="w-full sm:w-40 md:w-48 aspect-[4/3] sm:aspect-square md:aspect-[4/3] rounded-lg overflow-hidden bg-gray-100 shrink-0">
                    @if($f->foto)
                        <img src="{{ get_webp_url($f->foto) }}"
                            alt="{{ $f->judul }}"
                            onclick="openFasilitasModal('{{ get_webp_url($f->foto) }}')"
                            class="w-full h-full object-cover transition-transform duration-500 hover:scale-105 cursor-zoom-in">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-50">
                            <i data-lucide="image" class="w-8 h-8 text-gray-300"></i>
                        </div>
                    @endif
                </div>

                <div class="flex flex-col pt-1">
                    <h3 class="font-bold text-gray-800 text-base md:text-lg mb-1 leading-snug">
                        {{ $f->judul }}
                    </h3>
                    
                    <p class="text-xs md:text-sm text-gray-500 leading-relaxed text-justify line-clamp-3 md:line-clamp-4">
                        {{ $f->deskripsi }}
                    </p>
                </div>
            </div>
            @empty
            <div class="col-span-full py-12 text-center text-gray-400">
                <i data-lucide="building-2" class="w-12 h-12 mx-auto mb-3 opacity-40"></i>
                <p class="text-sm">Belum ada fasilitas yang ditambahkan.</p>
            </div>
            @endforelse

        </div>
    </div>
</section>

<section class="py-14 bg-brand-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative bg-white rounded-2xl overflow-hidden shadow-md" data-aos="fade-up">

            <!-- Background foto ringan di kanan -->
            <div class="absolute right-0 top-0 bottom-0 w-1/2 hidden md:block">
                <img src="{{ asset('images/anak-panti.webp') }}"
                    alt="Anak-anak Mawar Kasih"
                    class="w-full h-full object-cover object-center opacity-90">
                <!-- Overlay gradient dari kiri -->
                <div class="absolute inset-0 bg-gradient-to-r from-white via-white/70 to-transparent"></div>
            </div>

            <!-- Konten teks -->
            <div class="relative px-8 py-12 lg:px-14 lg:py-16 max-w-lg">
                <h2 class="text-3xl lg:text-4xl font-extrabold text-gray-900 leading-tight mb-4">
                    Mari Jadi Bagian dari<br>
                    <span class="text-brand-600">Perubahan Mereka</span>
                </h2>
                <p class="text-gray-500 text-sm lg:text-base leading-relaxed mb-8">
                    Jadilah Donatur Tetap dan bantu menghadirkan kebutuhan pangan, pendidikan, serta masa depan yang lebih baik bagi anak-anak Panti Asuhan Mawar Kasih.
                </p>
                <div class="flex flex-col sm:flex-row gap-5">
                    <!-- Tombol utama -->
                    <a href="{{ route('public.donasi.registrasi') }}"
                        class="inline-flex items-center justify-center gap-2 bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold px-6 py-3.5 rounded-full transition shadow-lg hover:shadow-brand-600/30 whitespace-nowrap">
                        <i data-lucide="user-plus" class="w-4 h-4 shrink-0"></i>
                        Registrasi Sekarang
                    </a>
                    <!-- Tombol sekunder -->
                    <a href="{{ route('public.donasi.rekening') }}"
                        class="group inline-flex items-center justify-center gap-1.5 text-gray-900 font-semibold hover:text-blue-700 transition py-2 whitespace-nowrap">
                        Donasi Sekarang
                        <i data-lucide="arrow-right" class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-2"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- MODAL DETAIL FASILITAS -->
<div id="fasilitasModal"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm opacity-0 invisible transition-all duration-300"
    onclick="closeFasilitasModal(event)">

    <div class="bg-white rounded-2xl overflow-hidden max-w-lg w-full shadow-2xl transform scale-95 transition-transform duration-300" id="fasilitasModalBox">
        <!-- Foto fasilitas (besar) -->
        <div class="aspect-video bg-gray-100">
            <img id="fasilitasModalImg" src="" alt="" class="w-full h-full object-cover">
        </div>
    </div>

</div>

@endsection


@section('extra_scripts')
<script>
    function openFasilitasModal(imgSrc) {
        document.getElementById('fasilitasModalImg').src = imgSrc;

        const modal = document.getElementById('fasilitasModal');
        const box = document.getElementById('fasilitasModalBox');

        modal.classList.remove('opacity-0', 'invisible');
        modal.classList.add('opacity-100', 'visible');
        box.classList.remove('scale-95');
        box.classList.add('scale-100');
        document.body.style.overflow = 'hidden';

        // Tambahkan entri history agar tombol back mobile menutup modal
        history.pushState({ fasilitasModal: true }, '');
    }

    function _doCloseFasilitasModal() {
        const modal = document.getElementById('fasilitasModal');
        const box = document.getElementById('fasilitasModalBox');
        if (!modal || modal.classList.contains('invisible')) return;
        modal.classList.add('opacity-0', 'invisible');
        modal.classList.remove('opacity-100', 'visible');
        box.classList.add('scale-95');
        box.classList.remove('scale-100');
        document.body.style.overflow = '';
    }

    function closeFasilitasModal(event) {
        // Jika klik di dalam box modal, jangan tutup
        if (event && event.target !== document.getElementById('fasilitasModal')) return;

        // Hapus entri history yang kita tambahkan saat buka modal
        if (history.state && history.state.fasilitasModal) {
            history.back();
        } else {
            _doCloseFasilitasModal();
        }
    }

    // Tangkap tombol back browser/mobile — tutup modal, jangan navigasi
    window.addEventListener('popstate', (e) => {
        _doCloseFasilitasModal();
    });

    // Tutup modal dengan tombol Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeFasilitasModal();
    });
</script>
@endsection
