@extends('public.layouts.app')

@section('title', 'Registrasi Donatur')

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center py-16">
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
                        <h2 class="text-2xl font-bold text-gray-900">Formulir Registrasi Donatur</h2>
                        <p class="mt-2 text-sm text-gray-500">Lengkapi data berikut untuk menjadi donatur tetap.</p>
                    </div>

                    @if(session('error'))
                        <div class="mb-5 rounded-2xl bg-red-50 border border-red-200 p-4 text-sm text-red-700">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('public.donasi.registrasi.submit') }}" method="POST" class="space-y-5">
                        @csrf

                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Nama Lengkap</label>
                            <input type="text"
                            name="nama"
                            value="{{ old('nama') }}"
                            class="mt-3 w-full rounded-xl border border-gray-300 px-4 py-4 text-sm font-medium text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                            placeholder="masukkan nama lengkap Anda..."
                            autocomplete="name"
                            required>
                            @error('nama')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Email</label>
                            <input type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="mt-3 w-full rounded-xl border border-gray-300 px-4 py-4 text-sm font-medium text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                            placeholder="masukkan alamat email Anda..."
                            autocomplete="email"
                            required>
                            @error('email')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Nomor HP</label>
                            <input type="text"
                            name="no_hp"
                            value="{{ old('no_hp') }}"
                            class="mt-3 w-full rounded-xl border border-gray-300 px-4 py-4 text-sm font-medium text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
                            placeholder="masukkan nomor hp Anda..."
                            required>
                            @error('no_hp')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Alamat Lengkap</label>
                            <textarea 
                                name="alamat"
                                rows="3" 
                                class="mt-3 w-full rounded-xl border border-gray-300 px-4 py-4 text-sm font-medium text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100" 
                                placeholder="masukkan alamat lengkap Anda..."
                                required>{{ old('alamat') }}</textarea>
                            @error('alamat')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Password</label>
                            <input type="password" name="password" class="mt-3 w-full rounded-xl border border-gray-300 px-4 py-4 text-sm font-medium text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100" required>
                            @error('password')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="mt-3 w-full rounded-xl border border-gray-300 px-4 py-4 text-sm font-medium text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100" required>
                        </div>

                        <div class="flex flex-wrap gap-3 items-center justify-between">
                            <a href="{{ route('public.home') }}" class="inline-flex items-center justify-center rounded-full border border-gray-200 bg-white px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">Batal</a>
                            <button type="submit" class="inline-flex items-center justify-center rounded-full bg-brand-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-brand-700">Daftar Sekarang</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
