{{-- =========================================================================
     NAVBAR — resources/views/public/layouts/navbar.blade.php
     Dipakai oleh : resources/views/public/layouts/app.blade.php
     ========================================================================= --}}
<nav class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ route('public.home') }}" class="flex items-center gap-3">
                {{-- Ganti src dengan asset logo sebenarnya: asset('images/logo.png') --}}
                <div class="w-10 h-10 bg-primary-700 rounded-xl flex items-center justify-center text-white font-bold text-sm">MTK</div>
                <div class="leading-tight">
                    <p class="text-xs text-gray-400 font-medium">Panti Asuhan</p>
                    <p class="text-base font-bold text-primary-700" style="font-family:'Playfair Display',serif">Mawar Kasih</p>
                </div>
            </a>

            {{-- Menu Desktop --}}
            <div class="hidden md:flex items-center gap-1">

                {{-- Beranda --}}
                <a href="{{ route('public.home') }}"
                   class="nav-link px-4 py-2 rounded-md text-sm font-semibold text-gray-600 hover:text-primary-600 transition">
                    Beranda
                </a>

                {{-- Dropdown: Donasi --}}
                <div class="relative group">
                    <button class="nav-link flex items-center gap-1 px-4 py-2 rounded-md text-sm font-semibold text-gray-600 hover:text-primary-600 transition">
                        Donasi <i class="fa-solid fa-chevron-down text-xs"></i>
                    </button>
                    <div class="absolute top-full left-0 mt-1 w-48 bg-white rounded-xl shadow-lg border border-gray-100
                                opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                        {{-- route public.donasi.index — controller: Public\DonasiPublicController@index --}}
                        <a href="{{ route('public.donasi') }}"
                           class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-700 rounded-t-xl">
                            Form Donasi
                        </a>
                        {{-- Submenu statis, tidak memerlukan controller --}}
                        <a href="{{ route('public.donasi') }}#rekening"
                           class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-700">
                            Rekening Donasi
                        </a>
                        <a href="{{ route('public.donasi') }}#cara"
                           class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-700 rounded-b-xl">
                            Tutorial Berdonasi
                        </a>
                    </div>
                </div>

                {{-- Dropdown: Kegiatan --}}
                <div class="relative group">
                    <button class="nav-link flex items-center gap-1 px-4 py-2 rounded-md text-sm font-semibold text-gray-600 hover:text-primary-600 transition">
                        Kegiatan <i class="fa-solid fa-chevron-down text-xs"></i>
                    </button>
                    <div class="absolute top-full left-0 mt-1 w-48 bg-white rounded-xl shadow-lg border border-gray-100
                                opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                        {{-- route public.kegiatan.index — controller: Public\KegiatanPublicController@index --}}
                        <a href="{{ route('public.kegiatan') }}"
                           class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-700 rounded-t-xl">
                            Semua Kegiatan
                        </a>
                        {{-- Galeri: route public.galeri — controller: Public\GaleriPublicController@index --}}
                        <a href="{{ route('public.galeri') }}"
                           class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-700 rounded-b-xl">
                            Galeri Foto
                        </a>
                    </div>
                </div>

                {{-- Dropdown: Tentang Kami --}}
                <div class="relative group">
                    <button class="nav-link flex items-center gap-1 px-4 py-2 rounded-md text-sm font-semibold text-gray-600 hover:text-primary-600 transition">
                        Tentang Kami <i class="fa-solid fa-chevron-down text-xs"></i>
                    </button>
                    <div class="absolute top-full left-0 mt-1 w-48 bg-white rounded-xl shadow-lg border border-gray-100
                                opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                        {{-- route public.tentang — controller: Public\ProfilOrfanatController@index --}}
                        <a href="{{ route('public.tentang') }}"
                           class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-700 rounded-t-xl">
                            Profil Lembaga
                        </a>
                        <a href="{{ route('public.tentang') }}#visi-misi"
                           class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-700">
                            Visi & Misi
                        </a>
                        <a href="{{ route('public.tentang') }}#kontak"
                           class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-700 rounded-b-xl">
                            Kontak
                        </a>
                    </div>
                </div>
            </div>

            {{-- CTA Button --}}
            <div class="hidden md:block">
                <a href="{{ route('public.donasi') }}"
                   class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold px-5 py-2.5 rounded-full transition">
                    <i class="fa-regular fa-heart"></i>
                    Registrasi Donatur Tetap
                </a>
            </div>

            {{-- Hamburger Mobile --}}
            <button id="mobile-menu-btn" class="md:hidden p-2 rounded-md text-gray-600 hover:bg-gray-100">
                <i class="fa-solid fa-bars text-xl"></i>
            </button>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div id="mobile-menu" class="hidden md:hidden border-t border-gray-100 bg-white px-4 pb-4">
        <a href="{{ route('public.home') }}" class="block py-2.5 text-sm font-semibold text-gray-700">Beranda</a>
        <a href="{{ route('public.donasi') }}" class="block py-2.5 text-sm font-semibold text-gray-700">Donasi</a>
        <a href="{{ route('public.kegiatan') }}" class="block py-2.5 text-sm font-semibold text-gray-700">Kegiatan</a>
        <a href="{{ route('public.galeri') }}" class="block py-2.5 text-sm font-semibold text-gray-700">Galeri</a>
        <a href="{{ route('public.tentang') }}" class="block py-2.5 text-sm font-semibold text-gray-700">Tentang Kami</a>
        <a href="{{ route('public.donasi') }}"
           class="mt-3 block text-center bg-primary-600 text-white text-sm font-semibold px-4 py-2.5 rounded-full">
            Registrasi Donatur Tetap
        </a>
    </div>
</nav>