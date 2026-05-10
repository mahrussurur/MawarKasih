<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panti Asuhan Mawar Kasih')</title>
    <meta name="description" content="@yield('meta_description', 'Panti Asuhan Mawar Kasih - Menebar Kasih, Merangkai Harapan')">

    {{-- Tailwind CSS via CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50:  '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        },
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        display: ['Playfair Display', 'serif'],
                    },
                }
            }
        }
    </script>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

    {{-- Font Awesome untuk ikon --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* Smooth scroll global */
        html { scroll-behavior: smooth; }

        /* Animasi fade-up saat halaman load */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-up { animation: fadeUp .6s ease both; }
        .delay-100 { animation-delay: .1s; }
        .delay-200 { animation-delay: .2s; }
        .delay-300 { animation-delay: .3s; }

        /* Garis bawah aktif di navbar */
        .nav-link-active { border-bottom: 2px solid #2563eb; color: #2563eb; }
    </style>

    @stack('styles')
</head>
<body class="font-sans text-gray-800 bg-white antialiased">

    {{-- =====================================================================
         NAVBAR
         File : resources/views/public/layouts/navbar.blade.php
         ===================================================================== --}}
    @include('public.layouts.navbar')

    {{-- =====================================================================
         KONTEN UTAMA — diisi oleh masing-masing halaman
         ===================================================================== --}}
    <main>
        @yield('content')
    </main>

    {{-- =====================================================================
         FOOTER
         File : resources/views/public/layouts/footer.blade.php
         ===================================================================== --}}
    @include('public.layouts.footer')

    {{-- Script global: toggle mobile menu --}}
    <script>
        // Toggle mobile menu
        const btn  = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        if (btn && menu) {
            btn.addEventListener('click', () => menu.classList.toggle('hidden'));
        }

        // Highlight nav link aktif berdasarkan URL
        document.querySelectorAll('.nav-link').forEach(link => {
            if (link.href === window.location.href) {
                link.classList.add('nav-link-active');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>