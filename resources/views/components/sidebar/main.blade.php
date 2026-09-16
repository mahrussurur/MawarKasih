<aside class="sidebar fixed inset-y-0 left-0 z-50 flex flex-col overflow-hidden bg-blue-700 text-white">
    <!-- Header Sidebar / Brand Logo -->
    <div class="sidebar-brand flex items-center justify-between gap-3 border-b border-white/10 px-3.5 py-3 transition-all duration-300">
        <div class="sidebar-brand-info flex items-center gap-3 overflow-hidden">
            <div class="sidebar-brand-icon flex h-10 w-10 shrink-0 items-center justify-center overflow-hidden rounded-xl bg-transparent">
                <img src="/images/logo2.webp" alt="Logo MTK" class="h-full w-full object-contain"
                    onerror="this.style.display='none';this.parentElement.innerHTML='<span class=\'text-[11px] font-extrabold text-white/80\'>MTK</span>'">
            </div>
            <div class="sidebar-brand-text overflow-hidden whitespace-nowrap transition-all duration-200">
                <div class="text-[10px] font-bold uppercase tracking-[0.18em] text-white/50">Yayasan</div>
                <div class="mt-0.5 text-[15px] font-bold text-white">Mawar Kasih</div>
            </div>
        </div>

        <!-- Tombol Toggle Desktop -->
        <button type="button" 
                class="sidebar-toggle hidden h-9 w-9 shrink-0 items-center justify-center rounded-lg text-white/80 transition hover:bg-white/10 hover:text-white md:flex" 
                onclick="toggleSidebar()" 
                aria-label="Toggle sidebar">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    <!-- Menu Navigasi -->
    <nav class="sidebar-nav flex-1 overflow-y-auto overflow-x-hidden px-3.5 py-3.5">
        @php
            $role = Auth::user()?->role ?? 'guest';
            $dashboardRoute = $role . '.dashboard';
            
            // Fallback jika route tidak ditemukan (menghindari error)
            if (!Route::has($dashboardRoute)) {
                $dashboardRoute = 'dashboard'; 
            }
        @endphp

        <div class="nav-label mb-1 overflow-hidden whitespace-nowrap px-2.5 pt-2 text-[10px] font-bold uppercase tracking-[0.2em] text-white/40 transition-all duration-200">
            Menu Utama
        </div>

        <a href="{{ route($dashboardRoute) }}" data-tooltip="Dashboard" class="nav-item relative mb-1 flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-semibold text-white/70 transition hover:bg-white/10 hover:text-white {{ request()->routeIs($dashboardRoute) ? 'bg-white/15 text-white font-bold' : '' }}">
            <span class="absolute inset-y-1.5 left-0 w-1 rounded-r-full {{ request()->routeIs($dashboardRoute) ? 'bg-blue-300' : 'bg-transparent' }}"></span>
            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            <span class="nav-text">Dashboard</span>
        </a>

        @if($role === 'admin')
            <!-- DATA MANAJEMEN -->
            <div class="nav-label mt-3 overflow-hidden whitespace-nowrap px-2.5 pt-2 text-[10px] font-bold uppercase tracking-[0.2em] text-white/40 transition-all duration-200">Manajemen Akun</div>
            <a href="{{ route('users.index') }}" data-tooltip="Data User" class="nav-item relative mb-1 flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-semibold text-white/70 transition hover:bg-white/10 hover:text-white {{ request()->routeIs('users.*') ? 'bg-white/15 text-white font-bold' : '' }}">
                <span class="absolute inset-y-1.5 left-0 w-1 rounded-r-full {{ request()->routeIs('users.*') ? 'bg-blue-300' : 'bg-transparent' }}"></span>
                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                <span class="nav-text">Data User</span>
            </a>

            <div class="nav-label mt-3 overflow-hidden whitespace-nowrap px-2.5 pt-2 text-[10px] font-bold uppercase tracking-[0.2em] text-white/40 transition-all duration-200">Data Yayasan</div>
            <a href="{{ route('anak-asuh.index') }}" data-tooltip="Anak Asuh" class="nav-item relative mb-1 flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-semibold text-white/70 transition hover:bg-white/10 hover:text-white {{ request()->routeIs('anak-asuh.*') ? 'bg-white/15 text-white font-bold' : '' }}">
                <span class="absolute inset-y-1.5 left-0 w-1 rounded-r-full {{ request()->routeIs('anak-asuh.*') ? 'bg-blue-300' : 'bg-transparent' }}"></span>
                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                <span class="nav-text">Data Anak Asuh</span>
            </a>
            @foreach(['pengasuh' => 'Data Pengasuh', 'bendahara' => 'Data Bendahara', 'sekretaris' => 'Data Sekretaris', 'donatur' => 'Data Donatur'] as $r => $label)
            <a href="{{ route('admin.pengelola.index', $r) }}" data-tooltip="{{ $label }}" class="nav-item relative mb-1 flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-semibold text-white/70 transition hover:bg-white/10 hover:text-white {{ request()->is('admin/data/' . $r . '*') ? 'bg-white/15 text-white font-bold' : '' }}">
                <span class="absolute inset-y-1.5 left-0 w-1 rounded-r-full {{ request()->is('admin/data/' . $r . '*') ? 'bg-blue-300' : 'bg-transparent' }}"></span>
                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <span class="nav-text">{{ $label }}</span>
            </a>
            @endforeach
            <a href="{{ route('kegiatan.index') }}" data-tooltip="Data Kegiatan" class="nav-item relative mb-1 flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-semibold text-white/70 transition hover:bg-white/10 hover:text-white {{ request()->routeIs('kegiatan.*') ? 'bg-white/15 text-white font-bold' : '' }}">
                <span class="absolute inset-y-1.5 left-0 w-1 rounded-r-full {{ request()->routeIs('kegiatan.*') ? 'bg-blue-300' : 'bg-transparent' }}"></span>
                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                <span class="nav-text">Data Kegiatan</span>
            </a>
            <a href="{{ route('galeri.index') }}" data-tooltip="Galeri" class="nav-item relative mb-1 flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-semibold text-white/70 transition hover:bg-white/10 hover:text-white {{ request()->routeIs('galeri.*') ? 'bg-white/15 text-white font-bold' : '' }}">
                <span class="absolute inset-y-1.5 left-0 w-1 rounded-r-full {{ request()->routeIs('galeri.*') ? 'bg-blue-300' : 'bg-transparent' }}"></span>
                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span class="nav-text">Galeri</span>
            </a>

            <div class="nav-label mt-3 overflow-hidden whitespace-nowrap px-2.5 pt-2 text-[10px] font-bold uppercase tracking-[0.2em] text-white/40 transition-all duration-200">Donasi & keuangan</div>
            <a href="{{ route('donasi.index') }}" data-tooltip="Donasi" class="nav-item relative mb-1 flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-semibold text-white/70 transition hover:bg-white/10 hover:text-white {{ request()->routeIs('donasi.*') ? 'bg-white/15 text-white font-bold' : '' }}">
                <span class="absolute inset-y-1.5 left-0 w-1 rounded-r-full {{ request()->routeIs('donasi.*') ? 'bg-blue-300' : 'bg-transparent' }}"></span>
                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                <span class="nav-text">Donasi</span>
            </a>
            <a href="{{ route('admin.keuangan.index') }}" data-tooltip="Transaksi Keuangan" class="nav-item relative mb-1 flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-semibold text-white/70 transition hover:bg-white/10 hover:text-white {{ request()->routeIs('admin.keuangan.index', 'admin.keuangan.create', 'admin.keuangan.edit') ? 'bg-white/15 text-white font-bold' : '' }}">
                <span class="absolute inset-y-1.5 left-0 w-1 rounded-r-full {{ request()->routeIs('admin.keuangan.*') ? 'bg-blue-300' : 'bg-transparent' }}"></span>
                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span class="nav-text">Transaksi Keuangan</span>
            </a>

        @elseif($role === 'bendahara')
            <div class="nav-label mt-3 overflow-hidden whitespace-nowrap px-2.5 pt-2 text-[10px] font-bold uppercase tracking-[0.2em] text-white/40 transition-all duration-200">Keuangan</div>
            <a href="{{ route('bendahara.donasi.index') }}" data-tooltip="Data Donasi" class="nav-item relative mb-1 flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-semibold text-white/70 transition hover:bg-white/10 hover:text-white {{ request()->routeIs('bendahara.donasi.*') ? 'bg-white/15 text-white font-bold' : '' }}">
                <span class="absolute inset-y-1.5 left-0 w-1 rounded-r-full {{ request()->routeIs('bendahara.donasi.*') ? 'bg-blue-300' : 'bg-transparent' }}"></span>
                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                <span class="nav-text">Data Donasi</span>
            </a>
            <a href="{{ route('bendahara.transaksi.index') }}" data-tooltip="Transaksi Keuangan" class="nav-item relative mb-1 flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-semibold text-white/70 transition hover:bg-white/10 hover:text-white {{ request()->routeIs('bendahara.transaksi.index', 'bendahara.transaksi.create', 'bendahara.transaksi.edit') ? 'bg-white/15 text-white font-bold' : '' }}">
                <span class="absolute inset-y-1.5 left-0 w-1 rounded-r-full {{ request()->routeIs('bendahara.transaksi.*') ? 'bg-blue-300' : 'bg-transparent' }}"></span>
                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span class="nav-text">Transaksi Keuangan</span>
            </a>
            <a href="{{ route('bendahara.transaksi.cetak') }}" data-tooltip="Laporan Keuangan" target="_blank" class="nav-item relative mb-1 flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-semibold text-white/70 transition hover:bg-white/10 hover:text-white">
                <span class="absolute inset-y-1.5 left-0 w-1 rounded-r-full bg-transparent"></span>
                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9V2h12v7m-12 9H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2m-12 0h12v4H6v-4z"/></svg>
                <span class="nav-text">Laporan Keuangan</span>
            </a>
        @elseif($role === 'sekretaris')
            <div class="nav-label mt-3 overflow-hidden whitespace-nowrap px-2.5 pt-2 text-[10px] font-bold uppercase tracking-[0.2em] text-white/40 transition-all duration-200">Data Yayasan</div>
            <a href="{{ route('sekretaris.kegiatan.index') }}" data-tooltip="Data Kegiatan" class="nav-item relative mb-1 flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-semibold text-white/70 transition hover:bg-white/10 hover:text-white {{ request()->routeIs('sekretaris.kegiatan.*') ? 'bg-white/15 text-white font-bold' : '' }}">
                <span class="absolute inset-y-1.5 left-0 w-1 rounded-r-full {{ request()->routeIs('sekretaris.kegiatan.*') ? 'bg-blue-300' : 'bg-transparent' }}"></span>
                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                <span class="nav-text">Data Kegiatan</span>
            </a>
            <a href="{{ route('sekretaris.galeri.index') }}" data-tooltip="Galeri" class="nav-item relative mb-1 flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-semibold text-white/70 transition hover:bg-white/10 hover:text-white {{ request()->routeIs('sekretaris.galeri.*') ? 'bg-white/15 text-white font-bold' : '' }}">
                <span class="absolute inset-y-1.5 left-0 w-1 rounded-r-full {{ request()->routeIs('sekretaris.galeri.*') ? 'bg-blue-300' : 'bg-transparent' }}"></span>
                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span class="nav-text">Galeri</span>
            </a>
        @elseif($role === 'pengasuh')
            <div class="nav-label mt-3 overflow-hidden whitespace-nowrap px-2.5 pt-2 text-[10px] font-bold uppercase tracking-[0.2em] text-white/40 transition-all duration-200">Data Yayasan</div>
            <a href="{{ route('pengasuh.anak-asuh.index') }}" data-tooltip="Data Anak Asuh" class="nav-item relative mb-1 flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-semibold text-white/70 transition hover:bg-white/10 hover:text-white {{ request()->routeIs('pengasuh.anak-asuh.*') ? 'bg-white/15 text-white font-bold' : '' }}">
                <span class="absolute inset-y-1.5 left-0 w-1 rounded-r-full {{ request()->routeIs('pengasuh.anak-asuh.*') ? 'bg-blue-300' : 'bg-transparent' }}"></span>
                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                <span class="nav-text">Data Anak Asuh</span>
            </a>
        @elseif($role === 'donatur')
            <div class="nav-label mt-3 overflow-hidden whitespace-nowrap px-2.5 pt-2 text-[10px] font-bold uppercase tracking-[0.2em] text-white/40 transition-all duration-200">Donasi Saya</div>
            <a href="{{ route('public.donasi.form') }}" data-tooltip="Donasi Baru" class="nav-item relative mb-1 flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-semibold text-white/70 transition hover:bg-white/10 hover:text-white {{ request()->routeIs('public.donasi.*') ? 'bg-white/15 text-white font-bold' : '' }}">
                <span class="absolute inset-y-1.5 left-0 w-1 rounded-r-full {{ request()->routeIs('public.donasi.*') ? 'bg-blue-300' : 'bg-transparent' }}"></span>
                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span class="nav-text">Donasi Baru</span>
            </a>
            <a href="{{ route('donatur.donasi.index') }}" data-tooltip="Riwayat Donasi" class="nav-item relative mb-1 flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-semibold text-white/70 transition hover:bg-white/10 hover:text-white {{ request()->routeIs('donatur.donasi.*') ? 'bg-white/15 text-white font-bold' : '' }}">
                <span class="absolute inset-y-1.5 left-0 w-1 rounded-r-full {{ request()->routeIs('donatur.donasi.*') ? 'bg-blue-300' : 'bg-transparent' }}"></span>
                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span class="nav-text">Riwayat Donasi</span>
            </a>
        @endif
    </nav>
</aside>
