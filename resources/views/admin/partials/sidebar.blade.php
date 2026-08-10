<aside class="sidebar fixed inset-y-0 left-0 z-50 flex flex-col overflow-hidden bg-[#1E4FBC] text-white">
    <div class="flex items-center gap-3 border-b border-white/10 px-3.5 py-[9.5px] transition-all duration-300">
        <div class="flex h-11 w-11 shrink-0 items-center justify-center overflow-hidden rounded-xl bg-transparent">
            <img src="/images/logo2.webp" alt="Logo MTK" class="h-full w-full object-contain"
                onerror="this.style.display='none';this.parentElement.innerHTML='<span class=\'text-[11px] font-extrabold text-white/80\'>MTK</span>'">
        </div>
        <div class="sidebar-brand-text overflow-hidden whitespace-nowrap transition-all duration-200">
            <div class="text-[10px] font-bold uppercase tracking-[0.18em] text-white/50">Yayasan</div>
            <div class="mt-0.5 text-[15px] font-bold text-white">Mawar Kasih</div>
        </div>
    </div>

    <nav class="sidebar-nav flex-1 overflow-y-auto px-3.5 py-3.5">
        <div class="nav-label mb-1 overflow-hidden whitespace-nowrap px-2.5 pt-2 text-[10px] font-bold uppercase tracking-[0.2em] text-white/30 transition-all duration-200">Menu Utama</div>

        <a href="{{ route('dashboard') }}" data-tooltip="Dashboard" class="nav-item relative mb-1 flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-semibold text-white/70 transition hover:bg-white/5 hover:text-white {{ request()->routeIs('dashboard') ? 'bg-blue-500/20 text-blue-200' : '' }}">
            <span class="absolute inset-y-1.5 left-0 w-1 rounded-r-full {{ request()->routeIs('dashboard') ? 'bg-blue-400' : 'bg-transparent' }}"></span>
            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            <span class="nav-text">Dashboard</span>
        </a>

        <div class="nav-label mt-2 overflow-hidden whitespace-nowrap px-2.5 pt-2 text-[10px] font-bold uppercase tracking-[0.2em] text-white/30 transition-all duration-200">Data</div>

        <a href="{{ route('anak-asuh.index') }}" data-tooltip="Data Anak Asuh" class="nav-item relative mb-1 flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-semibold text-white/70 transition hover:bg-white/5 hover:text-white {{ request()->routeIs('anak-asuh.*') ? 'bg-blue-500/20 text-blue-200' : '' }}">
            <span class="absolute inset-y-1.5 left-0 w-1 rounded-r-full {{ request()->routeIs('anak-asuh.*') ? 'bg-blue-400' : 'bg-transparent' }}"></span>
            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            <span class="nav-text">Data Anak Asuh</span>
        </a>

        <a href="{{ route('pengasuh.index') }}" data-tooltip="Data Pengasuh" class="nav-item relative mb-1 flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-semibold text-white/70 transition hover:bg-white/5 hover:text-white {{ request()->routeIs('pengasuh.*') ? 'bg-blue-500/20 text-blue-200' : '' }}">
            <span class="absolute inset-y-1.5 left-0 w-1 rounded-r-full {{ request()->routeIs('pengasuh.*') ? 'bg-blue-400' : 'bg-transparent' }}"></span>
            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
            <span class="nav-text">Data Pengasuh</span>
        </a>

        <a href="{{ route('donatur.index') }}" data-tooltip="Data Donatur" class="nav-item relative mb-1 flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-semibold text-white/70 transition hover:bg-white/5 hover:text-white {{ request()->routeIs('donatur.*') ? 'bg-blue-500/20 text-blue-200' : '' }}">
            <span class="absolute inset-y-1.5 left-0 w-1 rounded-r-full {{ request()->routeIs('donatur.*') ? 'bg-blue-400' : 'bg-transparent' }}"></span>
            <svg class="h-5 w-5 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><polyline points="16 11 18 13 22 9"/>
            </svg>
            <span class="nav-text">Data Donatur</span>
        </a>

        <a href="{{ route('donasi.index') }}" data-tooltip="Data Donasi" class="nav-item relative mb-1 flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-semibold text-white/70 transition hover:bg-white/5 hover:text-white {{ request()->routeIs('donasi.*') ? 'bg-blue-500/20 text-blue-200' : '' }}">
            <span class="absolute inset-y-1.5 left-0 w-1 rounded-r-full {{ request()->routeIs('donasi.*') ? 'bg-blue-400' : 'bg-transparent' }}"></span>
            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            <span class="nav-text">Data Donasi</span>
        </a>

        <a href="{{ route('kegiatan.index') }}" data-tooltip="Data Kegiatan" class="nav-item relative mb-1 flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-semibold text-white/70 transition hover:bg-white/5 hover:text-white {{ request()->routeIs('kegiatan.*') ? 'bg-blue-500/20 text-blue-200' : '' }}">
            <span class="absolute inset-y-1.5 left-0 w-1 rounded-r-full {{ request()->routeIs('kegiatan.*') ? 'bg-blue-400' : 'bg-transparent' }}"></span>
            <svg class="h-5 w-5 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/>
            </svg>
            <span class="nav-text">Data Kegiatan</span>
        </a>

        <a href="{{ route('galeri.index') }}" data-tooltip="Galeri Foto" class="nav-item relative mb-1 flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-semibold text-white/70 transition hover:bg-white/5 hover:text-white {{ request()->routeIs('galeri.*') ? 'bg-blue-500/20 text-blue-200' : '' }}">
            <span class="absolute inset-y-1.5 left-0 w-1 rounded-r-full {{ request()->routeIs('galeri.*') ? 'bg-blue-400' : 'bg-transparent' }}"></span>
            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <span class="nav-text">Data Galeri</span>
        </a>
    </nav>
</aside>
