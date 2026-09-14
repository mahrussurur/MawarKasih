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

        <!-- Script Pencegah Flash Of Unstyled Content (FOUC) saat Reload -->
        <script>
            (function() {
                if (window.innerWidth > 768 && localStorage.getItem('sidebar-collapsed') === 'true') {
                    document.documentElement.classList.add('sidebar-collapsed');
                }
            })();
        </script>

        <style>
            :root {
                --sidebar-width: 230px;
                --sidebar-collapsed-width: 80px;
            }

            html, body { overflow-x: hidden; }
            html { font-family: 'Plus Jakarta Sans', sans-serif; }

            /* --- DESKTOP LAYOUT --- */
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

            /* State Collapsed (Desktop) */
            .sidebar-collapsed .sidebar {
                width: var(--sidebar-collapsed-width);
            }

            .sidebar-collapsed .main-content {
                margin-left: var(--sidebar-collapsed-width);
            }

            /* Sembunyikan Elemen Teks saat Collapsed */
            .sidebar-collapsed .sidebar .sidebar-brand-info,
            .sidebar-collapsed .sidebar .sidebar-brand-text,
            .sidebar-collapsed .sidebar .nav-label {
                display: none !important;
            }

            .sidebar-collapsed .sidebar .sidebar-brand {
                justify-content: center;
                padding-left: 0;
                padding-right: 0;
                padding-top: 14px;    
                padding-bottom: 14px; 
            }

            .sidebar-collapsed .sidebar .nav-text {
                width: 0;
                opacity: 0;
                overflow: hidden;
                white-space: nowrap;
                display: inline-block;
            }

            .sidebar-collapsed .sidebar .nav-item {
                justify-content: center;
                padding-left: 0;
                padding-right: 0;
                gap: 0;
            }

            /* Tooltip Hover pada Desktop Collapsed */
            .sidebar-collapsed .sidebar .nav-item::after {
                content: attr(data-tooltip);
                position: absolute;
                left: calc(var(--sidebar-collapsed-width) - 4px);
                top: 50%;
                transform: translateY(-50%);
                background: rgba(15, 23, 42, 0.95);
                color: #fff;
                padding: 6px 12px;
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

            /* --- MOBILE LAYOUT (RESPONSIF <= 768px) --- */
            @media (max-width: 768px) {
                /* Mencegah sidebar gepeng saat dibuka di HP */
                .sidebar, 
                .sidebar-collapsed .sidebar {
                    width: var(--sidebar-width) !important;
                    transform: translateX(-100%);
                }

                .sidebar.open {
                    transform: translateX(0) !important;
                }

                /* Reset margin di HP */
                .main-content,
                .sidebar-collapsed .main-content {
                    margin-left: 0 !important;
                }

                /* Tampilkan kembali teks jika dibuka di HP */
                .sidebar-collapsed .sidebar .sidebar-brand-info,
                .sidebar-collapsed .sidebar .sidebar-brand-text,
                .sidebar-collapsed .sidebar .nav-label {
                    display: flex !important;
                }

                .sidebar-collapsed .sidebar .nav-text {
                    width: auto !important;
                    opacity: 1 !important;
                }

                .sidebar-collapsed .sidebar .nav-item {
                    justify-content: flex-start !important;
                    padding-left: 0.875rem !important;
                    padding-right: 0.875rem !important;
                    gap: 0.75rem !important;
                }

                /* Matikan tooltip di perangkat layar sentuh/mobile */
                .sidebar-collapsed .sidebar .nav-item::after {
                    display: none !important;
                }
            }
        </style>

        @stack('styles')
    </head>
    <body class="bg-gray-100 text-gray-900 antialiased">
        <div class="flex h-screen overflow-hidden">
            @if(Auth::check())
                @include('components.sidebar.main')
            @endif

            <div class="fixed inset-0 z-40 hidden bg-gray-900/50 backdrop-blur-sm transition-opacity" id="sidebarOverlay" onclick="closeSidebar()"></div>

            <div class="main-content flex h-screen flex-1 flex-col overflow-hidden relative">
                @include('layouts.partials.admin.header')

                <main class="page-content min-h-0 flex-1 overflow-y-auto overflow-x-hidden p-4 sm:p-6 lg:p-8">@yield('content')
                </main>

                <!-- Modal Container: menutupi area konten di bawah header saja -->
                <div id="adminModalContainer" class="pointer-events-none absolute inset-0 top-16 z-50">
                    @include('layouts.partials.admin.modals')
                    @include('layouts.partials.admin.image_preview_modal')
                    @stack('modals')
                </div>
            </div><!-- /.main-content -->
        </div><!-- /.flex.h-screen -->

        <script>
            function openSidebar() {
                const sidebar = document.querySelector('.sidebar');
                const overlay = document.getElementById('sidebarOverlay');
                if (sidebar && overlay) {
                    sidebar.classList.add('open');
                    overlay.classList.remove('hidden');
                }
            }

            function closeSidebar() {
                const sidebar = document.querySelector('.sidebar');
                const overlay = document.getElementById('sidebarOverlay');
                if (sidebar && overlay) {
                    sidebar.classList.remove('open');
                    overlay.classList.add('hidden');
                }
            }

            function toggleSidebar() {
                if (window.innerWidth > 768) {
                    const html = document.documentElement;
                    const isCollapsed = html.classList.toggle('sidebar-collapsed');
                    localStorage.setItem('sidebar-collapsed', isCollapsed);
                } else {
                    const sidebar = document.querySelector('.sidebar');
                    if (sidebar.classList.contains('open')) {
                        closeSidebar();
                    } else {
                        openSidebar();
                    }
                }
            }
        </script>

        @stack('scripts')
        <x-toast />
    </body>
</html>
