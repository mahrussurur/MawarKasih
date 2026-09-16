<x-guest-layout>
    <h2 class="text-2xl font-bold text-gray-800 text-center mb-2">
        Reset Password
    </h2>
    <p class="text-sm text-gray-500 text-center mb-6">
        Masukkan password baru Anda
    </p>

    <form method="POST" action="{{ request()->routeIs('public.donasi.*') ? route('public.donasi.password.update') : route('password.store') }}" class="space-y-5">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <!-- Email -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input 
                type="email" 
                name="email" 
                value="{{ old('email', $request->email) }}"
                required
                placeholder="Masukkan email"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
            >
            @error('email')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password Baru -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
            <div class="relative">
                <input 
                    type="password" 
                    name="password" 
                    id="password"
                    required
                    placeholder="Password baru"
                    class="w-full px-4 py-2 pr-10 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >
                <button type="button" onclick="togglePassword('password', 'eye-password', 'eye-off-password')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none transition-colors">
                    <!-- Icon Mata Terbuka -->
                    <svg id="eye-password" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <!-- Icon Mata Dicoret -->
                    <svg id="eye-off-password" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.477 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                    </svg>
                </button>
            </div>
            @error('password')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Konfirmasi Password -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
            <div class="relative">
                <input 
                    type="password" 
                    name="password_confirmation" 
                    id="password_confirmation"
                    required
                    placeholder="Konfirmasi password"
                    class="w-full px-4 py-2 pr-10 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                >
                <button type="button" onclick="togglePassword('password_confirmation', 'eye-confirm', 'eye-off-confirm')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none transition-colors">
                    <!-- Icon Mata Terbuka -->
                    <svg id="eye-confirm" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <!-- Icon Mata Dicoret -->
                    <svg id="eye-off-confirm" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.477 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                    </svg>
                </button>
            </div>
        </div>

        <button 
            type="submit"
            class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition font-medium"
        >
            Reset Password
        </button>
    </form>

    <p class="text-center text-sm text-gray-500 mt-6">
        <a href="{{ request()->routeIs('public.donasi.*') ? route('public.donasi.login') : route('login') }}" class="text-blue-600 hover:underline font-medium">
            Kembali ke Login
        </a>
    </p>
</x-guest-layout>

{{-- Script untuk Toggle Password --}}
<script>
    function togglePassword(inputId, eyeId, eyeOffId) {
        const input = document.getElementById(inputId);
        const eye = document.getElementById(eyeId);
        const eyeOff = document.getElementById(eyeOffId);

        if (input.type === 'password') {
            input.type = 'text';
            eye.classList.add('hidden');
            eyeOff.classList.remove('hidden');
        } else {
            input.type = 'password';
            eye.classList.remove('hidden');
            eyeOff.classList.add('hidden');
        }
    }
</script>
