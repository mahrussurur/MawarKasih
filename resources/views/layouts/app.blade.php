<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — Panti Asuhan Mawar Kasih</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --sidebar-width: 260px;
            --header-height: 64px;
            --sidebar-bg: #1e2a3a;
            --sidebar-hover: #2d3f54;
            --sidebar-active-bg: rgba(59,130,246,0.18);
            --accent-blue: #3b82f6;
            --bg-main: #f1f5f9;
            --card-bg: #ffffff;
            --border: #e2e8f0;
            --text-dark: #0f172a;
            --text-muted: #64748b;
        }
        * { font-family: 'Plus Jakarta Sans', sans-serif; box-sizing: border-box; }
        body { background: var(--bg-main); color: var(--text-dark); margin: 0; overflow-x: hidden; }

        .layout-wrapper { display: flex; min-height: 100vh; }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            position: fixed;
            top: 0; left: 0; bottom: 0;
            display: flex; flex-direction: column;
            z-index: 100;
            transition: transform 0.3s ease;
        }

        /* Main */
        .main-content {
            margin-left: var(--sidebar-width);
            flex: 1; display: flex; flex-direction: column; min-height: 100vh;
        }
        .main-header {
            height: var(--header-height);
            background: var(--card-bg);
            border-bottom: 1px solid var(--border);
            position: sticky; top: 0; z-index: 50;
        }
        .page-content { flex: 1; padding: 28px 32px; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .page-content { animation: fadeInUp 0.35s ease both; }

        /* Mobile */
        .sidebar-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.5); z-index: 90;
        }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .sidebar-overlay.show { display: block; }
            .main-content { margin-left: 0; }
            .page-content { padding: 20px 16px; }
        }
    </style>

    @stack('styles')
</head>
<body>
<div class="layout-wrapper">

    @include('partials.sidebar')

    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <div class="main-content">
        @include('partials.header')

        <main class="page-content">
            @yield('content')
        </main>
    </div>
</div>

<script>
    function openSidebar() {
        document.querySelector('.sidebar').classList.add('open');
        document.getElementById('sidebarOverlay').classList.add('show');
    }
    function closeSidebar() {
        document.querySelector('.sidebar').classList.remove('open');
        document.getElementById('sidebarOverlay').classList.remove('show');
    }
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