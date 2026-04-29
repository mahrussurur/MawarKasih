{{--
    PARTIAL: partials/header.blade.php
--}}
<style>
    .header-inner {
        height: 64px;
        display: flex; align-items: center; justify-content: space-between;
        padding: 0 32px;
    }
    .header-left { display: flex; align-items: center; gap: 14px; }

    /* Hamburger mobile */
    .btn-hamburger {
        display: none; padding: 6px; border-radius: 8px; border: none;
        background: transparent; cursor: pointer; color: #64748b;
    }
    .btn-hamburger:hover { background: #f1f5f9; }
    .btn-hamburger svg { width: 22px; height: 22px; }
    @media (max-width: 768px) { .btn-hamburger { display: flex; } }

    /* Judul halaman */
    .header-page-title { font-size: 22px; font-weight: 800; color: #0f172a; }

    /* Profil */
    .header-profile { position: relative; }
    .profile-btn {
        display: flex; align-items: center; gap: 10px;
        padding: 6px 12px 6px 6px;
        border-radius: 40px; border: none; background: transparent;
        cursor: pointer; transition: background 0.15s;
    }
    .profile-btn:hover { background: #f1f5f9; }
    .profile-avatar {
        width: 38px; height: 38px; border-radius: 50%;
        overflow: hidden; background: #bfdbfe;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .profile-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .profile-name { font-size: 14px; font-weight: 700; color: #0f172a; }
    .profile-chevron { color: #64748b; }
    .profile-chevron svg { width: 16px; height: 16px; }

    /* Dropdown */
    .profile-dropdown {
        position: absolute; right: 0; top: calc(100% + 8px);
        width: 200px; background: #fff;
        border: 1px solid #e2e8f0; border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.12);
        padding: 6px; z-index: 200;
    }
    .dropdown-header {
        padding: 10px 12px 8px;
        border-bottom: 1px solid #f1f5f9; margin-bottom: 4px;
    }
    .dropdown-header .d-name { font-size: 13px; font-weight: 700; color: #0f172a; }
    .dropdown-header .d-role { font-size: 11px; color: #94a3b8; font-weight: 500; }
    .dropdown-item {
        display: flex; align-items: center; gap: 10px;
        padding: 9px 12px; border-radius: 8px;
        color: #475569; font-size: 13px; font-weight: 600;
        text-decoration: none; cursor: pointer; border: none;
        background: transparent; width: 100%; transition: background 0.14s;
    }
    .dropdown-item:hover { background: #f8fafc; color: #0f172a; }
    .dropdown-item.danger { color: #ef4444; }
    .dropdown-item.danger:hover { background: #fef2f2; }
    .dropdown-item svg { width: 16px; height: 16px; }
    .dropdown-divider { height: 1px; background: #f1f5f9; margin: 4px 0; }
</style>

<header class="main-header">
    <div class="header-inner">

        {{-- Kiri: Hamburger + Judul --}}
        <div class="header-left">
            {{-- Tombol hamburger (mobile only) --}}
            <button class="btn-hamburger" onclick="openSidebar()" aria-label="Buka menu">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            {{-- Judul halaman dinamis --}}
            <h1 class="header-page-title">@yield('page-title', 'Dashboard')</h1>
        </div>

        {{-- Kanan: Profil Admin --}}
        <div class="header-profile">
            <button id="profileBtn" class="profile-btn" onclick="toggleDropdown()" aria-label="Menu profil">
                {{-- Avatar --}}
                <div class="profile-avatar">
                    <img src="/images/avatar-admin.png" alt="Avatar"
                         onerror="this.style.display='none';this.parentElement.innerHTML='<svg xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 24 24\' stroke=\'#3b82f6\' style=\'width:24px;height:24px;\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z\'/></svg>'">
                </div>
                <span class="profile-name">{{ Auth::user()->name }}</span>
                <span class="profile-chevron">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </span>
            </button>

            {{-- Dropdown Menu --}}
            <div id="profileDropdown" class="profile-dropdown hidden">
                <div class="dropdown-header">
                    <div class="d-name">{{ Auth::user()->name }}</div>
                    <div class="d-role">Administrator</div>
                </div>

                <!-- <a href="#" class="dropdown-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Profil Saya
                </a>
                <a href="#" class="dropdown-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Pengaturan
                </a> -->

                <!-- <div class="dropdown-divider"></div> -->

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item danger">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>

    </div>
</header>