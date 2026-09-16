@php
    $isHome = request()->routeIs('public.home');
@endphp
<nav id="mainNav" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 {{ $isHome ? 'nav-transparent bg-transparent backdrop-blur-md border-b border-white/20' : 'bg-white shadow-sm' }}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-[70px]">

            <!-- LOGO -->
            <div class="flex items-center gap-3 flex-shrink-0">
                <img src="{{ asset('images/logo2.webp') }}" alt="Panti Asuhan Mawar Kasih" class="h-11 w-auto bg-white rounded-lg">
                <span class="brand-text flex flex-col hidden sm:flex leading-tight text-gray-900">
                    <strong>Panti Asuhan</strong>
                    <small>Mawar Kasih</small>
                </span>
            </div>

            <!-- MENU DESKTOP -->
            <ul id="desktopMenu" class="hidden lg:flex items-center gap-1 text-sm font-medium text-gray-800">

                <!-- Beranda -->
                <li>
                    <a href="{{ route('public.home') }}"
                        class="nav-link px-3 py-2 rounded-lg transition hover:text-brand-600 hover:bg-brand-50 {{ request()->routeIs('public.home') ? 'active text-brand-600 font-semibold' : '' }}">
                        Beranda
                    </a>
                </li>

                <!-- Donasi -->
                <li class="relative group">
                    <button class="nav-link flex items-center gap-1 px-3 py-2 rounded-lg transition hover:text-brand-600 hover:bg-brand-50 {{ request()->routeIs('public.donasi*') ? 'active text-brand-600 font-semibold' : '' }}">
                        Donasi
                        <i data-lucide="chevron-down" class="w-4 h-4 transition group-hover:rotate-180"></i>
                    </button>
                    <!-- Dropdown Donasi -->
                    <div class="absolute top-full left-0 mt-1 w-52 bg-white/80 backdrop-blur-lg rounded-xl shadow-lg border border-white/50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 py-1 overflow-hidden">
                        <a href="{{ route('public.donasi.form') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-600">
                            <i data-lucide="heart" class="w-4 h-4"></i> Form Donasi
                        </a>
                        <a href="{{ route('public.donasi.validasi') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-600">
                            <i data-lucide="check-circle" class="w-4 h-4"></i> Validasi Donasi
                        </a>
                        <a href="{{ route('public.donasi.rekening') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-600">
                            <i data-lucide="credit-card" class="w-4 h-4"></i> Rekening Donasi
                        </a>
                    </div>
                </li>

                <!-- Artikel Kegiatan -->
                <li>
                    <a href="{{ route('public.kegiatan.index') }}"
                        class="nav-link px-3 py-2 rounded-lg transition hover:text-brand-600 hover:bg-brand-50 {{ request()->routeIs('public.kegiatan.index') ? 'active text-brand-600 font-semibold' : '' }}">
                        Artikel Kegiatan
                    </a>
                </li>

                <!-- Tentang Kami Dropdown -->
                <li class="relative group">
                    <button class="nav-link flex items-center gap-1 px-3 py-2 rounded-lg transition hover:text-brand-600 hover:bg-brand-50 {{ request()->routeIs('public.tentang*', 'public.galeri*') ? 'active text-brand-600 font-semibold' : '' }}">
                        Tentang Kami
                        <i data-lucide="chevron-down" class="w-4 h-4 transition group-hover:rotate-180"></i>
                    </button>
                    <div class="absolute top-full left-0 mt-1 w-52 bg-white/80 backdrop-blur-lg rounded-xl shadow-lg border border-white/50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 py-1 overflow-hidden">
                        <a href="{{ route('public.tentang.profil') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-600">
                            <i data-lucide="building-2" class="w-4 h-4"></i> Profil Lembaga
                        </a>
                        <a href="{{ route('public.tentang.visi-misi') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-600">
                            <i data-lucide="target" class="w-4 h-4"></i> Visi & Misi
                        </a>
                        <a href="{{ route('public.galeri.index') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-600">
                            <i data-lucide="image" class="w-4 h-4"></i> Galeri
                        </a>
                        <a href="{{ route('public.kontak') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-600">
                            <i data-lucide="phone" class="w-4 h-4"></i> Kontak
                        </a>
                    </div>
                </li>

            </ul>

            <!-- TOMBOL CTA -->
            <div class="hidden lg:flex items-center gap-3">
                @if(!empty($currentDonatur))
                    <div class="relative">
                        <button id="donaturMenuButton" type="button" onclick="toggleDonaturMenu()" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-gray-100">
                            <i data-lucide="user-check" class="w-4 h-4"></i>
                            <span title="{{ $currentDonatur->nama }}">{{ \Illuminate\Support\Str::words($currentDonatur->nama, 2, '') }}</span>
                            <i id="donaturMenuChevron" data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-200"></i>
                        </button>
                        <div id="donaturMenu" class="absolute right-0 top-[calc(100%+8px)] w-[200px] bg-white/80 backdrop-blur-lg border border-white/50 rounded-xl shadow-lg p-1.5 opacity-0 invisible transition-all duration-200 z-50">
                            
                            <div class="px-3 pt-2.5 pb-2 border-b border-slate-100 mb-1">
                                <div class="text-[13px] font-bold text-slate-900 truncate">{{ $currentDonatur->nama }}</div>
                                <div class="text-[11px] font-medium text-slate-400">Donatur</div>
                            </div>

                            <a href="{{ route('public.donatur.profile') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-gray-600 text-[13px] font-semibold hover:bg-gray-100 hover:text-gray-900 transition-colors w-full">
                                <i data-lucide="user" class="w-4 h-4"></i>
                                Profil Saya
                            </a>
                            
                            <a href="{{ route('public.donatur.history') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-gray-600 text-[13px] font-semibold hover:bg-gray-100 hover:text-gray-900 transition-colors w-full">
                                <i data-lucide="clock" class="w-4 h-4"></i>
                                Riwayat Donasi
                            </a>

                            <div class="h-px bg-slate-100 my-1"></div>

                            <form method="POST" action="{{ route('public.donatur.logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center gap-2.5 w-full text-left px-3 py-2.5 rounded-lg text-red-500 text-[13px] font-semibold hover:bg-red-50 transition-colors cursor-pointer border-none bg-transparent">
                                    <i data-lucide="log-out" class="w-4 h-4"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    @if(!request()->routeIs('public.donasi.login'))
                        <a href="{{ route('public.donasi.login') }}" class="flex items-center justify-center gap-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 font-semibold transition">
                            Login
                        </a>
                    @endif
                @endif
            </div>
            
            <!-- HAMBURGER MOBILE -->
            <button id="hamburgerBtn" class="lg:hidden p-2 rounded-lg text-gray-800 transition hover:bg-gray-100"
                onclick="toggleMobileMenu()" aria-label="Menu">
                <i data-lucide="menu" class="w-6 h-6" id="menuIcon"></i>
            </button>
        </div>
    </div>

    <!-- MOBILE MENU -->
    <div id="mobileMenu" class="lg:hidden absolute w-full top-full left-0 bg-white/80 backdrop-blur-xl border-t border-white/50 shadow-lg transition-all duration-300 ease-out opacity-0 -translate-y-4 invisible">
        <div class="max-w-7xl mx-auto px-4 py-4 space-y-1">
            <a href="{{ route('public.home') }}" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 hover:bg-brand-50 hover:text-brand-600 {{ request()->routeIs('public.home') ? 'bg-brand-50 text-brand-600' : '' }}">
                Beranda
            </a>

            <!-- Mobile: Accordion Donasi -->
            <div x-data="{ open: false }">
                <button class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 hover:bg-brand-50" onclick="toggleAccordion('acc-donasi', this)">
                    Donasi <i data-lucide="chevron-down" class="w-4 h-4 transition" id="chevron-acc-donasi"></i>
                </button>
                <div id="acc-donasi" class="hidden pl-4 mt-1 space-y-1 overflow-hidden">
                    <a href="{{ route('public.donasi.form') }}" class="block px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-brand-50 hover:text-brand-600">Form Donasi</a>
                    <a href="{{ route('public.donasi.validasi') }}" class="block px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-brand-50 hover:text-brand-600">Validasi Donasi</a>
                    <a href="{{ route('public.donasi.rekening') }}" class="block px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-brand-50 hover:text-brand-600">Rekening Donasi</a>
                </div>
            </div>

            <!-- Mobile: Accordion Kegiatan -->
            <a href="{{ route('public.kegiatan.index') }}" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 hover:bg-brand-50 hover:text-brand-600 {{ request()->routeIs('public.kegiatan.index') ? 'bg-brand-50 text-brand-600' : '' }}">
                Artikel Kegiatan
            </a>

            <!-- Mobile: Accordion Tentang Kami -->
            <div>
                <button class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 hover:bg-brand-50" onclick="toggleAccordion('acc-tentang', this)">
                    Tentang Kami <i data-lucide="chevron-down" class="w-4 h-4 transition" id="chevron-acc-tentang"></i>
                </button>
                <div id="acc-tentang" class="hidden pl-4 mt-1 space-y-1 overflow-hidden">
                    <a href="{{ route('public.tentang.profil') }}" class="block px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-brand-50 hover:text-brand-600">Profil Lembaga</a>
                    <a href="{{ route('public.tentang.visi-misi') }}" class="block px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-brand-50 hover:text-brand-600">Visi & Misi</a>
                    <a href="{{ route('public.galeri.index') }}" class="block px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-brand-50 hover:text-brand-600">Galeri</a>
                    <a href="{{ route('public.kontak') }}" class="block px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-brand-50 hover:text-brand-600">Kontak</a>
                </div>
            </div>

            <div class="pt-2">
                @if(!empty($currentDonatur))
                    <div>
                        <button class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-sm font-semibold text-blue-700 bg-blue-50 border border-blue-200 shadow-sm hover:bg-blue-100 transition-all" onclick="toggleAccordion('acc-profile', this)">
                            <div class="flex items-center gap-2.5">
                                <div class="bg-blue-100 p-1.5 rounded-full text-blue-600">
                                    <i data-lucide="user-check" class="w-4 h-4"></i>
                                </div>
                                <span title="{{ $currentDonatur->nama }}" class="tracking-wide">{{ \Illuminate\Support\Str::words($currentDonatur->nama, 2, '') }}</span>
                            </div>
                            <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-300" id="chevron-acc-profile"></i>
                        </button>
                        <div id="acc-profile" class="hidden pl-4 mt-2 space-y-1">
                            <a href="{{ route('public.donatur.profile') }}" class="flex items-center gap-2 px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-brand-50 hover:text-brand-600">
                                <i data-lucide="user" class="w-4 h-4"></i> Profil Saya
                            </a>
                            <a href="{{ route('public.donatur.history') }}" class="flex items-center gap-2 px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-brand-50 hover:text-brand-600">
                                <i data-lucide="clock" class="w-4 h-4"></i> Riwayat Donasi
                            </a>
                            <form action="{{ route('public.donatur.logout') }}" method="POST" class="mt-1">
                                @csrf
                                <button type="submit" class="flex items-center gap-2 w-full text-left px-3 py-2.5 rounded-lg text-sm text-red-500 hover:bg-red-50 hover:text-red-600 transition-colors">
                                    <i data-lucide="log-out" class="w-4 h-4"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @elseif(!request()->routeIs('public.donasi.login'))
                    <div class="space-y-3">
                        <a href="{{ route('public.donasi.login') }}" class="flex items-center justify-center gap-2 rounded-full bg-blue-600 hover:bg-blue-700 px-5 py-3 text-sm font-semibold text-white transition">Login</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</nav>

<!-- OVERLAY MOBILE MENU -->
<div id="mobileMenuOverlay" class="fixed top-16 inset-x-0 bottom-0 bg-black/50 z-40 backdrop-blur-sm transition-opacity duration-300 lg:hidden opacity-0 invisible" aria-hidden="true"></div>

@if(!$isHome)
<!-- Spacer agar konten tidak tertutup navbar fixed -->
<div class="h-16 lg:h-[70px]"></div>
@endif

<style>
    .nav-transparent .brand-text { color: #ffffff !important; }
    .nav-transparent #desktopMenu { color: rgba(255, 255, 255, 0.9) !important; }
    
    .nav-transparent .nav-link { color: rgba(255, 255, 255, 0.9) !important; }
    .nav-transparent .nav-link:hover { 
        background-color: rgba(255, 255, 255, 0.15) !important; 
        color: #ffffff !important; 
    }
    .nav-transparent .nav-link.active { 
        color: #ffffff !important; 
        font-weight: 700 !important; 
    }
    
    .nav-transparent #hamburgerBtn { color: #ffffff !important; }
    .nav-transparent #hamburgerBtn:hover { background-color: rgba(255, 255, 255, 0.15) !important; }
    
    .nav-transparent #donaturMenuButton { 
        background-color: rgba(255, 255, 255, 0.15) !important; 
        border-color: rgba(255, 255, 255, 0.3) !important; 
        color: #ffffff !important; 
        backdrop-filter: blur(8px);
    }
    .nav-transparent #donaturMenuButton:hover { 
        background-color: rgba(255, 255, 255, 0.25) !important; 
    }
</style>

<script>
    // Navbar scroll effect
    document.addEventListener('scroll', function() {
        const nav = document.getElementById('mainNav');
        const isHome = @json($isHome);
        
        if (isHome && nav) {
            if (window.scrollY > 20) {
                nav.classList.remove('nav-transparent', 'bg-transparent', 'backdrop-blur-md', 'border-b', 'border-white/20');
                nav.classList.add('bg-white', 'shadow-sm');
            } else {
                nav.classList.add('nav-transparent', 'bg-transparent', 'backdrop-blur-md', 'border-b', 'border-white/20');
                nav.classList.remove('bg-white', 'shadow-sm');
            }
        }
    });

    // Toggle mobile menu
    function toggleMobileMenu() {
        const menu = document.getElementById('mobileMenu');
        const overlay = document.getElementById('mobileMenuOverlay');
        
        if (menu) {
            menu.classList.toggle('opacity-100');
            menu.classList.toggle('translate-y-0');
            menu.classList.toggle('visible');
            menu.classList.toggle('opacity-0');
            menu.classList.toggle('-translate-y-4');
            menu.classList.toggle('invisible');
        }
        
        if (overlay) {
            overlay.classList.toggle('opacity-100');
            overlay.classList.toggle('visible');
            overlay.classList.toggle('opacity-0');
            overlay.classList.toggle('invisible');
        }
    }

    function toggleDonaturMenu() {
        const menu = document.getElementById('donaturMenu');
        const chevron = document.getElementById('donaturMenuChevron');
        if (!menu) return;
        menu.classList.toggle('opacity-0');
        menu.classList.toggle('invisible');
        menu.classList.toggle('opacity-100');
        menu.classList.toggle('visible');
        if (chevron) chevron.classList.toggle('rotate-180');
    }

    document.addEventListener('click', function (event) {
        // --- Logika untuk Donatur Menu (Desktop) ---
        const donaturBtn = document.getElementById('donaturMenuButton');
        const donaturMenu = document.getElementById('donaturMenu');
        const chevron = document.getElementById('donaturMenuChevron');
        
        if (donaturBtn && donaturMenu) {
            if (!donaturBtn.contains(event.target) && !donaturMenu.contains(event.target)) {
                donaturMenu.classList.add('opacity-0', 'invisible');
                donaturMenu.classList.remove('opacity-100', 'visible');
                if (chevron) chevron.classList.remove('rotate-180');
            }
        }

        // --- Logika untuk Mobile Menu ---
        const mobileMenu = document.getElementById('mobileMenu');
        const overlay = document.getElementById('mobileMenuOverlay');
        // Mencari apakah target klik adalah tombol hamburger atau anaknya
        const clickedOnHamburger = event.target.closest('[onclick="toggleMobileMenu()"]');
        
        if (mobileMenu && mobileMenu.classList.contains('visible')) {
            // Jika klik terjadi di luar mobileMenu DAN bukan di tombol hamburger
            if (!mobileMenu.contains(event.target) && !clickedOnHamburger) {
                mobileMenu.classList.remove('opacity-100', 'translate-y-0', 'visible');
                mobileMenu.classList.add('opacity-0', '-translate-y-4', 'invisible');
                if (overlay) {
                    overlay.classList.remove('opacity-100', 'visible');
                    overlay.classList.add('opacity-0', 'invisible');
                }
            }
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
