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

            <form id="login-form" action="{{ route('public.donasi.login.submit') }}" method="POST" class="space-y-6" novalidate>
                @csrf

                <div>
                    <label class="text-sm font-bold text-gray-800 block">Email</label>
                    <input type="email"
                    id="login-email"
                    name="email"
                    value="{{ old('email') }}"
                    class="mt-2 w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent text-sm {{ $errors->has('email') ? 'input-error' : '' }}"
                    placeholder="Masukkan alamat email Anda..."
                    autocomplete="email"
                    required>
                    @error('email')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="text-sm font-bold text-gray-800 block">Password</label>
                    
                    <div class="relative mt-2">
                        <input 
                            id="password" 
                            type="password" 
                            name="password" 
                            placeholder="Masukkan kata sandi..."
                            autocomplete="current-password" 
                            class="w-full pl-4 pr-12 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent text-sm {{ $errors->has('password') ? 'input-error' : '' }}"
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

<style>
    .input-error {
        border-color: transparent !important;
        box-shadow: 0 0 0 2px #f87171 !important;
        outline: none !important;
    }
</style>

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
        lucide.createIcons();
    }

    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('login-form');
        const inputs = form.querySelectorAll('input[required]');

        inputs.forEach(input => {
            input.addEventListener('input', function () {
                if (this.checkValidity()) {
                    this.classList.remove('input-error');
                }
            });
        });

        form.addEventListener('submit', function (e) {
            let firstInvalid = null;
            inputs.forEach(input => {
                if (!input.checkValidity()) {
                    e.preventDefault();
                    input.classList.add('input-error');
                    if (!firstInvalid) firstInvalid = input;
                }
            });
            if (firstInvalid) firstInvalid.focus();
        });
    });
</script>
@endsection
