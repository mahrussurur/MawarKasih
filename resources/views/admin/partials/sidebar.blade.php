<style>
    .sidebar-brand {
        padding: 9.5px 14px;
        border-bottom: 1px solid rgba(255,255,255,0.08);
        display: flex; align-items: center; gap: 12px;
        transition: padding var(--collapse-transition), justify-content var(--collapse-transition);
    }
    .sidebar-brand-logo {
        width: 44px; height: 44px; border-radius: 10px;
        overflow: hidden; background: transparent;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .sidebar-brand-logo img {
        width: 100%; height: 100%; object-fit: contain; display: block;
        background: transparent;
    }
    .sidebar-brand-text {
        transition: opacity 0.2s ease, width 0.2s ease;
        white-space: nowrap; overflow: hidden;
    }
    .sidebar-brand-text .org { font-size: 10px; font-weight: 700; color: rgba(255,255,255,0.45); letter-spacing: 0.06em; text-transform: uppercase; }
    .sidebar-brand-text .name { font-size: 15px; font-weight: 700; color: #fff; line-height: 1.2; margin-top: 1px; }

    .sidebar-nav { flex: 1; padding: 14px 14px; overflow-y: auto; }
    .sidebar-nav::-webkit-scrollbar { display: none; }

    .nav-label {
        font-size: 10px; font-weight: 700; color: rgba(255,255,255,0.28);
        letter-spacing: 0.1em; text-transform: uppercase; padding: 8px 10px 4px;
        transition: opacity 0.2s ease;
        white-space: nowrap; overflow: hidden;
    }

    .nav-item {
        display: flex; align-items: center; gap: 12px;
        padding: 11px 14px; border-radius: 10px;
        color: rgba(255,255,255,0.6); font-size: 14px; font-weight: 600;
        text-decoration: none; margin-bottom: 3px;
        transition: all 0.18s ease, padding var(--collapse-transition), justify-content var(--collapse-transition);
        position: relative;
    }
    .nav-item:hover { background: rgba(255,255,255,0.07); color: #fff; }
    .nav-item.active { background: rgba(59,130,246,0.18); color: #60a5fa; }
    .nav-item.active::before {
        content: ''; position: absolute; left: 0; top: 22%; bottom: 22%;
        width: 3px; border-radius: 0 3px 3px 0; background: #3b82f6;
    }
    .nav-item svg { width: 20px; height: 20px; flex-shrink: 0; }

    .nav-text {
        transition: opacity 0.2s ease, width 0.2s ease;
        white-space: nowrap; overflow: hidden;
    }

    .sidebar-footer { padding: 16px 12px; border-top: 1px solid rgba(255,255,255,0.08); }
    .btn-logout {
        display: flex; align-items: center; gap: 12px; width: 100%;
        padding: 11px 14px; border-radius: 10px;
        background: rgba(239,68,68,0.12); border: 1px solid rgba(239,68,68,0.2);
        color: #f87171; font-size: 14px; font-weight: 700;
        cursor: pointer; transition: all 0.18s ease;
    }
    .btn-logout:hover { background: rgba(239,68,68,0.22); color: #fca5a5; }
    .btn-logout svg { width: 20px; height: 20px; }
</style>

<aside class="sidebar">
    <!-- Brand -->
    <div class="sidebar-brand">
        <div class="sidebar-brand-logo">
            <img src="/images/logo2.png" alt="Logo MTK"
                onerror="this.style.display='none';this.parentElement.innerHTML='<span style=\'color:rgba(255,255,255,0.7);font-size:11px;font-weight:800;\'>MTK</span>'">
        </div>
        <div class="sidebar-brand-text">
            <div class="org">Yayasan</div>
            <div class="name">Mawar Kasih</div>
        </div>
    </div>

    <!-- Nav -->
    <nav class="sidebar-nav" >
        <div class="nav-label">Menu Utama</div>

        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" data-tooltip="Dashboard">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            <span class="nav-text">Dashboard</span>
        </a>

        <div class="nav-label" style="margin-top:8px;">Data</div>

        <a href="{{ route('anak-asuh.index') }}" class="nav-item {{ request()->routeIs('anak-asuh.*') ? 'active' : '' }}" data-tooltip="Data Anak Asuh">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            <span class="nav-text">Data Anak Asuh</span>
        </a>

        <a href="{{ route('pengasuh.index') }}" class="nav-item {{ request()->routeIs('pengasuh.*') ? 'active' : '' }}" data-tooltip="Data Pengasuh">
            <svg fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
            <span class="nav-text">Data Pengasuh</span>
        </a>

        <a href="{{ route('donatur.index') }}" class="nav-item {{ request()->routeIs('donatur.*') ? 'active' : '' }}" data-tooltip="Data Donatur">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><polyline points="16 11 18 13 22 9"/>
            </svg>
            <span class="nav-text">Data Donatur</span>
        </a>

        <a href="{{ route('donasi.index') }}" class="nav-item {{ request()->routeIs('donasi.*') ? 'active' : '' }}" data-tooltip="Data Donasi">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            <span class="nav-text">Data Donasi</span>
        </a>

        <a href="{{ route('kegiatan.index') }}" class="nav-item {{ request()->routeIs('kegiatan.*') ? 'active' : '' }}" data-tooltip="Data Kegiatan">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/>
            </svg>
            <span class="nav-text">Data Kegiatan</span>
        </a>

        <a href="{{ route('galeri.index') }}" class="nav-item {{ request()->routeIs('galeri.*') ? 'active' : '' }}" data-tooltip="Galeri Foto">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <span class="nav-text">Data Galeri</span>
        </a>
    </nav>
</aside>