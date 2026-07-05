<nav id="mainNav" class="fixed top-0 left-0 right-0 z-50 bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-[70px]">

            <!-- LOGO -->
            <div class="flex items-center gap-3 flex-shrink-0">

                <img src="{{ asset('images/logo.png') }}" alt="Panti Asuhan Mawar Kasih" class="h-14 w-auto">
                <div class="hidden sm:block leading-tight">
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Panti Asuhan</div>
                    <div class="text-base font-bold text-gray-900">Mawar Kasih</div>
                </div>
            </div>

            <!-- MENU DESKTOP -->
            <ul class="hidden lg:flex items-center gap-1 text-sm font-medium text-gray-700">

                <!-- Beranda -->
                <li>
                    <a href="{{ route('public.home') }}"
                        class="px-3 py-2 rounded-lg transition hover:text-brand-600 hover:bg-brand-50 {{ request()->routeIs('public.home') ? 'text-brand-600 font-semibold' : '' }}">
                        Beranda
                    </a>
                </li>

                <!-- Donasi -->
                <li class="relative group">
                    <button class="flex items-center gap-1 px-3 py-2 rounded-lg transition hover:text-brand-600 hover:bg-brand-50 {{ request()->routeIs('public.donasi*') ? 'text-brand-600 font-semibold' : '' }}">
                        Donasi
                        <i data-lucide="chevron-down" class="w-4 h-4 transition group-hover:rotate-180"></i>
                    </button>
                    <!-- Dropdown Donasi -->
                    <div class="absolute top-full left-0 mt-1 w-52 bg-white rounded-lg shadow-lg border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 py-1">
                        <a href="{{ route('public.donasi.form') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-600">
                            <i data-lucide="heart" class="w-4 h-4"></i> Form Donasi
                        </a>
                        <a href="{{ route('public.donasi.validasi') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-600">
                            <i data-lucide="check-circle" class="w-4 h-4"></i> Validasi Donasi
                        </a>
                        <a href="{{ route('public.donasi.rekening') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-600">
                            <i data-lucide="credit-card" class="w-4 h-4"></i> Rekening Donasi
                        </a>
                        <!-- <a href="{{ route('public.donasi.tutorial') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-brand-50 hover:text-brand-600">
                            <i data-lucide="book-open" class="w-4 h-4"></i> Tutorial Berdonasi
                        </a> -->
                    </div>
                </li>

                <!-- Artikel Kegiatan -->
                <li>
                    <a href="{{ route('public.kegiatan.index') }}"
                        class="px-3 py-2 rounded-lg transition hover:text-brand-600 hover:bg-brand-50 {{ request()->routeIs('public.kegiatan.index') ? 'text-brand-600 font-semibold' : '' }}">
                        Artikel Kegiatan
                    </a>
                </li>

                <!-- Tentang Kami Dropdown -->
                <li class="relative group">
                    <button class="flex items-center gap-1 px-3 py-2 rounded-lg transition hover:text-brand-600 hover:bg-brand-50 {{ request()->routeIs('public.tentang*', 'public.galeri*') ? 'text-brand-600 font-semibold' : '' }}">
                        Tentang Kami
                        <i data-lucide="chevron-down" class="w-4 h-4 transition group-hover:rotate-180"></i>
                    </button>
                    <div class="absolute top-full left-0 mt-1 w-52 bg-white rounded-lg shadow-lg border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 py-1">
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
                        <div id="donaturMenu" class="absolute right-0 top-[calc(100%+8px)] w-[200px] bg-white border border-slate-200 rounded-xl shadow-[0_10px_40px_rgba(0,0,0,0.12)] p-1.5 opacity-0 invisible transition-all duration-200 z-50">
                            
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
                    {{-- TAMBAHKAN KONDISI INI --}}
                    @if(!request()->routeIs('public.donasi.login'))
                        <a href="{{ route('public.donasi.login') }}" class="flex items-center gap-2 rounded-full border border-blue-300 bg-white px-5 py-2.5 text-sm font-semibold text-blue-700 transition hover:bg-blue-100">
                            Login
                        </a>
                    @endif
                @endif
            </div>
            
            <!-- HAMBURGER MOBILE -->
            <button class="lg:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100 transition"
                onclick="toggleMobileMenu()" aria-label="Menu">
                <i data-lucide="menu" class="w-6 h-6" id="menuIcon"></i>
            </button>
        </div>
    </div>

    <!-- MOBILE MENU -->
    <div id="mobileMenu" class="lg:hidden hidden bg-white border-t border-gray-100 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-4 space-y-1">
            <a href="{{ route('public.home') }}" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 hover:bg-brand-50 hover:text-brand-600 {{ request()->routeIs('public.home') ? 'bg-brand-50 text-brand-600' : '' }}">
                Beranda
            </a>

            <!-- Mobile: Accordion Donasi -->
            <div x-data="{ open: false }">
                <button class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 hover:bg-brand-50" onclick="toggleAccordion('acc-donasi', this)">
                    Donasi <i data-lucide="chevron-down" class="w-4 h-4 transition" id="chevron-acc-donasi"></i>
                </button>
                <div id="acc-donasi" class="hidden pl-4 mt-1 space-y-1">
                    <a href="{{ route('public.donasi.form') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-brand-600">Form Donasi</a>
                    <a href="{{ route('public.donasi.validasi') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-brand-600">Validasi Donasi</a>
                    <a href="{{ route('public.donasi.rekening') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-brand-600">Rekening Donasi</a>
                    <!-- <a href="{{ route('public.donasi.tutorial') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-brand-600">Tutorial Berdonasi</a> -->
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
                <div id="acc-tentang" class="hidden pl-4 mt-1 space-y-1">
                    <a href="{{ route('public.tentang.profil') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-brand-600">Profil Lembaga</a>
                    <a href="{{ route('public.tentang.visi-misi') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-brand-600">Visi & Misi</a>
                    <a href="{{ route('public.galeri.index') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-brand-600">Galeri</a>
                    <a href="{{ route('public.kontak') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-brand-600">Kontak</a>
                </div>
            </div>

            <div class="pt-2">
                @if(!empty($currentDonatur))
                    <div class="rounded-3xl border border-gray-200 bg-white p-3">
                        <a href="{{ route('public.donatur.profile') }}" class="flex items-center justify-between text-sm font-semibold text-gray-700 hover:text-brand-600">
                            <div class="flex items-center gap-2">
                                <i data-lucide="user" class="w-4 h-4"></i>
                                <span title="{{ $currentDonatur->nama }}">{{ \Illuminate\Support\Str::words($currentDonatur->nama, 2, '') }}</span>
                            </div>
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
                @elseif(!request()->routeIs('public.donasi.login'))
                    <div class="space-y-3">
                        <a href="{{ route('public.donasi.login') }}" class="flex items-center justify-center gap-2 rounded-full border border-brand-600 bg-white px-5 py-3 text-sm font-semibold text-brand-600 transition hover:bg-brand-50">Login</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</nav>

<!-- Spacer agar konten tidak tertutup navbar fixed -->
<div class="h-16 lg:h-[70px]"></div>

<script>
    // Toggle mobile menu
    function toggleMobileMenu() {
        const menu = document.getElementById('mobileMenu');
        menu.classList.toggle('hidden');
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
        const button = document.getElementById('donaturMenuButton');
        const menu = document.getElementById('donaturMenu');
        const chevron = document.getElementById('donaturMenuChevron');
        if (!button || !menu) return;
        if (!button.contains(event.target) && !menu.contains(event.target)) {
            menu.classList.add('opacity-0', 'invisible');
            menu.classList.remove('opacity-100', 'visible');
            if (chevron) chevron.classList.remove('rotate-180');
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