<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — Panti Asuhan Mawar Kasih</title>

    {{-- Tailwind CSS via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ── Google Font ── */
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
            box-sizing: border-box;
        }

        /* ── Background foto penuh layar ── */
        .bg-photo {
            background-image: url('/images/bg-login.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        /* ── Glassmorphism card ── */
        .glass-card {
            background: rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* ── Divider vertikal di tengah card ── */
        .glass-divider {
            border-left: 1px solid rgba(255, 255, 255, 0.35);
        }

        /* ── Input field transparan ── */
        .glass-input {
            background: rgba(255, 255, 255, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.4);
            color: #1e293b;
            transition: all 0.2s ease;
        }

        .glass-input::placeholder {
            color: rgba(30, 41, 59, 0.55);
        }

        .glass-input:focus {
            background: rgba(255, 255, 255, 0.4);
            border-color: rgba(59, 130, 246, 0.7);
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }

        /* ── Tombol login ── */
        .btn-login {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            transition: all 0.2s ease;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* ── Animasi masuk ── */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fadeInUp 0.5s ease both;
        }

        .animate-fade-in-delay {
            animation: fadeInUp 0.5s ease 0.15s both;
        }
    </style>
</head>

<body class="min-h-screen bg-photo flex flex-col items-center justify-center px-4 py-8 relative">

    {{-- Overlay gelap tipis agar teks lebih terbaca --}}
    <div class="absolute inset-0 bg-black/20"></div>

    {{-- ═══════════════════════════════════════════════
         CARD UTAMA
    ═══════════════════════════════════════════════ --}}
    <div class="relative z-10 w-full max-w-3xl glass-card rounded-2xl shadow-2xl overflow-hidden animate-fade-in">
        <div class="flex flex-col md:flex-row min-h-[440px]">

            {{-- ── PANEL KIRI: Logo & Tagline ── --}}
            <div class="md:w-5/12 flex flex-col items-center justify-center px-8 py-10 text-center">

                {{-- Logo — ganti src dengan path logo kamu --}}
                <div class="mb-5">
                    <img
                        src="/images/logo.png"
                        alt="Logo Panti Asuhan Mawar Kasih"
                        class="w-24 h-24 object-contain mx-auto drop-shadow-lg"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                    >
                </div>

                {{-- Nama Panti --}}
                <h2 class="text-2xl font-extrabold text-black leading-tight drop-shadow-md">
                    Panti Asuhan<br>Mawar Kasih
                </h2>

                {{-- Tagline --}}
                <p class="mt-4 text-sm text-white leading-relaxed font-medium">
                    Cinta, Kepedulian,<br>
                    dan Harapan untuk<br>
                    masa depan<br>
                    yang lebih baik
                </p>
            </div>

            {{-- ── DIVIDER VERTIKAL ── --}}
            <div class="hidden md:block glass-divider"></div>

            {{-- ── PANEL KANAN: Form Login ── --}}
            <div class="md:w-7/12 px-8 py-10 animate-fade-in-delay">

                {{-- Judul --}}
                <h1 class="text-2xl font-extrabold text-black leading-tight drop-shadow-md">Login Admin</h1>
                <p class="mt-4 text-sm text-white leading-relaxed font-medium">
                    Silahkan masuk untuk mengakses<br>sistem pengelolaan data.
                </p>

                {{-- ── Alert Error ── --}}
                @if ($errors->any())
                    <div class="mb-5 px-4 py-3 rounded-lg bg-red-100/70 border border-red-300 text-red-700 text-sm">
                        {{ $errors->first() }}
                    </div>
                @endif

                {{-- ── FORM ── --}}
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                {{-- Username --}}
                <div>
                    <label for="username" class="block mb-2 text-sm font-semibold text-white/90">
                        Username
                    </label>
                    <div class="relative group">
                        <input
                            id="username"
                            type="text"
                            name="username"
                            value="{{ old('username') }}"
                            placeholder="Masukkan username"
                            autofocus
                            autocomplete="username"
                            class="w-full px-4 py-3 rounded-xl text-sm font-medium text-white bg-white/10 border border-white/20 placeholder:text-white/40 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:bg-white/20 transition-all duration-300"
                        >
                    </div>
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block mb-2 text-sm font-semibold text-white/90">
                        Password
                    </label>
                    <div class="relative group">
                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="Masukkan password"
                            autocomplete="current-password"
                            class="w-full px-4 py-3 pr-12 rounded-xl text-sm font-medium text-white bg-white/10 border border-white/20 placeholder:text-white/40 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:bg-white/20 transition-all duration-300"
                        >

                        {{-- Toggle show/hide password dengan kontras tinggi --}}
                        <button
                            type="button"
                            onclick="togglePassword()"
                            class="absolute right-3 top-1/2 -translate-y-1/2 p-1.5 rounded-lg text-white/60 hover:text-white hover:bg-white/10 active:scale-95 transition-all"
                            aria-label="Tampilkan password"
                        >
                            <svg id="icon-eye" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg id="icon-eye-off" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                      d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.477 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                </div>

    {{-- Remember Me & Lupa Password --}}
    <div class="flex items-center justify-between pt-1">
        <label class="flex items-center group cursor-pointer">
            <div class="relative flex items-center">
                <input
                    type="checkbox"
                    name="remember"
                    class="peer appearance-none w-4 h-4 rounded border border-white/30 checked:bg-blue-600 checked:border-transparent transition-all cursor-pointer"
                >
                <svg class="absolute w-3 h-3 text-white opacity-0 peer-checked:opacity-100 pointer-events-none ml-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4">
                    <path d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <span class="ml-2 text-sm text-white/80 group-hover:text-white transition-colors">Ingat saya</span>
        </label>

        <a href="{{ route('password.request') }}"
            class="text-sm font-semibold text-blue-400 hover:text-blue-300 hover:underline transition-all">
            Lupa password?
        </a>
    </div>

    {{-- Tombol Login --}}
    <button
        type="submit"
        class="w-full py-3.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-sm tracking-wide shadow-[0_0_15px_rgba(37,99,235,0.4)] hover:shadow-[0_0_20px_rgba(37,99,235,0.6)] active:scale-[0.98] transition-all duration-200"
    >
        LOGIN
    </button>
</form>
            </div>
        </div>
    </div>

    {{--FOOTER--}}
    <p class="relative z-10 mt-6 text-xs text-white/80 font-medium text-center drop-shadow">
        &copy; {{ date('Y') }} Yayasan Mawar Kasih. Semua hak dilindungi.
    </p>

    {{-- Script: toggle show/hide password --}}
    <script>
        function togglePassword() {
            const input   = document.getElementById('password');
            const iconOn  = document.getElementById('icon-eye');
            const iconOff = document.getElementById('icon-eye-off');

            if (input.type === 'password') {
                input.type = 'text';
                iconOn.classList.add('hidden');
                iconOff.classList.remove('hidden');
            } else {
                input.type = 'password';
                iconOn.classList.remove('hidden');
                iconOff.classList.add('hidden');
            }
        }
    </script>

</body>
</html>