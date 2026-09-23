<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Panti Asuhan Mawar Kasih</title>

    <!-- Google Font Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen font-['Plus_Jakarta_Sans',sans-serif] flex flex-col items-center justify-center px-4 py-8 relative">

    <!-- Background gambar fixed (tidak ikut scroll) -->
    <div class="fixed inset-0 -z-10 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('images/bg-login.webp') }}')"></div>
    <div class="fixed inset-0 -z-10 bg-black/40"></div>

    <!-- Logo di atas card -->
    <div class="relative z-10 mb-4">
        <img
            src="/images/logo.webp"
            alt="Logo Panti Asuhan Mawar Kasih"
            class="w-20 h-20 object-contain mx-auto drop-shadow-lg"
            onerror="this.style.display='none';"
        >
    </div>

    <!-- Card -->
    <div class="relative z-10 w-full max-w-xl bg-white/[0.18] backdrop-blur-[18px] border border-white/25 rounded-2xl shadow-2xl overflow-hidden">
        <div class="px-8 py-8">

            <!-- Judul -->
            <h1 class="text-2xl font-extrabold text-white text-center tracking-wide mb-1">LOGIN</h1>
            <p class="text-sm text-white/75 text-center mb-6 leading-relaxed">
                Silahkan masuk untuk mengakses<br>sistem Mawar Kasih.
            </p>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Username -->
                <div>
                    <label for="username" class="block mb-1.5 text-sm font-semibold text-white/90">Username</label>
                    <input
                        id="username"
                        type="text"
                        name="username"
                        placeholder="Masukkan username"
                        autofocus
                        autocomplete="username"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent text-sm"
                    >
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block mb-1.5 text-sm font-semibold text-white/90">Password</label>
                    <div class="relative">
                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="Masukkan password"
                            autocomplete="current-password"
                            class="w-full px-4 py-3 pr-12 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent text-sm"
                        >
                        <button
                            type="button"
                            onclick="togglePassword()"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
                            aria-label="Tampilkan password"
                        >
                            <svg id="icon-eye" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <circle cx="12" cy="12" r="3" stroke-width="2.5"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg id="icon-eye-off" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.477 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Remember Me & Lupa Password -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer group">
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
                        <span class="text-sm text-white/80 group-hover:text-white transition-colors">Ingat saya</span>
                    </label>

                    <a href="{{ route('password.request') }}" class="text-sm font-semibold text-blue-400 hover:text-blue-300 hover:underline transition-colors">
                        Lupa password?
                    </a>
                </div>

                <!-- Tombol Login -->
                <button
                    type="submit"
                    class="w-full py-3.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-sm tracking-widest shadow-[0_0_15px_rgba(37,99,235,0.45)] hover:shadow-[0_0_22px_rgba(37,99,235,0.65)] active:scale-[0.98] transition-all duration-200"
                >
                    LOGIN
                </button>

                <div class="text-center pt-1">
                    <p class="text-sm text-white/75">
                        Ingin menjadi donatur tetap?
                        <a href="{{ route('register') }}" class="font-semibold text-blue-400 hover:text-blue-300 hover:underline transition-colors">Daftar sekarang</a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <p class="relative z-10 mt-6 text-xs text-white/60 font-medium text-center drop-shadow">
        &copy; {{ date('Y') }} Yayasan Mawar Kasih. Semua hak dilindungi.
    </p>

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

    <x-toast />
</body>
</html>
