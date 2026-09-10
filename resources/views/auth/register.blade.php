<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Donatur Tetap — Panti Asuhan Mawar Kasih</title>

    <!-- Google Font Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen font-['Plus_Jakarta_Sans',sans-serif] flex flex-col items-center justify-center px-4 py-10 relative">

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
            <h1 class="text-2xl font-extrabold text-white text-center tracking-wide mb-1">DAFTAR DONATUR TETAP</h1>
            <p class="text-sm text-white/75 text-center mb-6 leading-relaxed">
                Silahkan lengkapi data diri Anda di bawah ini.
            </p>

            <!-- Alert errors -->
            @if ($errors->any())
                <div class="mb-4 rounded-xl bg-red-500/20 border border-red-400/40 px-4 py-3 text-sm text-red-200">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- Nama & Username -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block mb-1.5 text-sm font-semibold text-white/90">Nama Lengkap</label>
                        <input
                            id="name"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Nama lengkap"
                            required
                            autofocus
                            autocomplete="name"
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent text-sm"
                        >
                        @error('name')
                            <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="username" class="block mb-1.5 text-sm font-semibold text-white/90">Username</label>
                        <input
                            id="username"
                            type="text"
                            name="username"
                            value="{{ old('username') }}"
                            placeholder="Username untuk login"
                            required
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent text-sm"
                        >
                        @error('username')
                            <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Email & No HP -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="email" class="block mb-1.5 text-sm font-semibold text-white/90">Email</label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Alamat email"
                            required
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent text-sm"
                        >
                        @error('email')
                            <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="no_hp" class="block mb-1.5 text-sm font-semibold text-white/90">Nomor Handphone</label>
                        <input
                            id="no_hp"
                            type="tel"
                            name="no_hp"
                            value="{{ old('no_hp') }}"
                            placeholder="Contoh: 08123456789"
                            required
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent text-sm"
                        >
                        @error('no_hp')
                            <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Alamat -->
                <div>
                    <label for="alamat" class="block mb-1.5 text-sm font-semibold text-white/90">Alamat <span class="font-normal text-white/50">(Opsional)</span></label>
                    <textarea
                        id="alamat"
                        name="alamat"
                        rows="2"
                        placeholder="Alamat domisili"
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent text-sm resize-none"
                    >{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password & Konfirmasi -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block mb-1.5 text-sm font-semibold text-white/90">Password</label>
                        <div class="relative">
                            <input
                                id="password"
                                type="password"
                                name="password"
                                placeholder="Minimal 8 karakter"
                                required
                                class="w-full px-4 py-2.5 pr-10 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent text-sm"
                            >
                            <button type="button" onclick="togglePassword('password', 'icon-eye-1', 'icon-eye-off-1')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                                <svg id="icon-eye-1" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <circle cx="12" cy="12" r="3" stroke-width="2.5"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg id="icon-eye-off-1" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.477 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-xs text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block mb-1.5 text-sm font-semibold text-white/90">Konfirmasi Password</label>
                        <div class="relative">
                            <input
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                placeholder="Ulangi password"
                                required
                                class="w-full px-4 py-2.5 pr-10 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent text-sm"
                            >
                            <button type="button" onclick="togglePassword('password_confirmation', 'icon-eye-2', 'icon-eye-off-2')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                                <svg id="icon-eye-2" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <circle cx="12" cy="12" r="3" stroke-width="2.5"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg id="icon-eye-off-2" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.477 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Tombol Daftar -->
                <div class="pt-2">
                    <button
                        type="submit"
                        class="w-full py-3.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-sm tracking-widest shadow-[0_0_15px_rgba(37,99,235,0.45)] hover:shadow-[0_0_22px_rgba(37,99,235,0.65)] active:scale-[0.98] transition-all duration-200"
                    >
                        DAFTAR SEKARANG
                    </button>
                </div>

                <div class="text-center pt-1">
                    <p class="text-sm text-white/75">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="font-semibold text-blue-400 hover:text-blue-300 hover:underline transition-colors">Login di sini</a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <p class="relative z-10 mt-6 text-xs text-white/60 font-medium text-center drop-shadow">
        &copy; {{ date('Y') }} Yayasan Mawar Kasih. Semua hak dilindungi.
    </p>

    <script>
        function togglePassword(inputId, iconOnId, iconOffId) {
            const input   = document.getElementById(inputId);
            const iconOn  = document.getElementById(iconOnId);
            const iconOff = document.getElementById(iconOffId);

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
