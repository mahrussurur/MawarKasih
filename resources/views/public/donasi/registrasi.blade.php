@extends('public.layouts.app')

@section('title', 'Registrasi Donatur')

@section('content')
<div class="bg-gray-50 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="bg-white rounded-3xl shadow-xl border border-gray-200 overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <div class="lg:col-span-1 bg-blue-600 p-10 text-white">
                    <div class="space-y-6">
                        <div>
                            <h1 class="text-2xl sm:text-3xl font-bold">Selamat datang calon donatur tetap!</h1>
                            <p class="mt-5 text-sm leading-5 text-white/90">Isi data ini sekali saja. Setelah terdaftar, Anda bisa langsung berdonasi tanpa mengisi ulang data pribadi, dan mendapatkan halaman profil serta riwayat donasi.</p>
                        </div>
                        <div class="space-y-4 text-sm text-white/80">
                            <p><strong>Keuntungan:</strong></p>
                            <ul class="list-disc list-inside">
                                <li>Form donasi cepat tanpa mengisi data diri.</li>
                                <li>Profil donatur tersimpan.</li>
                                <li>Riwayat donasi pribadi.</li>
                                <li>Logout kapan saja.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2 p-10">
                    <div class="mb-8 text-center">
                        <h2 class="text-2xl font-bold text-gray-900">Registrasi Donatur</h2>
                        <p class="mt-2 text-sm text-gray-500">Lengkapi data berikut untuk menjadi donatur tetap.</p>
                    </div>

                    <form id="reg-form" action="{{ route('public.donasi.registrasi.submit') }}" method="POST" class="space-y-5" novalidate>
                        @csrf

                        <div>
                            <label class="text-sm font-bold text-gray-800 block">Nama Lengkap</label>
                            <input type="text"
                            name="nama"
                            value="{{ old('nama') }}"
                            class="mt-2 w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent text-sm {{ $errors->has('nama') ? 'input-error' : '' }}"
                            placeholder="Masukkan nama lengkap Anda..."
                            autocomplete="name"
                            required>
                            @error('nama')<p class="mt-2 text-sm text-red-500">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="text-sm font-bold text-gray-800 block">Email</label>
                            <input type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="mt-2 w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent text-sm {{ $errors->has('email') ? 'input-error' : '' }}"
                            placeholder="Masukkan alamat email Anda..."
                            autocomplete="email"
                            required>
                            @error('email')<p class="mt-2 text-sm text-red-500">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="text-sm font-bold text-gray-800 block">Nomor HP</label>
                            <input type="tel"
                            name="no_hp"
                            value="{{ old('no_hp') }}"
                            minlength="10" maxlength="15"
                            class="mt-2 w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent text-sm {{ $errors->has('no_hp') ? 'input-error' : '' }}"
                            placeholder="Masukkan nomor hp Anda..."
                            pattern="[0-9]{10,15}"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                            required>
                            @error('no_hp')<p class="mt-2 text-sm text-red-500">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="text-sm font-bold text-gray-800 block">Alamat Lengkap</label>
                            <textarea 
                                name="alamat"
                                rows="3" 
                                class="mt-2 w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent text-sm {{ $errors->has('alamat') ? 'input-error' : '' }}" 
                                placeholder="Masukkan alamat lengkap Anda..."
                                required>{{ old('alamat') }}</textarea>
                            @error('alamat')<p class="mt-2 text-sm text-red-500">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="text-sm font-bold text-gray-800 block">Password</label>
                            <div class="relative mt-2">
                                <input
                                    id="reg-password"
                                    type="password"
                                    name="password"
                                    class="w-full pl-4 pr-12 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent text-sm {{ $errors->has('password') ? 'input-error' : '' }}"
                                    placeholder="Masukkan kata sandi..."
                                    autocomplete="new-password"
                                    required
                                >
                                <button
                                    type="button"
                                    onclick="togglePassVisibility('reg-password', 'eye-reg-pass')"
                                    class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-brand-600 focus:outline-none"
                                >
                                    <i data-lucide="eye" id="eye-reg-pass" class="w-5 h-5"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="text-sm font-bold text-gray-800 block">Konfirmasi Password</label>
                            <div class="relative mt-2">
                                <input
                                    id="reg-password-conf"
                                    type="password"
                                    name="password_confirmation"
                                    class="w-full pl-4 pr-12 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent text-sm"
                                    placeholder="Ulangi kata sandi..."
                                    required
                                >
                                <button
                                    type="button"
                                    onclick="togglePassVisibility('reg-password-conf', 'eye-reg-pass-conf')"
                                    class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-brand-600 focus:outline-none"
                                >
                                    <i data-lucide="eye" id="eye-reg-pass-conf" class="w-5 h-5"></i>
                                </button>
                            </div>
                            <p id="pass-match-error" class="mt-2 text-sm text-red-500 hidden">Password dan konfirmasi password tidak cocok.</p>
                        </div>

                        <div class="flex flex-wrap gap-3 items-center justify-between">
                            <a href="{{ route('public.home') }}" class="inline-flex items-center justify-center rounded-full border border-gray-200 bg-white px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-100">Batal</a>
                            <button type="submit" class="inline-flex items-center justify-center rounded-full bg-brand-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-brand-700">Daftar Sekarang</button>
                        </div>
                    </form>
                </div>
            </div>
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
        const form = document.getElementById('reg-form');
        const passInput = document.getElementById('reg-password');
        const passConfInput = document.getElementById('reg-password-conf');
        const passMatchError = document.getElementById('pass-match-error');
        const inputs = form.querySelectorAll('input[required], textarea[required]');

        inputs.forEach(input => {
            input.addEventListener('input', function () {
                if (this.checkValidity()) {
                    this.classList.remove('input-error');
                }
                // Recheck password match when typing in either field
                if (this === passInput || this === passConfInput) {
                    if (passInput.value && passConfInput.value && passInput.value !== passConfInput.value) {
                        passConfInput.classList.add('input-error');
                        passMatchError.classList.remove('hidden');
                    } else {
                        passConfInput.classList.remove('input-error');
                        passMatchError.classList.add('hidden');
                    }
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

            // Check password match
            if (passInput.value !== passConfInput.value) {
                e.preventDefault();
                passConfInput.classList.add('input-error');
                passMatchError.classList.remove('hidden');
                if (!firstInvalid) firstInvalid = passConfInput;
            }

            if (firstInvalid) firstInvalid.focus();
        });
    });
</script>
@endsection
