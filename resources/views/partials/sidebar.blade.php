{{--
    PARTIAL: partials/sidebar.blade.php
    Taruh di: resources/views/partials/sidebar.blade.php
--}}
<style>
    .sidebar-brand {
        padding: 18px 20px;
        border-bottom: 1px solid rgba(255,255,255,0.08);
        display: flex; align-items: center; gap: 12px;
        text-decoration: none;
    }
    .sidebar-brand-logo {
        width: 44px; height: 44px; border-radius: 10px;
        overflow: hidden; background: rgba(255,255,255,0.1);
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .sidebar-brand-logo img { width: 100%; height: 100%; object-fit: contain; }
    .sidebar-brand-text .org { font-size: 10px; font-weight: 700; color: rgba(255,255,255,0.45); letter-spacing: 0.06em; text-transform: uppercase; }
    .sidebar-brand-text .name { font-size: 15px; font-weight: 800; color: #fff; line-height: 1.2; margin-top: 1px; }

    .sidebar-nav { flex: 1; padding: 14px 12px; overflow-y: auto; }
    .sidebar-nav::-webkit-scrollbar { display: none; }

    .nav-label { font-size: 10px; font-weight: 700; color: rgba(255,255,255,0.28); letter-spacing: 0.1em; text-transform: uppercase; padding: 8px 10px 4px; }

    .nav-item {
        display: flex; align-items: center; gap: 12px;
        padding: 11px 14px; border-radius: 10px;
        color: rgba(255,255,255,0.6); font-size: 14px; font-weight: 600;
        text-decoration: none; margin-bottom: 3px;
        transition: all 0.18s ease; position: relative;
    }
    .nav-item:hover { background: rgba(255,255,255,0.07); color: #fff; }
    .nav-item.active { background: rgba(59,130,246,0.18); color: #60a5fa; }
    .nav-item.active::before {
        content: ''; position: absolute; left: 0; top: 22%; bottom: 22%;
        width: 3px; border-radius: 0 3px 3px 0; background: #3b82f6;
    }
    .nav-item svg { width: 20px; height: 20px; flex-shrink: 0; }

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
    {{-- Brand --}}
    <a href="{{ route('dashboard') }}" class="sidebar-brand">
        <div class="sidebar-brand-logo">
            <img src="/images/logo.png" alt="Logo MTK"
                 onerror="this.style.display='none';this.parentElement.innerHTML='<span style=\'color:rgba(255,255,255,0.7);font-size:11px;font-weight:800;\'>MTK</span>'">
        </div>
        <div class="sidebar-brand-text">
            <div class="org">Yayasan</div>
            <div class="name">Mawar Kasih</div>
        </div>
    </a>

    {{-- Nav --}}
    <nav class="sidebar-nav">
        <div class="nav-label">Menu Utama</div>

        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard
        </a>

        <div class="nav-label" style="margin-top:8px;">Data</div>

        <a href="{{ route('anak-asuh.index') }}" class="nav-item {{ request()->routeIs('anak-asuh.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Data Anak Asuh
        </a>

        <a href="{{ route('pengasuh.index') }}" class="nav-item {{ request()->routeIs('pengasuh.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            Data Pengasuh
        </a>

        <a href="{{ route('donasi.index') }}" class="nav-item {{ request()->routeIs('donasi.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            Data Donasi
        </a>

        <a href="{{ route('kegiatan.index') }}" class="nav-item {{ request()->routeIs('kegiatan.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Data Kegiatan
        </a>

        <a href="{{ route('galeri.index') }}" class="nav-item {{ request()->routeIs('galeri.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Galeri Foto
        </a>
    </nav>
</aside>