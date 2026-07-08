<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') | Panti Asuhan Mawar Kasih</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo2.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Prevent layout flash: apply collapsed class before first paint --}}
    <script>
        (function() {
            if (window.innerWidth > 768 && localStorage.getItem('sidebar-collapsed') === 'true') {
                document.documentElement.classList.add('sidebar-collapsed');
            }
        })();
    </script>

    <style>
        :root {
            --sidebar-width: 250px;
            --sidebar-collapsed-width: 78px;
            --header-height: 64px;
            --sidebar-bg: #1E4FBC;
            --sidebar-hover: #2d3f54;
            --sidebar-active-bg: rgba(59,130,246,0.18);
            --accent-blue: #3b82f6;
            --bg-main: #f1f5f9;
            --card-bg: #ffffff;
            --border: #e2e8f0;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --collapse-transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        * { font-family: 'Plus Jakarta Sans', sans-serif; box-sizing: border-box; }
        body { background: var(--bg-main); color: var(--text-dark); margin: 0; overflow-x: hidden; }

        .layout-wrapper { display: flex; min-height: 100vh; }

        /* ── Sidebar ── */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            position: fixed;
            top: 0; left: 0; bottom: 0;
            display: flex; flex-direction: column;
            z-index: 100;
            transition: width var(--collapse-transition), transform 0.3s ease;
            overflow: hidden;
        }

        /* ── Main ── */
        .main-content {
            margin-left: var(--sidebar-width);
            flex: 1; display: flex; flex-direction: column; min-height: 100vh;
            min-width: 0;
            transition: margin-left var(--collapse-transition);
        }
        .main-header {
            height: var(--header-height);
            background: var(--card-bg);
            border-bottom: 1px solid var(--border);
            position: sticky; top: 0; z-index: 50;
        }
        .page-content { flex: 1; padding: 28px 32px; min-width: 0; }
        .page-content { animation: fadeInUp 0.35s ease both; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Collapsed State (Desktop only) ── */
        .sidebar-collapsed .sidebar {
            width: var(--sidebar-collapsed-width);
        }
        .sidebar-collapsed .main-content {
            margin-left: var(--sidebar-collapsed-width);
        }

        /* Hide text elements when collapsed */
        .sidebar-collapsed .sidebar .nav-text,
        .sidebar-collapsed .sidebar .sidebar-brand-text,
        .sidebar-collapsed .sidebar .nav-label {
            opacity: 0;
            width: 0;
            overflow: hidden;
            white-space: nowrap;
            transition: opacity 0.2s ease, width 0.2s ease;
        }

        /* Center icons and adjust padding when collapsed */
        .sidebar-collapsed .sidebar .nav-item {
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
        }
        .sidebar-collapsed .sidebar .nav-item svg {
            margin: 0 auto;
        }
        .sidebar-collapsed .sidebar .sidebar-brand {
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
        }
        .sidebar-collapsed .sidebar .sidebar-brand-logo {
            margin: 0 auto;
        }

        /* Tooltip on hover when collapsed */
        .sidebar-collapsed .sidebar .nav-item {
            position: relative;
        }
        .sidebar-collapsed .sidebar .nav-item:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            left: calc(var(--sidebar-collapsed-width) - 8px);
            top: 50%;
            transform: translateY(-50%);
            background: #1e293b;
            color: #fff;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
            z-index: 200;
            box-shadow: 0 4px 16px rgba(0,0,0,0.18);
            pointer-events: none;
        }

        /* Active indicator fix when collapsed */
        .sidebar-collapsed .sidebar .nav-item.active::before {
            left: 0;
        }

        /* ── Sidebar Overlay (Mobile) ── */
        .sidebar-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.5); z-index: 90;
        }

        /* ── Mobile Responsive ── */
        @media (max-width: 768px) {
            /* Disable collapse on mobile — always full sidebar as drawer */
            .sidebar-collapsed .sidebar { width: var(--sidebar-width); }
            .sidebar-collapsed .sidebar .nav-text,
            .sidebar-collapsed .sidebar .sidebar-brand-text,
            .sidebar-collapsed .sidebar .nav-label {
                opacity: 1; width: auto;
            }
            .sidebar-collapsed .sidebar .nav-item {
                justify-content: flex-start;
                padding-left: 14px; padding-right: 14px;
            }
            .sidebar-collapsed .sidebar .sidebar-brand {
                justify-content: flex-start;
                padding-left: 14px; padding-right: 14px;
            }
            .sidebar-collapsed .sidebar .nav-item:hover::after { display: none; }

            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .sidebar-overlay.show { display: block; }
            .main-content { margin-left: 0; }
            .sidebar-collapsed .main-content { margin-left: 0; }
            .page-content { padding: 20px 16px; }
        }
    </style>

    @stack('styles')
</head>
<body>
<div class="layout-wrapper">

    @include('admin.partials.sidebar')

    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <div class="main-content">
        @include('admin.partials.header')

        <main class="page-content">
            @yield('content')
        </main>
    </div>
</div>

<script>
    // ── Mobile Sidebar ──
    function openSidebar() {
        document.querySelector('.sidebar').classList.add('open');
        document.getElementById('sidebarOverlay').classList.add('show');
    }
    function closeSidebar() {
        document.querySelector('.sidebar').classList.remove('open');
        document.getElementById('sidebarOverlay').classList.remove('show');
    }

    // ── Collapsible Sidebar (Desktop) ──
    function toggleSidebar() {
        const html = document.documentElement;
        const isCollapsed = html.classList.toggle('sidebar-collapsed');
        localStorage.setItem('sidebar-collapsed', isCollapsed);
    }

    // ── Profile Dropdown ──
    function toggleDropdown() {
        document.getElementById('profileDropdown').classList.toggle('hidden');
    }
    document.addEventListener('click', function(e) {
        const btn  = document.getElementById('profileBtn');
        const menu = document.getElementById('profileDropdown');
        if (menu && btn && !btn.contains(e.target) && !menu.contains(e.target)) {
            menu.classList.add('hidden');
        }
    });
</script>

@stack('scripts')
</body>
</html>