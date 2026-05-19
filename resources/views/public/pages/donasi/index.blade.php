@extends('public.layouts.app')
@section('title', 'Donasi — Panti Asuhan Mawar Kasih')

@section('content')
<div class="min-h-screen bg-gray-50 py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-10 text-center">
            <h1 class="text-3xl font-bold text-gray-900">Donasi</h1>
            <p class="mt-3 text-sm text-gray-500">Jika Anda sudah menjadi donatur tetap, Anda dapat langsung mengisi nominal dan unggah bukti transfer.</p>
        </div>

        @if(session('success'))
            <div class="mb-8 rounded-3xl border border-green-200 bg-green-50 p-5 text-sm text-green-800">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-8 rounded-3xl border border-red-200 bg-red-50 p-5 text-sm text-red-800">{{ session('error') }}</div>
        @endif

        @if(empty($donatur))
            <div class="rounded-3xl border border-gray-200 bg-white p-10 shadow-sm text-center">
                <h2 class="text-2xl font-semibold text-gray-900">Anda belum terdaftar sebagai donatur tetap</h2>
                <p class="mt-4 text-sm text-gray-600">Silakan masuk melalui halaman login. Jika belum memiliki akun, gunakan opsi "Belum punya akun?" di halaman login untuk mendaftar.</p>
                <div class="mt-6 flex justify-center">
                    <a href="{{ route('public.donasi.login') }}" class="inline-flex items-center justify-center rounded-full border border-brand-600 bg-white px-6 py-3 text-sm font-semibold text-brand-600 transition hover:bg-brand-50">Login Donatur</a>
                </div>
            </div>
        @else
            <div class="rounded-3xl border border-gray-200 bg-white p-10 shadow-sm">
                <div class="mb-8 grid gap-4 sm:grid-cols-2">
                    <div class="rounded-3xl bg-brand-50 p-5">
                        <p class="text-xs uppercase tracking-[0.2em] text-brand-700">Nama</p>
                        <p class="mt-3 text-lg font-semibold text-gray-900">{{ $donatur->nama }}</p>
                    </div>
                    <div class="rounded-3xl bg-brand-50 p-5">
                        <p class="text-xs uppercase tracking-[0.2em] text-brand-700">Email</p>
                        <p class="mt-3 text-lg font-semibold text-gray-900">{{ $donatur->email }}</p>
                    </div>
                    <div class="rounded-3xl bg-brand-50 p-5">
                        <p class="text-xs uppercase tracking-[0.2em] text-brand-700">No. HP</p>
                        <p class="mt-3 text-lg font-semibold text-gray-900">{{ $donatur->no_hp }}</p>
                    </div>
                    <div class="rounded-3xl bg-brand-50 p-5">
                        <p class="text-xs uppercase tracking-[0.2em] text-brand-700">Alamat</p>
                        <p class="mt-3 text-lg font-semibold text-gray-900">{{ $donatur->alamat }}</p>
                    </div>
                </div>

                <form action="{{ route('public.donasi.kirim') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div>
                        <label class="text-sm font-semibold text-gray-700">Nominal Donasi</label>
                        <input type="number" name="nominal" value="{{ old('nominal') }}" placeholder="Masukkan jumlah donasi" class="mt-3 w-full rounded-3xl border border-gray-300 px-4 py-4 text-sm text-gray-900 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100" required>
                        @error('nominal')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-700">Bukti Transfer</label>
                        <input type="file" name="bukti_transfer" class="mt-3 w-full text-sm text-gray-700 file:rounded-full file:border-0 file:bg-brand-100 file:px-4 file:py-2 file:text-brand-700" required>
                        @error('bukti_transfer')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex flex-wrap gap-4 items-center justify-between">
                        <a href="{{ route('public.donatur.profile') }}" class="inline-flex items-center rounded-full border border-gray-300 bg-white px-6 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-100">Lihat Profil</a>
                        <button type="submit" class="inline-flex items-center rounded-full bg-brand-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-brand-700">Kirim Donasi</button>
                    </div>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection