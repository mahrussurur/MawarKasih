<nav id="mainNav" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300" x-data="{ open: false, scrolled: false }" @scroll.window="scrolled = window.scrollY > 20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-[70px]">

            {{-- ===== LOGO ===== --}}
            <a href="{{ route('public.home') }}" class="flex items-center gap-3 flex-shrink-0">
                {{--
                    Ganti src dengan path logo Anda.
                    Logo sebaiknya tersimpan di: public/images/logo.png
                --}}
                <img src="{{ asset('images/logo.png') }}" alt="Panti Asuhan Mawar Kasih" class="h-10 w-auto">
                <div class="hidden sm:block leading-tight">
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Panti Asuhan</div>
                    <div class="text-base font-bold text-brand-700">Mawar Kasih</div>
                </div>
            </a>

            {{-- ===== MENU DESKTOP ===== --}}
            <ul class="hidden lg:flex items-center gap-1 text-sm font-medium text-gray-700">

                {{-- Beranda --}}
                <li>
                    <a href="{{ route('public.home') }}"
                        class="px-3 py-2 rounded-lg transition hover:text-brand-600 hover:bg-brand-50 {{ request()->routeIs('public.home') ? 'text-brand-600 font-semibold border-b-2 border-brand-600' : '' }}">
                        Beranda
                    </a>
                </li>

                {{-- Donasi Dropdown --}}
                <li class="relative group">
                    <button class="flex items-center gap-1 px-3 py-2 rounded-lg transition hover:text-brand-600 hover:bg-brand-50 {{ request()->routeIs('public.donasi*') ? 'text-brand-600 font-semibold' : '' }}">
                        Donasi
                        <i data-lucide="chevron-down" class="w-4 h-4 transition group-hover:rotate-180"></i>
                    </button>
                    {{-- Dropdown Donasi --}}
                    <div class="absolute top-full left-0 mt-1 w-52 bg-white rounded-xl shadow-lg border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 py-1">
                        <a href="{{ route('public.donasi.form') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-600">
                            <i data-lucide="heart" class="w-4 h-4"></i> Form Donasi
                        </a>
                        <a href="{{ route('public.donasi.rekening') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-600">
                            <i data-lucide="credit-card" class="w-4 h-4"></i> Rekening Donasi
                        </a>
                        <a href="{{ route('public.donasi.tutorial') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-600">
                            <i data-lucide="book-open" class="w-4 h-4"></i> Tutorial Berdonasi
                        </a>
                        <a href="{{ route('public.donasi.validasi') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-600">
                            <i data-lucide="check-circle" class="w-4 h-4"></i> Validasi Donasi
                        </a>
                    </div>
                </li>

                {{-- Kegiatan Dropdown --}}
                <li class="relative group">
                    <button class="flex items-center gap-1 px-3 py-2 rounded-lg transition hover:text-brand-600 hover:bg-brand-50 {{ request()->routeIs('public.kegiatan*') ? 'text-brand-600 font-semibold' : '' }}">
                        Kegiatan
                        <i data-lucide="chevron-down" class="w-4 h-4 transition group-hover:rotate-180"></i>
                    </button>
                    {{-- Dropdown Kegiatan --}}
                    <div class="absolute top-full left-0 mt-1 w-52 bg-white rounded-xl shadow-lg border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 py-1">
                        <a href="{{ route('public.kegiatan.index') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-600">
                            <i data-lucide="calendar" class="w-4 h-4"></i> Semua Kegiatan
                        </a>
                        {{--
                            Tambah submenu kegiatan di sini jika perlu,
                            misalnya: Kegiatan Harian, Kegiatan Sosial, dll.
                        --}}
                    </div>
                </li>

                {{-- Tentang Kami Dropdown --}}
                <li class="relative group">
                    <button class="flex items-center gap-1 px-3 py-2 rounded-lg transition hover:text-brand-600 hover:bg-brand-50 {{ request()->routeIs('public.tentang*') ? 'text-brand-600 font-semibold' : '' }}">
                        Tentang Kami
                        <i data-lucide="chevron-down" class="w-4 h-4 transition group-hover:rotate-180"></i>
                    </button>
                    <div class="absolute top-full left-0 mt-1 w-52 bg-white rounded-xl shadow-lg border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 py-1">
                        <a href="{{ route('public.tentang.profil') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-600">
                            <i data-lucide="building-2" class="w-4 h-4"></i> Profil Lembaga
                        </a>
                        <a href="{{ route('public.tentang.visi-misi') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-600">
                            <i data-lucide="target" class="w-4 h-4"></i> Visi & Misi
                        </a>
                        <a href="{{ route('public.galeri') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-600">
                            <i data-lucide="image" class="w-4 h-4"></i> Galeri
                        </a>
                        <a href="{{ route('public.kontak') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-600">
                            <i data-lucide="phone" class="w-4 h-4"></i> Kontak
                        </a>
                    </div>
                </li>

            </ul>

            {{-- ===== TOMBOL CTA ===== --}}
            <div class="hidden lg:flex items-center gap-3">
                @if(!empty($currentDonatur))
                    <div class="relative">
                        <button id="donaturMenuButton" type="button" onclick="toggleDonaturMenu()" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                            <span>{{ $currentDonatur->nama }}</span>
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </button>
                        <div id="donaturMenu" class="absolute right-0 mt-2 w-56 rounded-2xl border border-gray-200 bg-white shadow-lg opacity-0 invisible transition-all duration-200 z-50">
                            <a href="{{ route('public.donatur.profile') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50">Detail Profil</a>
                            <a href="{{ route('public.donatur.history') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50">Riwayat Donasi</a>
                            <form method="POST" action="{{ route('public.donatur.logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-gray-50">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('public.donasi.login') }}" class="flex items-center gap-2 rounded-full border border-brand-600 bg-white px-5 py-2.5 text-sm font-semibold text-brand-600 transition hover:bg-brand-50">Login Donatur</a>
                @endif
            </div>

            {{-- ===== HAMBURGER MOBILE ===== --}}
            <button class="lg:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100 transition"
                onclick="toggleMobileMenu()" aria-label="Menu">
                <i data-lucide="menu" class="w-6 h-6" id="menuIcon"></i>
            </button>
        </div>
    </div>

    {{-- ===== MOBILE MENU ===== --}}
    <div id="mobileMenu" class="lg:hidden hidden bg-white border-t border-gray-100 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-4 space-y-1">
            <a href="{{ route('public.home') }}" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 hover:bg-brand-50 hover:text-brand-600 {{ request()->routeIs('public.home') ? 'bg-brand-50 text-brand-600' : '' }}">
                Beranda
            </a>

            {{-- Mobile: Accordion Donasi --}}
            <div x-data="{ open: false }">
                <button class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 hover:bg-brand-50" onclick="toggleAccordion('acc-donasi', this)">
                    Donasi <i data-lucide="chevron-down" class="w-4 h-4 transition" id="chevron-acc-donasi"></i>
                </button>
                <div id="acc-donasi" class="hidden pl-4 mt-1 space-y-1">
                    <a href="{{ route('public.donasi.form') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-brand-600">Form Donasi</a>
                    <a href="{{ route('public.donasi.rekening') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-brand-600">Rekening Donasi</a>
                    <a href="{{ route('public.donasi.tutorial') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-brand-600">Tutorial Berdonasi</a>
                    <a href="{{ route('public.donasi.validasi') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-brand-600">Validasi Donasi</a>
                </div>
            </div>

            {{-- Mobile: Accordion Kegiatan --}}
            <div>
                <button class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 hover:bg-brand-50" onclick="toggleAccordion('acc-kegiatan', this)">
                    Kegiatan <i data-lucide="chevron-down" class="w-4 h-4 transition" id="chevron-acc-kegiatan"></i>
                </button>
                <div id="acc-kegiatan" class="hidden pl-4 mt-1 space-y-1">
                    <a href="{{ route('public.kegiatan.index') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-brand-600">Semua Kegiatan</a>
                </div>
            </div>

            {{-- Mobile: Accordion Tentang Kami --}}
            <div>
                <button class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 hover:bg-brand-50" onclick="toggleAccordion('acc-tentang', this)">
                    Tentang Kami <i data-lucide="chevron-down" class="w-4 h-4 transition" id="chevron-acc-tentang"></i>
                </button>
                <div id="acc-tentang" class="hidden pl-4 mt-1 space-y-1">
                    <a href="{{ route('public.tentang.profil') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-brand-600">Profil Lembaga</a>
                    <a href="{{ route('public.tentang.visi-misi') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-brand-600">Visi & Misi</a>
                    <a href="{{ route('public.galeri') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-brand-600">Galeri</a>
                    <a href="{{ route('public.kontak') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-brand-600">Kontak</a>
                </div>
            </div>

            <div class="pt-2">
                @if(!empty($currentDonatur))
                    <div class="rounded-3xl border border-gray-200 bg-white p-3">
                        <a href="{{ route('public.donatur.profile') }}" class="flex items-center justify-between text-sm font-semibold text-gray-700 hover:text-brand-600">
                            <span>{{ $currentDonatur->nama }}</span>
                            <i data-lucide="chevron-right" class="w-4 h-4"></i>
                        </a>
                        <div class="mt-3 space-y-2">
                            <a href="{{ route('public.donatur.history') }}" class="block rounded-full bg-brand-50 px-4 py-3 text-sm font-semibold text-brand-700 hover:bg-brand-100">Riwayat Donasi</a>
                            <form action="{{ route('public.donatur.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full rounded-full bg-red-500 px-4 py-3 text-sm font-semibold text-white hover:bg-red-600">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="space-y-3">
                        <a href="{{ route('public.donasi.login') }}" class="flex items-center justify-center gap-2 rounded-full border border-brand-600 bg-white px-5 py-3 text-sm font-semibold text-brand-600 transition hover:bg-brand-50">Login Donatur</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</nav>

{{-- Spacer agar konten tidak tertutup navbar fixed --}}
<div class="h-16 lg:h-[70px]"></div>

<script>
    // ======================================================
    // NAVBAR SCROLL EFFECT
    // Navbar transparan di atas, putih + shadow saat scroll
    // ======================================================
    const nav = document.getElementById('mainNav');
    function updateNav() {
        if (window.scrollY > 20) {
            nav.classList.add('bg-white', 'shadow-sm');
            nav.classList.remove('bg-transparent');
        } else {
            nav.classList.remove('bg-white', 'shadow-sm');
            nav.classList.add('bg-transparent');
        }
    }
    window.addEventListener('scroll', updateNav);
    updateNav(); // Jalankan saat load

    // Toggle mobile menu
    function toggleMobileMenu() {
        const menu = document.getElementById('mobileMenu');
        menu.classList.toggle('hidden');
    }

    function toggleDonaturMenu() {
        const menu = document.getElementById('donaturMenu');
        if (!menu) return;
        menu.classList.toggle('hidden');
        menu.classList.toggle('opacity-0');
        menu.classList.toggle('invisible');
        menu.classList.toggle('opacity-100');
        menu.classList.toggle('visible');
    }

    document.addEventListener('click', function (event) {
        const button = document.getElementById('donaturMenuButton');
        const menu = document.getElementById('donaturMenu');
        if (!button || !menu) return;
        if (!button.contains(event.target) && !menu.contains(event.target)) {
            menu.classList.add('hidden', 'opacity-0', 'invisible');
            menu.classList.remove('opacity-100', 'visible');
        }
    });

    // Toggle accordion mobile
    function toggleAccordion(id, btn) {
        const el = document.getElementById(id);
        el.classList.toggle('hidden');
        const chevron = document.getElementById('chevron-' + id);
        if (chevron) chevron.classList.toggle('rotate-180');
    }
</script>