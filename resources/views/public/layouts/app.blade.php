<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- ======================================================
         SEO META TAGS
         Ubah default di sini jika perlu.
    ====================================================== --}}
    <title>@yield('title', 'Beranda') | Panti Asuhan Mawar Kasih</title>
    <meta name="description" content="@yield('meta_desc', 'Panti Asuhan Mawar Kasih - Bersama kita hadirkan cinta, pendidikan, dan masa depan yang lebih baik untuk mereka.')">
    <meta name="keywords" content="panti asuhan, mawar kasih, bandung, donasi, anak yatim">

    {{-- Open Graph (untuk share sosial media) --}}
    <meta property="og:title" content="@yield('title', 'Beranda') | Panti Asuhan Mawar Kasih">
    <meta property="og:description" content="@yield('meta_desc', 'Bersama kita hadirkan cinta, pendidikan, dan masa depan yang lebih baik.')">
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">
    <meta property="og:url" content="{{ url()->current() }}">

    {{-- ======================================================
         FAVICON
         Ganti path sesuai file favicon Anda di public/images/
    ====================================================== --}}
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    {{-- ======================================================
         FONTS - Plus Jakarta Sans
         Digunakan sebagai font utama seluruh website.
         Ganti di sini jika ingin mengganti font global.
    ====================================================== --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- ======================================================
         TAILWIND CSS
         Jika sudah pakai Vite/Mix, hapus CDN ini dan
         ganti dengan: @vite(['resources/css/app.css'])
    ====================================================== --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // ======================================================
        // TAILWIND CONFIG - Warna & Font Kustom
        // Ubah warna brand di sini jika perlu.
        // ======================================================
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50:  '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb', // Warna utama biru
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        },
                    }
                }
            }
        }
    </script>

    {{-- ======================================================
         AOS - Animate On Scroll
         Library animasi saat elemen muncul di viewport.
         Hapus jika tidak ingin animasi scroll.
    ====================================================== --}}
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">

    {{-- Lucide Icons CDN --}}
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    {{-- ======================================================
         GLOBAL STYLES
         CSS global yang berlaku di seluruh website.
    ====================================================== --}}
    <style>
        /* Scrollbar kustom */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #3e3e3e; border-radius: 1px; }

        /* Smooth scroll untuk anchor link */
        html { scroll-behavior: smooth; }

        /* Transisi halaman */
        body { opacity: 0; transition: opacity 0.3s ease; }
        body.loaded { opacity: 1; }

        /* Utility: line clamp (untuk judul/deskripsi yang panjang) */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

    {{-- Section untuk CSS tambahan per halaman --}}
    @yield('extra_styles')
</head>
<body class="font-sans bg-white text-gray-800 antialiased">

    {{-- ======================================================
         NAVBAR - Include komponen navbar
         File: resources/views/public/components/navbar.blade.php
    ====================================================== --}}
    @include('public.components.navbar')

    {{-- ======================================================
         KONTEN UTAMA HALAMAN
         Diisi oleh masing-masing halaman child.
    ====================================================== --}}
    <main>
        @yield('content')
    </main>

    {{-- ======================================================
         FOOTER - Include komponen footer
         File: resources/views/public/components/footer.blade.php
    ====================================================== --}}
    @include('public.components.footer')

    {{-- ======================================================
         SCROLL TO TOP BUTTON
         Muncul otomatis saat scroll ke bawah.
    ====================================================== --}}
    <button id="scrollTopBtn"
        class="fixed bottom-6 right-6 z-50 w-11 h-11 bg-brand-600 text-white rounded-full border-2 border-gray-900 shadow-lg flex items-center justify-center opacity-0 invisible transition-all duration-300 hover:bg-brand-700"
        onclick="window.scrollTo({top:0,behavior:'smooth'})"
        aria-label="Kembali ke atas">
        <i data-lucide="chevron-up" class="w-5 h-5"></i>
    </button>

    {{-- ======================================================
         SCRIPTS GLOBAL
    ====================================================== --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Inisialisasi AOS (animasi scroll)
        AOS.init({
            duration: 700,      // durasi animasi (ms)
            easing: 'ease-out-cubic',
            once: true,         // animasi hanya sekali
            offset: 60,
        });

        // Inisialisasi Lucide Icons
        lucide.createIcons();

        // Tampilkan body setelah load
        document.body.classList.add('loaded');

        // Scroll to top button
        window.addEventListener('scroll', () => {
            const btn = document.getElementById('scrollTopBtn');
            if (window.scrollY > 400) {
                btn.classList.remove('opacity-0', 'invisible');
                btn.classList.add('opacity-100', 'visible');
            } else {
                btn.classList.add('opacity-0', 'invisible');
                btn.classList.remove('opacity-100', 'visible');
            }
        });

        // Navbar scroll effect (handled in navbar component)
    </script>

    {{-- Section untuk JS tambahan per halaman --}}
    @yield('extra_scripts')

</body>
</html>