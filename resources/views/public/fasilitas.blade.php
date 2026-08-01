@extends('public.layouts.app')

@section('title', 'Fasilitas Panti')
@section('meta_desc', 'Lihat fasilitas dan sarana prasarana yang tersedia di Panti Asuhan Mawar Kasih untuk mendukung tumbuh kembang anak-anak asuh.')

@section('content')

{{-- Hero Header --}}
<section class="relative bg-gray-900 py-20 lg:py-24 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-brand-900/80 via-gray-900/90 to-gray-900"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-block px-4 py-1.5 bg-white/10 backdrop-blur-sm border border-white/20 text-white text-xs font-semibold uppercase tracking-widest rounded-full mb-5">
            Sarana & Prasarana
        </span>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white mb-4">
            Fasilitas <span class="text-brand-400">Panti Asuhan</span>
        </h1>
        <p class="text-gray-300 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed">
            Berbagai fasilitas yang kami sediakan untuk mendukung kenyamanan, pendidikan, dan tumbuh kembang anak-anak asuh di Panti Asuhan Mawar Kasih.
        </p>
    </div>
</section>

{{-- Grid Fasilitas --}}
<section class="py-14 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Counter --}}
        <div class="flex items-center justify-between mb-8" data-aos="fade-up">
            <p class="text-sm text-gray-500">
                Menampilkan <span class="font-semibold text-gray-700">{{ $fasilitas->count() }}</span> fasilitas
            </p>
            <a href="{{ route('public.home') }}"
                class="inline-flex items-center gap-1.5 text-sm font-semibold text-brand-600 hover:text-brand-700 transition group">
                <i data-lucide="arrow-left" class="w-4 h-4 group-hover:-translate-x-1 transition-transform"></i>
                Kembali ke Beranda
            </a>
        </div>

        {{-- Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">

            @forelse($fasilitas as $f)
            <article class="relative rounded-2xl overflow-hidden group cursor-pointer bg-white shadow-sm hover:shadow-lg transition-shadow duration-300"
                data-aos="fade-up" data-aos-delay="{{ $loop->index * 60 }}"
                onclick="openFasilitasModal('{{ addslashes($f->judul) }}', '{{ addslashes(str_replace(["\r\n", "\r", "\n"], ' ', $f->deskripsi)) }}', '{{ Storage::url($f->foto) }}')">

                {{-- Foto --}}
                <div class="aspect-[4/3] bg-gray-100 overflow-hidden">
                    @if($f->foto)
                        <img src="{{ Storage::url($f->foto) }}"
                            alt="{{ $f->judul }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                            loading="lazy">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-brand-50">
                            <i data-lucide="image" class="w-12 h-12 text-brand-200"></i>
                        </div>
                    @endif
                </div>

                {{-- Overlay gradient --}}
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                {{-- Info --}}
                <div class="p-4">
                    <h3 class="font-bold text-gray-900 text-sm group-hover:text-brand-600 transition-colors line-clamp-1">
                        {{ $f->judul }}
                    </h3>
                    <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $f->deskripsi }}</p>
                </div>

                {{-- Badge klik --}}
                <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-white/90 backdrop-blur-sm rounded-full text-xs font-medium text-gray-700 shadow-sm">
                        <i data-lucide="expand" class="w-3 h-3"></i>
                        Lihat
                    </span>
                </div>
            </article>

            @empty
            <div class="col-span-full py-20 text-center">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="building-2" class="w-10 h-10 text-gray-300"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-700 mb-1">Belum Ada Fasilitas</h3>
                <p class="text-sm text-gray-400">Data fasilitas belum ditambahkan oleh admin.</p>
                <a href="{{ route('public.home') }}"
                    class="inline-flex items-center gap-2 mt-6 bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold px-6 py-3 rounded-full transition">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Kembali ke Beranda
                </a>
            </div>
            @endforelse

        </div>
    </div>
</section>

{{-- Modal Detail Fasilitas --}}
<div id="fasilitasModal"
    class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 opacity-0 invisible transition-all duration-300"
    onclick="closeFasilitasModal(event)">

    <div class="bg-white rounded-2xl overflow-hidden max-w-lg w-full shadow-2xl transform scale-95 transition-transform duration-300" id="fasilitasModalBox">
        {{-- Foto fasilitas --}}
        <div class="aspect-video bg-gray-100">
            <img id="fasilitasModalImg" src="" alt="" class="w-full h-full object-cover">
        </div>
        {{-- Konten modal --}}
        <div class="p-6">
            <h3 id="fasilitasModalTitle" class="text-xl font-bold text-gray-900 mb-2"></h3>
            <p id="fasilitasModalDesc" class="text-gray-500 text-sm leading-relaxed mb-5"></p>
            <button onclick="closeFasilitasModal()"
                class="w-full bg-brand-600 hover:bg-brand-700 text-white font-semibold py-2.5 rounded-xl transition">
                Tutup
            </button>
        </div>
    </div>
</div>

@endsection

@section('extra_scripts')
<script>
    function openFasilitasModal(nama, desc, imgSrc) {
        document.getElementById('fasilitasModalTitle').textContent = nama;
        document.getElementById('fasilitasModalDesc').textContent = desc;
        document.getElementById('fasilitasModalImg').src = imgSrc;
        document.getElementById('fasilitasModalImg').alt = nama;

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

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeFasilitasModal();
    });
</script>
@endsection