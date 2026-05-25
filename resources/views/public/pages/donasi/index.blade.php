@extends('public.layouts.app')
@section('title', 'Donasi - Panti Asuhan Mawar Kasih')

@section('content')
@php
    $errorBag = $errors instanceof \Illuminate\Support\ViewErrorBag ? $errors : new \Illuminate\Support\ViewErrorBag();
@endphp
<div class="min-h-screen bg-gray-50 py-20">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-10 text-center">
            <span class="inline-flex items-center rounded-full bg-brand-50 px-4 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-brand-700">Form Donasi Publik</span>
            <h1 class="mt-4 text-3xl font-bold text-gray-900">Pilih jalur donasi yang sesuai</h1>
            <p class="mt-3 text-sm text-gray-600">Anda dapat berdonasi sebagai <strong>Guest</strong> atau sebagai <strong>Donatur Tetap</strong>. Semua laporan akan menandai sumber donasi secara jelas.</p>
        </div>

        @if(session('success'))
            <div class="mb-8 rounded-3xl border border-green-200 bg-green-50 p-5 text-sm text-green-800">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-8 rounded-3xl border border-red-200 bg-red-50 p-5 text-sm text-red-800">{{ session('error') }}</div>
        @endif

        @if($errorBag->any())
            <div class="mb-8 rounded-3xl border border-red-200 bg-red-50 p-5 text-sm text-red-800">
                <p class="font-semibold">Terdapat kesalahan pada pengisian form:</p>
                <ul class="mt-3 list-disc pl-5">
                    @foreach($errorBag->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(empty($donatur))
            <section class="mx-auto max-w-3xl rounded-[28px] border border-gray-200 bg-white p-8 shadow-sm">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-500">Guest</p>
                        <h2 class="mt-2 text-xl font-bold text-gray-900">Donasi Tanpa Akun</h2>
                    </div>
                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">Tanpa login</span>
                </div>
                <p class="mt-4 text-sm leading-6 text-gray-600">Isi nama, nomor HP, dan email Anda untuk mencatat donasi secara aman. Data ini akan dicatat sebagai <strong>Guest</strong> dan tidak terhubung ke akun donatur tetap.</p>

                <form action="{{ route('public.donasi.kirim') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-5">
                    @csrf
                    <input type="text" name="website" value="" autocomplete="off" tabindex="-1" class="hidden" aria-hidden="true">

                    <div>
                        <label class="text-sm font-semibold text-gray-700">Nama Donatur</label>
                        <input type="text" name="nama_donatur" value="{{ old('nama_donatur') }}" maxlength="255" placeholder="Nama lengkap" class="mt-2 w-full rounded-2xl border border-gray-300 px-4 py-3 text-sm text-gray-900 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100" required>
                        @error('nama_donatur')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" maxlength="255" placeholder="contoh@email.com" class="mt-2 w-full rounded-2xl border border-gray-300 px-4 py-3 text-sm text-gray-900 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100" required>
                        @error('email')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-700">Nomor HP</label>
                        <input type="tel" name="no_hp" value="{{ old('no_hp') }}" maxlength="20" placeholder="08xxxxxxxxxx" class="mt-2 w-full rounded-2xl border border-gray-300 px-4 py-3 text-sm text-gray-900 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100" required>
                        @error('no_hp')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-700">Nominal Donasi</label>
                        <input type="number" name="nominal" value="{{ old('nominal') }}" min="1000" max="100000000" placeholder="Masukkan jumlah donasi" class="mt-2 w-full rounded-2xl border border-gray-300 px-4 py-3 text-sm text-gray-900 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100" required>
                        @error('nominal')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-700">Bukti Transfer</label>
                        <input type="file" name="bukti_transfer" accept="image/png,image/jpeg,image/webp" class="mt-2 w-full rounded-2xl border border-dashed border-gray-300 bg-gray-50 px-4 py-3 text-sm text-gray-700 file:mr-3 file:rounded-full file:border-0 file:bg-brand-100 file:px-4 file:py-2 file:text-brand-700" required>
                        <p class="mt-2 text-xs text-gray-500">Format yang diterima: JPG, PNG, WEBP. Maksimal 2 MB.</p>
                        @error('bukti_transfer')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <label class="flex items-start gap-3 rounded-2xl bg-gray-50 px-4 py-3 text-sm text-gray-700">
                        <input type="checkbox" name="agree" value="1" class="mt-1 rounded border-gray-300 text-brand-600 focus:ring-brand-500" required>
                        <span>Saya menyetujui bahwa data yang saya kirimkan akan diproses untuk tujuan donasi dan verifikasi transfer.</span>
                    </label>
                    @error('agree')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror

                    <button type="submit" class="inline-flex w-full items-center justify-center rounded-full bg-brand-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-brand-700">Kirim Donasi sebagai Guest</button>
                </form>
            </section>
        @else
            <section class="mx-auto max-w-3xl rounded-[28px] border border-brand-100 bg-brand-50/40 p-8 shadow-sm">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-brand-700">Donatur Tetap</p>
                        <h2 class="mt-2 text-xl font-bold text-gray-900">Selamat datang, {{ $donatur->nama }}</h2>
                    </div>
                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Akun aktif</span>
                </div>
                <p class="mt-4 text-sm leading-6 text-gray-600">Data profil Anda akan digunakan otomatis. Admin dapat membedakan donasi ini sebagai <strong>Donatur Tetap</strong> melalui ID akun di data donasi.</p>

                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    <div class="rounded-2xl bg-white p-4">
                        <p class="text-xs uppercase tracking-[0.2em] text-gray-500">Nama</p>
                        <p class="mt-2 text-sm font-semibold text-gray-900">{{ $donatur->nama }}</p>
                    </div>
                    <div class="rounded-2xl bg-white p-4">
                        <p class="text-xs uppercase tracking-[0.2em] text-gray-500">Email</p>
                        <p class="mt-2 text-sm font-semibold text-gray-900">{{ $donatur->email }}</p>
                    </div>
                    <div class="rounded-2xl bg-white p-4">
                        <p class="text-xs uppercase tracking-[0.2em] text-gray-500">No. HP</p>
                        <p class="mt-2 text-sm font-semibold text-gray-900">{{ $donatur->no_hp }}</p>
                    </div>
                    <div class="rounded-2xl bg-white p-4">
                        <p class="text-xs uppercase tracking-[0.2em] text-gray-500">Alamat</p>
                        <p class="mt-2 text-sm font-semibold text-gray-900">{{ $donatur->alamat }}</p>
                    </div>
                </div>

                <form action="{{ route('public.donasi.kirim') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-5">
                    @csrf
                    <input type="text" name="website" value="" autocomplete="off" tabindex="-1" class="hidden" aria-hidden="true">

                    <div>
                        <label class="text-sm font-semibold text-gray-700">Nominal Donasi</label>
                        <input type="number" name="nominal" value="{{ old('nominal') }}" min="1000" max="100000000" placeholder="Masukkan jumlah donasi" class="mt-2 w-full rounded-2xl border border-gray-300 px-4 py-3 text-sm text-gray-900 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100" required>
                        @error('nominal')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-700">Bukti Transfer</label>
                        <input type="file" name="bukti_transfer" accept="image/png,image/jpeg,image/webp" class="mt-2 w-full rounded-2xl border border-dashed border-gray-300 bg-white px-4 py-3 text-sm text-gray-700 file:mr-3 file:rounded-full file:border-0 file:bg-brand-100 file:px-4 file:py-2 file:text-brand-700" required>
                        <p class="mt-2 text-xs text-gray-500">Format yang diterima: JPG, PNG, WEBP. Maksimal 2 MB.</p>
                        @error('bukti_transfer')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <label class="flex items-start gap-3 rounded-2xl bg-white px-4 py-3 text-sm text-gray-700">
                        <input type="checkbox" name="agree" value="1" class="mt-1 rounded border-gray-300 text-brand-600 focus:ring-brand-500" required>
                        <span>Saya menyetujui bahwa data yang saya kirimkan akan diproses untuk tujuan donasi dan verifikasi transfer.</span>
                    </label>
                    @error('agree')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror

                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <a href="{{ route('public.donatur.profile') }}" class="inline-flex items-center rounded-full border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-100">Lihat Profil</a>
                        <button type="submit" class="inline-flex items-center rounded-full bg-brand-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-brand-700">Kirim Donasi sebagai Donatur Tetap</button>
                    </div>
                </form>
            </section>
        @endif
    </div>
</div>
@endsection
