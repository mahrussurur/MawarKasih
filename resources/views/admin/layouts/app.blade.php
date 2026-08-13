<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') | Panti Asuhan Mawar Kasih</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo2.webp') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

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
        }

        html { font-family: 'Plus Jakarta Sans', sans-serif; }

        .sidebar {
            width: var(--sidebar-width);
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1), transform 0.3s ease;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            min-width: 0;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .page-content {
            animation: fadeInUp 0.35s ease both;
        }

        .sidebar-collapsed .sidebar {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar-collapsed .main-content {
            margin-left: var(--sidebar-collapsed-width);
        }

        .sidebar-collapsed .sidebar .sidebar-brand {
            justify-content: center;
            gap: 0;
            min-width: 0;
        }

        .sidebar-collapsed .sidebar .sidebar-brand-info {
            display: none;
        }

        .sidebar-collapsed .sidebar .sidebar-toggle {
            margin-left: 0;
        }

        .sidebar-collapsed .sidebar .sidebar-brand-text {
            display: none;
        }

        .sidebar-collapsed .sidebar .sidebar-brand-text > * {
            display: none;
        }

        .sidebar-collapsed .sidebar .nav-text {
            width: 0;
            opacity: 0;
            overflow: hidden;
            white-space: nowrap;
            display: inline-block;
        }

        .sidebar-collapsed .sidebar .nav-label {
            display: none;
        }

        .sidebar-collapsed .sidebar .nav-item {
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
            gap: 0;
        }

        .sidebar-collapsed .sidebar .nav-item::after {
            content: attr(data-tooltip);
            position: absolute;
            left: calc(var(--sidebar-collapsed-width) - 8px);
            top: 50%;
            transform: translateY(-50%);
            background: rgba(15, 23, 42, 0.95);
            color: #fff;
            padding: 6px 10px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
            z-index: 200;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.22);
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .sidebar-collapsed .sidebar .nav-item:hover::after {
            opacity: 1;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .sidebar-collapsed .main-content {
                margin-left: 0;
            }
        }
    </style>

    @stack('styles')
</head>
<body class="bg-slate-100 text-slate-900 antialiased">
<div class="flex min-h-screen">
    @include('admin.partials.sidebar')

    <div class="fixed inset-0 z-40 hidden bg-slate-900/50" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <div class="main-content flex min-h-screen flex-1 flex-col">
        @include('admin.partials.header')

        <main class="page-content">
            @yield('content')
        </main>
    </div>
</div>

<script>
    function openSidebar() {
        document.querySelector('.sidebar').classList.add('open');
        document.getElementById('sidebarOverlay').classList.remove('hidden');
    }

    function closeSidebar() {
        document.querySelector('.sidebar').classList.remove('open');
        document.getElementById('sidebarOverlay').classList.add('hidden');
    }

    function toggleSidebar() {
        const html = document.documentElement;
        const isCollapsed = html.classList.toggle('sidebar-collapsed');
        localStorage.setItem('sidebar-collapsed', isCollapsed);
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
<x-toast />
</body>
</html>
