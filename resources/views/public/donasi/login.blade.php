@extends('public.layouts.app')

@section('title', 'Login Donatur')

@section('content')
<div class="bg-gray-50 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="rounded-3xl border border-gray-200 bg-white p-10 shadow-sm">
            <div class="text-center mb-10">
                <h1 class="text-3xl font-bold text-gray-900">Login Donatur</h1>
                <p class="mt-3 text-sm text-gray-500">Masuk email dan password yang Anda gunakan saat registrasi.</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 rounded-3xl border border-red-200 bg-red-50 p-5 text-sm text-red-700">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('public.donasi.login.submit') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-gray-700">Email</label>
                    <input type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="mt-3 w-full rounded-xl border border-gray-300 px-4 py-4 text-sm font-medium text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                    placeholder="masukkan alamat email Anda..."
                    autocomplete="email"
                    required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700">Password</label>
                    
                    <!-- WRAPPER RELATIVE: Penting agar tombol absolute berada di dalam area ini -->
                    <div class="relative mt-3">
                        <input 
                            id="password" 
                            type="password" 
                            name="password" 
                            placeholder="masukkan kata sandi..."
                            autocomplete="current-password" 
                            class="w-full rounded-xl border border-gray-300 px-4 py-4 pr-12 text-sm font-medium text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100" 
                            required>

                        <button
                            type="button"
                            onclick="togglePassword()"
                            class="absolute right-3 top-1/2 -translate-y-1/2 p-1.5 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-all"
                            aria-label="Tampilkan password"
                        >
                            <!-- Icon Mata Terbuka -->
                            <svg id="icon-eye" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            
                            <!-- Icon Mata Dicoret (Hidden by default) -->
                            <svg id="icon-eye-off" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.477 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>

                    <div class="flex justify-start mt-4">
                        <a href="{{ route('public.donasi.password.request') }}" class="text-sm font-semibold text-blue-700 hover:text-blue-500 hover:underline transition-all">
                            Lupa Password?
                        </a>
                    </div>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-sm font-semibold text-gray-700">
                        Belum punya akun?
                        <a href="{{ route('public.donasi.registrasi') }}" class="text-sm font-semibold text-blue-700 hover:text-blue-500 hover:underline transition-all">
                            Registrasi sekarang!
                        </a>
                    </p>
                    <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script: toggle show/hide password -->
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
@endsection