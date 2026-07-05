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
                    <label class="text-sm font-bold text-gray-800 block">Email</label>
                    <input type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="mt-2 w-full px-4 py-3 rounded-lg text-sm text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                    placeholder="Masukkan alamat email Anda..."
                    autocomplete="email"
                    required>
                </div>

                <div>
                    <label class="text-sm font-bold text-gray-800 block">Password</label>
                    
                    <!-- WRAPPER RELATIVE: Penting agar tombol absolute berada di dalam area ini -->
                    <div class="relative mt-2">
                        <input 
                            id="password" 
                            type="password" 
                            name="password" 
                            placeholder="Masukkan kata sandi..."
                            autocomplete="current-password" 
                            class="w-full px-4 py-3 pr-12 rounded-lg text-sm text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                            required>

                        <button
                            type="button"
                            onclick="togglePassVisibility('password', 'eye-password')"
                            class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-brand-600 focus:outline-none"
                        >
                            <i data-lucide="eye" id="eye-password" class="w-5 h-5"></i>
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
                    <button type="submit" class="inline-flex items-center justify-center rounded-full bg-brand-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-brand-700">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script: toggle show/hide password -->
<script>
    function togglePassVisibility(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        if (input.type === 'password') {
            input.type = 'text';
            icon.setAttribute('data-lucide', 'eye-off');
        } else {
            input.type = 'password';
            icon.setAttribute('data-lucide', 'eye');
        }
        lucide.createIcons(); // Refresh icons
    }
</script>
@endsection