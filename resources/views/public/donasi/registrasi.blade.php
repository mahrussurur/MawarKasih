@extends('public.layouts.app')

@section('title', 'Registrasi Donatur')

@section('content')
<div class="min-h-screen bg-gray-50 py-20">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-xl border border-gray-200 overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2">
                <div class="p-10 bg-brand-600 text-white">
                    <div class="space-y-6">
                        <div>
                            <span class="inline-flex items-center rounded-full bg-white/20 px-3 py-1 text-sm font-semibold uppercase tracking-[0.2em] text-white/90">Registrasi Donatur Tetap</span>
                        </div>
                        <div>
                            <h1 class="text-3xl sm:text-4xl font-bold">Selamat datang calon donatur tetap!</h1>
                            <p class="mt-5 text-sm leading-7 text-white/90">Isi data ini sekali saja. Setelah terdaftar, Anda bisa langsung berdonasi tanpa mengisi ulang data pribadi, dan mendapatkan halaman profil serta riwayat donasi.</p>
                        </div>
                        <div class="space-y-4 text-sm text-white/80">
                            <p><strong>Keuntungan:</strong></p>
                            <ul class="list-disc list-inside">
                                <li>Form donasi cepat: hanya nominal dan bukti transfer.</li>
                                <li>Profil donatur tersimpan.</li>
                                <li>Riwayat donasi pribadi.</li>
                                <li>Logout kapan saja.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="p-10">
                    <div class="mb-8 text-center">
                        <h2 class="text-2xl font-bold text-gray-900">Form Registrasi Donatur</h2>
                        <p class="mt-2 text-sm text-gray-500">Isi data Anda untuk menjadi donatur tetap.</p>
                    </div>

                    @if(session('error'))
                        <div class="mb-5 rounded-2xl bg-red-50 border border-red-200 p-4 text-sm text-red-700">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('public.donasi.registrasi.submit') }}" method="POST" class="space-y-5">
                        @csrf

                        <div>
                            <label class="text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <input type="text" name="nama" value="{{ old('nama') }}" class="mt-2 w-full rounded-2xl border border-gray-300 px-4 py-3 text-sm text-gray-900 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100" required>
                            @error('nama')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="mt-2 w-full rounded-2xl border border-gray-300 px-4 py-3 text-sm text-gray-900 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100" required>
                            @error('email')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-700">Nomor HP</label>
                            <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="mt-2 w-full rounded-2xl border border-gray-300 px-4 py-3 text-sm text-gray-900 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100" required>
                            @error('no_hp')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-700">Alamat</label>
                            <textarea name="alamat" rows="4" class="mt-2 w-full rounded-2xl border border-gray-300 px-4 py-3 text-sm text-gray-900 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100" required>{{ old('alamat') }}</textarea>
                            @error('alamat')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-700">Password</label>
                            <input type="password" name="password" class="mt-2 w-full rounded-2xl border border-gray-300 px-4 py-3 text-sm text-gray-900 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100" required>
                            @error('password')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-700">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="mt-2 w-full rounded-2xl border border-gray-300 px-4 py-3 text-sm text-gray-900 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100" required>
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
