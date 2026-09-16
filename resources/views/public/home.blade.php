@extends('layouts.public')

@section('title', 'Beranda')
@section('meta_desc', 'Panti Asuhan Mawar Kasih - Menebar Kasih, Merangkai Harapan. Bersama kita hadirkan cinta, pendidikan, dan masa depan yang lebih baik untuk mereka.')

@section('content')

<!-- HERO -->
<section id="heroCarousel" class="group relative min-h-[100svh] lg:min-h-[100vh] flex flex-col overflow-hidden bg-gray-950" data-aos="fade">

    <!-- Slide background -->
    @php
        $heroSlides = [
            'images/hero/slide-1.webp',
            'images/hero/slide-2.webp',
            'images/hero/slide-3.webp',
        ];
    @endphp

    <div id="carouselTrack" class="absolute inset-0 w-full h-full z-0">
        @foreach ($heroSlides as $slide)
            <div class="carousel-slide absolute inset-0 w-full h-full transition-all duration-1000 ease-in-out z-0 {{ $loop->first ? 'opacity-100 blur-none' : 'opacity-0 blur-md' }}">
                <img src="{{ asset($slide) }}" alt="Slide {{ $loop->iteration }} - Panti Asuhan Mawar Kasih" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/20 lg:bg-black/35"></div>
                <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/40 to-transparent"></div>
            </div>
        @endforeach
    </div>

    {{-- Wrapper utama hero --}}
    <div class="relative z-10 flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col justify-center pointer-events-none pt-24 pb-6 lg:pt-28 lg:pb-8">
        <div class="pointer-events-auto w-full max-w-xl mx-auto lg:mx-0">

            <div class="w-full flex flex-col items-center lg:items-start text-center lg:text-left gap-4 sm:gap-5 lg:gap-6">

                <h1 class="text-3xl sm:text-5xl lg:text-[3.4rem] font-extrabold !leading-tight text-white drop-shadow-md">
                    Dikasihi untuk<br>
                    <span class="bg-gradient-to-r from-blue-500 via-cyan-500 to-sky-400 bg-clip-text text-transparent">
                        Saling Mengasihi.
                    </span>
                </h1>

                <p class="text-gray-200 text-sm sm:text-lg leading-relaxed drop-shadow">
                    Bersama kita hadirkan kasih sayang, pendidikan,<br class="hidden lg:block">
                    dan masa depan yang lebih baik untuk mereka.
                </p>

                <a href="{{ route('public.donasi.rekening') }}"
                    class="inline-flex items-center justify-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold px-8 py-3.5 lg:px-6 lg:py-3 rounded-xl">
                    <i data-lucide="heart" class="w-4 h-4"></i>
                    Donasi Sekarang
                </a>

            </div>

        </div>
    </div>

    <!-- Statistik -->
    <div class="relative z-20 w-full mt-auto pb-10 pointer-events-auto">
        <div class="absolute -bottom-1 left-0 w-full pointer-events-none z-0 translate-y-[2px]">
            <img src="{{ asset('images/awan.png') }}" alt="Awan Transisi" class="w-full h-auto block object-cover scale-[1.01] origin-bottom">
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 lg:gap-8" data-aos="fade-up">

                @php
                    $statItems = [
                        ['icon' => 'users-round', 'value' => $stats['totalAnakAsuh'] ?? '44', 'label' => 'Anak Asuh', 'desc' => 'sedang kami bina dengan kasih'],
                        ['icon' => 'users', 'value' => $stats['totalPengasuh'] ?? '6', 'label' => 'Pengurus', 'desc' => 'berdedikasi melayani'],
                        ['icon' => 'user-check', 'value' => $stats['totalDonatur'] ?? '0', 'label' => 'Donatur', 'desc' => 'berbagi kebaikan'],
                        ['icon' => 'heart-handshake', 'value' => $stats['totalDonasi'] ?? '0', 'label' => 'Donasi', 'desc' => 'sepanjang tahun'],
                    ];
                @endphp

                @foreach ($statItems as $item)
                    <div class="flex items-center gap-3 sm:gap-4 p-4 sm:p-5 bg-white/10 backdrop-blur-md rounded-2xl shadow-xl border border-white/20 text-white hover:bg-white/15 transition-colors">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center flex-shrink-0 border border-white/10">
                            <i data-lucide="{{ $item['icon'] }}" class="w-6 h-6 text-white"></i>
                        </div>
                        <div>
                            <div class="text-2xl font-extrabold text-white">{{ $item['value'] }}+</div>
                            <div class="text-sm font-semibold text-gray-200">{{ $item['label'] }}</div>
                            <div class="hidden lg:block text-xs text-gray-300 mt-0.5">{{ $item['desc'] }}</div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</section>

<script>
    const slides = document.querySelectorAll('.carousel-slide');
    let currentSlide = 0;
    const realSlidesCount = slides.length;

    function nextSlide() {
        if (realSlidesCount === 0) return;

        slides[currentSlide].classList.remove('opacity-100', 'blur-none');
        slides[currentSlide].classList.add('opacity-0', 'blur-md');

        currentSlide = (currentSlide + 1) % realSlidesCount;

        slides[currentSlide].classList.remove('opacity-0', 'blur-md');
        slides[currentSlide].classList.add('opacity-100', 'blur-none');
    }

    let autoSlideInterval;
    function startAutoSlide() {
        autoSlideInterval = setInterval(nextSlide, 5000);
    }

    window.addEventListener('load', startAutoSlide);
</script>

<!-- KEGIATAN -->
<section class="py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-10" data-aos="fade-up">
            <div class="flex items-center gap-4 mb-1">
                <span class="text-xs font-bold tracking-wider text-gray-400 uppercase">KEGIATAN</span>
                <div class="h-[2px] w-14 bg-blue-600"></div>
            </div>
            <h2 class="text-2xl md:text-3xl font-extrabold text-gray-700 tracking-tight uppercase">
                KEGIATAN TERKINI KAMI
            </h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            @forelse ($kegiatans ?? [] as $kegiatan)
                <article class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg border border-gray-100 hover:border-gray-200 transition-all duration-300 group flex flex-col h-full hover:-translate-y-1" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">

                    <div class="relative aspect-[16/10] overflow-hidden bg-gray-100">
                        @if($kegiatan->foto_dokumentasi)
                            <img src="{{ get_webp_url($kegiatan->foto_dokumentasi) }}"
                                alt="{{ $kegiatan->nama_kegiatan }}"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                loading="lazy">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-50">
                                <i data-lucide="image" class="w-10 h-10 text-gray-300"></i>
                            </div>
                        @endif

                        {{-- Floating date badge --}}
                        <div class="absolute top-3 left-3 bg-white/90 backdrop-blur-md text-gray-700 text-[11px] font-semibold px-3 py-1 rounded-lg shadow-sm flex items-center gap-1.5 border border-white/60">
                            <i data-lucide="clock" class="w-3.5 h-3.5 text-brand-600"></i>
                            <time datetime="{{ \Carbon\Carbon::parse($kegiatan->tanggal_pelaksanaan)->format('Y-m-d') }}">
                                {{ \Carbon\Carbon::parse($kegiatan->tanggal_pelaksanaan)->translatedFormat('d M Y') }}
                            </time>
                        </div>
                    </div>

                    <div class="p-5 sm:p-6 flex flex-col flex-grow">
                        <h3 class="font-bold text-gray-800 text-base sm:text-lg mb-2 line-clamp-2 uppercase group-hover:text-brand-600 transition-colors leading-snug">
                            <a href="{{ route('public.kegiatan.show', $kegiatan->id) }}">
                                {{ $kegiatan->nama_kegiatan }}
                            </a>
                        </h3>

                        <p class="text-xs sm:text-sm text-gray-500 line-clamp-3 mb-5 leading-relaxed text-justify">
                            {{ $kegiatan->deskripsi }}
                        </p>

                        <div class="mt-auto pt-4 border-t border-gray-50 flex items-center justify-end">
                            <a href="{{ route('public.kegiatan.show', $kegiatan->id) }}"
                               class="inline-flex items-center gap-1.5 bg-brand-600 hover:bg-brand-700 text-white text-xs font-semibold px-4 py-2 rounded-xl shadow-sm hover:shadow transition-all duration-200 group/btn">
                                <span>Selengkapnya</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5 transition-transform group-hover/btn:translate-x-1"></i>
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

        <div class="mt-8 text-center sm:hidden" data-aos="fade-up">
            <a href="{{ route('public.kegiatan.index') }}" class="inline-flex items-center gap-2 bg-brand-50 text-brand-600 hover:bg-brand-100 font-semibold px-6 py-3 rounded-full text-xs transition">
                Lihat Semua Kegiatan
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>

    </div>
</section>

<!-- FASILITAS -->
<section class="relative pt-14 pb-20 lg:pb-28 bg-gray-50 overflow-hidden">
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-10" data-aos="fade-up">
            <div class="flex items-center gap-4 mb-1">
                <span class="text-xs font-bold tracking-wider text-gray-400 uppercase">FASILITAS</span>
                <div class="h-[2px] w-14 bg-blue-600"></div>
            </div>
            <h2 class="text-2xl md:text-3xl font-extrabold text-gray-700 tracking-tight uppercase">
                FASILITAS KAMI
            </h2>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @forelse ($fasilitas ?? [] as $f)
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

    <!-- Awan Transisi -->
    <div class="absolute -bottom-1 left-0 w-full pointer-events-none z-0 translate-y-[2px]">
        <img src="{{ asset('images/awan2.png') }}" alt="Awan Transisi" class="w-full h-auto block object-cover scale-[1.01] origin-bottom">
    </div>
</section>

<!-- CTA DONASI -->
<section class="py-14 bg-brand-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative bg-white rounded-2xl overflow-hidden shadow-md" data-aos="fade-up">

            <div class="absolute right-0 top-0 bottom-0 w-1/2 hidden md:block">
                <img src="{{ asset('images/anak-panti.webp') }}" alt="Anak-anak Mawar Kasih" class="w-full h-full object-cover object-center opacity-90">
                <div class="absolute inset-0 bg-gradient-to-r from-white via-white/70 to-transparent"></div>
            </div>

            <div class="relative px-8 py-12 lg:px-14 lg:py-16 max-w-lg">
                <h2 class="text-3xl lg:text-4xl font-extrabold text-gray-900 leading-tight mb-4">
                    Mari Jadi Bagian dari<br>
                    <span class="text-brand-600">Perubahan Mereka</span>
                </h2>
                <p class="text-gray-500 text-sm lg:text-base leading-relaxed mb-8">
                    Jadilah Donatur Tetap dan bantu menghadirkan kebutuhan pangan, pendidikan, serta masa depan yang lebih baik bagi anak-anak Panti Asuhan Mawar Kasih.
                </p>
                <div class="flex flex-col sm:flex-row gap-5">
                    <a href="{{ route('register') }}"
                        class="inline-flex items-center justify-center gap-2 bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold px-6 py-3.5 rounded-xl transition shadow-lg hover:shadow-brand-600/30 whitespace-nowrap">
                        <i data-lucide="user-plus" class="w-4 h-4 shrink-0"></i>
                        Daftar Donatur Tetap
                    </a>
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
