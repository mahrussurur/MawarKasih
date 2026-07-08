@extends('public.layouts.app')
@section('title', 'Donasi | Panti Asuhan Mawar Kasih')

@section('content')
@php
    $errorBag = $errors instanceof \Illuminate\Support\ViewErrorBag ? $errors : new \Illuminate\Support\ViewErrorBag();
@endphp
<div class="bg-gray-50 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">


        @if($errors->any())
            <div class="mb-8 rounded-3xl border border-red-200 bg-red-50 p-5 text-sm text-red-800">
                <p class="font-semibold">Terdapat kesalahan pada pengisian form:</p>
                <ul class="mt-3 list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(empty($donatur))
            <section class="rounded-[28px] border border-gray-200 bg-white p-5 sm:p-10 shadow-sm">
                <div class="flex items-start justify-between gap-4">
                    <h2 class="mt-2 text-xl font-bold text-gray-900">Formulir Donasi</h2>
                </div>

                <form action="{{ route('public.donasi.kirim') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-5">
                    @csrf
                    <input type="text" name="website" value="" autocomplete="off" tabindex="-1" class="hidden" aria-hidden="true">

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
                        <!-- Kolom Kiri: Input Nama -->
                        <div class="md:col-span-8 space-y-2">
                            <label class="text-sm font-bold text-gray-800">
                                Nama <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                name="nama_donatur"
                                value="{{ old('nama_donatur') }}"
                                maxlength="255"
                                placeholder="Nama"
                                class="w-full px-4 py-3 rounded-lg text-sm text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                required>
                            @error('nama_donatur')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kolom Kanan: Pilihan Radio Tampilkan Nama -->
                        <div class="md:col-span-4 space-y-2">
                            <label class="text-sm font-bold text-gray-800">
                                Nama yang ditampilkan <span class="text-red-500">*</span>
                            </label>
                            <div class="flex flex-wrap items-center gap-4 h-[42px]"> <!-- h-[42px] untuk menyelaraskan tinggi dengan input sebelah kiri -->
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="tampilkan_nama" value="nama_asli" class="w-4 h-4 text-brand-600 focus:ring-brand-500" required checked>
                                    <span class="text-sm font-semibold text-gray-700">Nama asli</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="tampilkan_nama" value="hamba_allah" class="w-4 h-4 text-brand-600 focus:ring-brand-500" required>
                                    <span class="text-sm font-semibold text-gray-700">Hamba Tuhan</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="tampilkan_nama" value="anonim" class="w-4 h-4 text-brand-600 focus:ring-brand-500" required>
                                    <span class="text-sm font-semibold text-gray-700">Anonim</span>
                                </label>
                            </div>
                            @error('tampilkan_nama')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-bold text-gray-800">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            maxlength="255"
                            placeholder="cth. contoh@gmail.com"
                            class="mt-2 w-full px-4 py-3 rounded-lg text-sm text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                            pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}"
                            title="Format email tidak valid (contoh: nama@domain.com)"
                            required>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="text-sm font-bold text-gray-800">
                            Nomor HP <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="tel"
                            name="no_hp"
                            value="{{ old('no_hp') }}"
                            minlength="10"
                            maxlength="15"
                            placeholder="cth. 081234567890"
                            class="mt-2 w-full px-4 py-3 rounded-lg text-sm text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                            pattern="[0-9]{10,15}"
                            title="Hanya angka, 10-15 digit"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                            required>
                        @error('no_hp')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="text-sm font-bold text-gray-800">
                            Alamat
                        </label>
                        <textarea
                            name="alamat"
                            rows="3"
                            class="mt-2 w-full px-4 py-3 rounded-lg text-sm text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                            placeholder="Masukkan alamat Anda (opsional)"
                        >{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="text-sm font-bold text-gray-800 block mb-2">
                            Nominal Donasi <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 gap-3 sm:grid-cols-4 mb-3">
                            <label class="cursor-pointer relative">
                                <input type="radio" name="nominal_option" value="10000" class="peer sr-only nominal-radio">
                                <div class="flex items-center justify-center py-3 rounded-lg border-2 border-gray-200 bg-white hover:border-blue-500 transition-all peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700 font-semibold text-gray-700 text-sm">
                                    Rp 10.000
                                </div>
                            </label>
                            <label class="cursor-pointer relative">
                                <input type="radio" name="nominal_option" value="50000" class="peer sr-only nominal-radio">
                                <div class="flex items-center justify-center py-3 rounded-lg border-2 border-gray-200 bg-white hover:border-blue-500 transition-all peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700 font-semibold text-gray-700 text-sm">
                                    Rp 50.000
                                </div>
                            </label>
                            <label class="cursor-pointer relative">
                                <input type="radio" name="nominal_option" value="100000" class="peer sr-only nominal-radio">
                                <div class="flex items-center justify-center py-3 rounded-lg border-2 border-gray-200 bg-white hover:border-blue-500 transition-all peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700 font-semibold text-gray-700 text-sm">
                                    Rp 100.000
                                </div>
                            </label>
                            <label class="cursor-pointer relative">
                                <input type="radio" name="nominal_option" value="lainnya" class="peer sr-only nominal-radio" checked>
                                <div class="flex items-center justify-center py-3 rounded-lg border-2 border-gray-200 bg-white hover:border-blue-500 transition-all peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700 font-semibold text-gray-700 text-sm">
                                    Lainnya
                                </div>
                            </label>
                        </div>
                        <div class="nominal-manual-container space-y-2">
                            <label class="text-sm font-bold text-gray-800">
                                Nominal <span class="text-red-500">*</span>
                            </label>

                            <div class="flex rounded-lg border border-gray-300 bg-white overflow-hidden focus-within:outline-none focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-transparent transition-all duration-300">
                                <span class="inline-flex items-center px-4 bg-gray-100 border-r border-gray-300 text-sm font-medium text-gray-600 select-none">
                                    Rp
                                </span>
                                
                                <input type="text" 
                                    name="nominal_manual"
                                    class="nominal-manual w-full bg-transparent px-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none" 
                                    placeholder="Nominal">
                            </div>
                        </div>
                        <input type="hidden" name="nominal" class="nominal-hidden" value="{{ old('nominal') }}" required>
                        @error('nominal')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="space-y-3">

                        <label class="text-sm font-bold text-gray-800 block">
                            Pilih Metode Pembayaran <span class="text-red-500">*</span>
                        </label>

                        <div class="flex flex-col md:flex-row divide-y-2 md:divide-y-0 md:divide-x-2 divide-gray-200 payment-group">
                            
                            <!-- QRIS -->
                            <div class="flex-1 flex flex-col items-center p-4">
                                <label class="payment-card rounded-lg cursor-pointer relative group flex flex-col items-center text-center bg-transparent" data-value="qris">
                                    <input
                                        type="radio" 
                                        name="metode_pembayaran" 
                                        value="qris" 
                                        id="qris-logged" 
                                        class="sr-only peer" 
                                        required checked
                                    >
                                    
                                    <div class="relative rounded-xl p-3 transition-all bg-transparent">
                                        
                                        <div class="payment-overlay pointer-events-none absolute inset-0 flex items-center justify-center opacity-0 transition-opacity duration-200 peer-checked:opacity-100 bg-transparent">
                                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-green-500 shadow-lg">
                                                <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                </svg>
                                            </div>
                                        </div>
                                        
                                        <img src="{{ asset('images/qris-logo.png') }}" alt="QRIS" class="h-10 object-contain relative z-0 bg-transparent">
                                    </div>
                                </label>

                                <!-- QR BISA DIDOWNLOAD -->
                                <a href="{{ asset('images/qris-barcode.png') }}"
                                    download="QRIS-Panti-Asuhan-Mawar-Kasih.png"
                                    title="Klik untuk mengunduh QRIS">
                                    <img src="{{ asset('images/qris-barcode.png') }}"
                                        alt="QRIS Barcode"
                                        class="w-48 h-48 object-contain rounded-lg hover:shadow hover:shadow-green-400 transition">
                                </a>

                                <div class="mt-4 space-y-1 text-center">
                                    <p class="text-sm font-bold text-gray-800 uppercase tracking-wide">
                                        Panti Asuhan Mawar Kasih
                                    </p>
                                    <p class="text-xs font-semibold text-gray-500">
                                        NMID: ID84767348362832
                                    </p>
                                </div>

                            </div>

                            <!-- MANDIRI -->
                            <div class="flex-1 flex flex-col items-center p-4">

                                <label class="payment-card cursor-pointer relative group flex flex-col items-center"
                                    data-value="mandiri">

                                    <input
                                        type="radio"
                                        name="metode_pembayaran"
                                        value="mandiri"
                                        id="mandiri-logged"
                                        class="sr-only peer">

                                    <!-- Logo sejajar dengan logo QRIS -->
                                    <div class="relative rounded-xl p-3 transition-all bg-transparent">

                                        <div class="payment-overlay pointer-events-none absolute inset-0 flex items-center justify-center opacity-0 transition-opacity duration-200">
                                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-green-500 shadow-lg">
                                                <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                </svg>
                                            </div>
                                        </div>

                                        <img
                                            src="https://upload.wikimedia.org/wikipedia/commons/a/ad/Bank_Mandiri_logo_2016.svg"
                                            alt="Mandiri"
                                            class="h-10 object-contain">
                                    </div>

                                </label>

                                <!-- Area nomor rekening sejajar dengan QR -->
                                <div class="w-48 h-48 flex items-center justify-center mt-2">
                                    <div class="text-center">
                                        <p class="text-xs text-gray-500 uppercase tracking-wide">
                                            Nomor Rekening
                                        </p>

                                        <p class="mt-2 font-bold text-gray-800 tracking-wider">
                                            143-00-2888931 7
                                        </p>

                                        <button
                                            type="button"
                                            onclick="salinNomorRekening('143-00-2888931 7')"
                                            class="mt-3 text-xs text-green-600 hover:text-green-700 font-medium flex items-center justify-center gap-1 mx-auto">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                            </svg>
                                            Salin No. Rekening
                                        </button>
                                    </div>
                                </div>

                                <!-- Sejajar dengan bagian NMID -->
                                <div class="mt-4 space-y-1 text-center">
                                    <p class="text-sm font-bold text-gray-800 uppercase tracking-wide">
                                        BANK MANDIRI
                                    </p>

                                    <p class="text-xs font-semibold text-gray-500">
                                        a.n. Panti Asuhan Mawar Kasih
                                    </p>
                                </div>

                            </div>
                        </div>

                        @error('metode_pembayaran')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror

                    </div>

                    <div class="mt-4">
                        <label class="text-sm font-bold text-gray-800 block mb-2">Bukti Transfer &nbsp; <span class="text-sm font-normal text-gray-400">(opsional)</span></label>
                        <input type="file" id="bukti_transfer_input_1" name="bukti_transfer" accept="image/*" class="w-full rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-200 file:text-gray-900 hover:file:bg-gray-300 cursor-pointer">
                        <div id="preview_container_1" class="mt-3 hidden">
                            <img id="bukti_transfer_preview_1" src="#" alt="Preview Bukti Transfer" class="max-h-48 w-auto rounded-lg object-cover border border-gray-200 shadow-sm">
                            <button type="button" id="remove_preview_1" class="mt-2 text-sm text-red-600 hover:text-red-700 font-medium focus:outline-none">Hapus Foto</button>
                        </div>
                        @error('bukti_transfer')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label class="text-sm font-bold text-gray-800 block mb-2">Keterangan / Doa</label>
                        <textarea 
                            name="keterangan" 
                            rows="3" 
                            class="w-full px-4 py-3 rounded-lg text-sm text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300" 
                            placeholder="Tuliskan doa atau pesan Anda (opsional)">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-6 flex items-start gap-2 text-sm text-amber-500 font-medium">
                        <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p>
                            Pastikan seluruh data donasi telah diisi dengan benar sebelum mengirim formulir donasi.
                        </p>
                    </div>

                    <div class="flex justify-center mt-6">
                        <button type="submit" class="inline-flex items-center gap-2 justify-center rounded-full bg-green-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-green-700">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z M17 21v-8H7v8 M7 3v5h8" />
                            </svg>
                            Kirim Donasi
                        </button>
                    </div>
                </form>
            </section>
        @else
            <section class="rounded-[28px] border border-gray-200 bg-white p-5 sm:p-10 shadow-sm">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h2 class="mt-2 text-xl font-bold text-gray-900">Formulir Donasi</h2>
                    </div>
                </div>
                
                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    <div class="rounded-lg bg-gray-100 p-4 min-w-0">
                        <p class="text-xs uppercase tracking-[0.2em] text-gray-500">Nama</p>
                        <p class="mt-2 text-sm font-semibold text-gray-900 break-all">{{ $donatur->nama }}</p>
                    </div>
                    <div class="rounded-lg bg-gray-100 p-4 min-w-0">
                        <p class="text-xs uppercase tracking-[0.2em] text-gray-500">Email</p>
                        <p class="mt-2 text-sm font-semibold text-gray-900 break-all">{{ $donatur->email }}</p>
                    </div>
                    <div class="rounded-lg bg-gray-100 p-4 min-w-0">
                        <p class="text-xs uppercase tracking-[0.2em] text-gray-500">No. HP</p>
                        <p class="mt-2 text-sm font-semibold text-gray-900 break-all">{{ $donatur->no_hp }}</p>
                    </div>
                    <div class="rounded-lg bg-gray-100 p-4 min-w-0">
                        <p class="text-xs uppercase tracking-[0.2em] text-gray-500">Alamat</p>
                        <p class="mt-2 text-sm font-semibold text-gray-900 break-all">{{ $donatur->alamat }}</p>
                    </div>
                </div>

                <form action="{{ route('public.donasi.kirim') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-5">
                    @csrf
                    <input type="text" name="website" value="" autocomplete="off" tabindex="-1" class="hidden" aria-hidden="true">

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-gray-800">
                            Nama yang ditampilkan <span class="text-red-500">*</span>
                        </label>
                        <div class="flex flex-wrap items-center gap-4 h-[42px]">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="tampilkan_nama" value="nama_asli" class="w-4 h-4 text-brand-600 focus:ring-brand-500" required checked>
                                <span class="text-sm font-semibold text-gray-700">Nama asli</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="tampilkan_nama" value="hamba_allah" class="w-4 h-4 text-brand-600 focus:ring-brand-500" required>
                                <span class="text-sm font-semibold text-gray-700">Hamba Tuhan</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="tampilkan_nama" value="anonim" class="w-4 h-4 text-brand-600 focus:ring-brand-500" required>
                                <span class="text-sm font-semibold text-gray-700">Anonim</span>
                            </label>
                        </div>
                        @error('tampilkan_nama')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="text-sm font-bold text-gray-800 block mb-2">
                            Nominal Donasi <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 gap-3 sm:grid-cols-4 mb-3">
                            <label class="cursor-pointer relative">
                                <input type="radio" name="nominal_option" value="10000" class="peer sr-only nominal-radio">
                                <div class="flex items-center justify-center py-3 rounded-lg border-2 border-gray-200 bg-white hover:border-blue-500 transition-all peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700 font-semibold text-gray-700 text-sm">
                                    Rp 10.000
                                </div>
                            </label>
                            <label class="cursor-pointer relative">
                                <input type="radio" name="nominal_option" value="50000" class="peer sr-only nominal-radio">
                                <div class="flex items-center justify-center py-3 rounded-lg border-2 border-gray-200 bg-white hover:border-blue-500 transition-all peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700 font-semibold text-gray-700 text-sm">
                                    Rp 50.000
                                </div>
                            </label>
                            <label class="cursor-pointer relative">
                                <input type="radio" name="nominal_option" value="100000" class="peer sr-only nominal-radio">
                                <div class="flex items-center justify-center py-3 rounded-lg border-2 border-gray-200 bg-white hover:border-blue-500 transition-all peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700 font-semibold text-gray-700 text-sm">
                                    Rp 100.000
                                </div>
                            </label>
                            <label class="cursor-pointer relative">
                                <input type="radio" name="nominal_option" value="lainnya" class="peer sr-only nominal-radio" checked>
                                <div class="flex items-center justify-center py-3 rounded-lg border-2 border-gray-200 bg-white hover:border-blue-500 transition-all peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700 font-semibold text-gray-700 text-sm">
                                    Lainnya
                                </div>
                            </label>
                        </div>
                        <div class="nominal-manual-container space-y-2">
                            <label class="text-sm font-bold text-gray-800">
                                Nominal <span class="text-red-500">*</span>
                            </label>

                            <div class="flex rounded-lg border border-gray-300 bg-white overflow-hidden focus-within:outline-none focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-transparent transition-all duration-300">
                                <span class="inline-flex items-center px-4 bg-gray-100 border-r border-gray-300 text-sm font-medium text-gray-600 select-none">
                                    Rp
                                </span>
                                
                                <input type="text" 
                                    name="nominal_manual"
                                    class="nominal-manual w-full bg-transparent px-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none" 
                                    placeholder="Nominal">
                            </div>
                        </div>
                        <input type="hidden" name="nominal" class="nominal-hidden" value="{{ old('nominal') }}" required>
                        @error('nominal')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="space-y-3">
                        <label class="text-sm font-bold text-gray-800 block">
                            Pilih Metode Pembayaran <span class="text-red-500">*</span>
                        </label>
                        <div class="flex flex-col md:flex-row divide-y-2 md:divide-y-0 md:divide-x-2 divide-gray-200 payment-group">
                            <!-- QRIS -->
                            <div class="flex-1 flex flex-col items-center p-4">
                                <label class="payment-card rounded-lg cursor-pointer relative group flex flex-col items-center text-center bg-transparent" data-value="qris">
                                    <input type="radio" name="metode_pembayaran" value="qris" id="qris-logged-in" class="sr-only peer" required checked>
                                    <div class="relative rounded-xl p-3 transition-all bg-transparent">
                                        <div class="payment-overlay pointer-events-none absolute inset-0 flex items-center justify-center opacity-0 transition-opacity duration-200 peer-checked:opacity-100 bg-transparent">
                                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-green-500 shadow-lg">
                                                <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                </svg>
                                            </div>
                                        </div>
                                        <img src="{{ asset('images/qris-logo.png') }}" alt="QRIS" class="h-10 object-contain relative z-0 bg-transparent">
                                    </div>
                                </label>
                                <a href="{{ asset('images/qris-barcode.png') }}" download="QRIS-Panti-Asuhan-Mawar-Kasih.png" title="Klik untuk mengunduh QRIS">
                                    <img src="{{ asset('images/qris-barcode.png') }}" alt="QRIS Barcode" class="w-48 h-48 object-contain rounded-lg hover:shadow hover:shadow-green-400 transition">
                                </a>
                                <div class="mt-4 space-y-1 text-center">
                                    <p class="text-sm font-bold text-gray-800 uppercase tracking-wide">Panti Asuhan Mawar Kasih</p>
                                    <p class="text-xs font-semibold text-gray-500">NMID: ID84767348362832</p>
                                </div>
                            </div>
                            <!-- MANDIRI -->
                            <div class="flex-1 flex flex-col items-center p-4">
                                <label class="payment-card cursor-pointer relative group flex flex-col items-center" data-value="mandiri">
                                    <input type="radio" name="metode_pembayaran" value="mandiri" id="mandiri-logged-in" class="sr-only peer">
                                    <div class="relative rounded-xl p-3 transition-all bg-transparent">
                                        <div class="payment-overlay pointer-events-none absolute inset-0 flex items-center justify-center opacity-0 transition-opacity duration-200 peer-checked:opacity-100">
                                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-green-500 shadow-lg">
                                                <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                </svg>
                                            </div>
                                        </div>
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/a/ad/Bank_Mandiri_logo_2016.svg" alt="Mandiri" class="h-10 object-contain">
                                    </div>
                                </label>
                                <div class="w-48 h-48 flex items-center justify-center mt-2">
                                    <div class="text-center">
                                        <p class="text-xs text-gray-500 uppercase tracking-wide">Nomor Rekening</p>
                                        <p class="mt-2 font-bold text-gray-800 tracking-wider">143-00-2888931 7</p>
                                        <button type="button" onclick="salinNomorRekening('143-00-2888931 7')" class="mt-3 text-xs text-green-600 hover:text-green-700 font-medium flex items-center justify-center gap-1 mx-auto">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                            </svg>
                                            Salin No. Rekening
                                        </button>
                                    </div>
                                </div>
                                <div class="mt-4 space-y-1 text-center">
                                    <p class="text-sm font-bold text-gray-800 uppercase tracking-wide">BANK MANDIRI</p>
                                    <p class="text-xs font-semibold text-gray-500">a.n. Panti Asuhan Mawar Kasih</p>
                                </div>
                            </div>
                        </div>
                        @error('metode_pembayaran')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label class="text-sm font-bold text-gray-800 block mb-2">Bukti Transfer &nbsp; <span class="text-sm font-normal text-gray-400">(opsional)</span></label>
                        <input type="file" id="bukti_transfer_input_2" name="bukti_transfer" accept="image/*" class="w-full rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-200 file:text-gray-900 hover:file:bg-gray-300 cursor-pointer">
                        <div id="preview_container_2" class="mt-3 hidden">
                            <img id="bukti_transfer_preview_2" src="#" alt="Preview Bukti Transfer" class="max-h-48 w-auto rounded-lg object-cover border border-gray-200 shadow-sm">
                            <button type="button" id="remove_preview_2" class="mt-2 text-sm text-red-600 hover:text-red-700 font-medium focus:outline-none">Hapus Foto</button>
                        </div>
                        @error('bukti_transfer')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label class="text-sm font-bold text-gray-800 block mb-2">Keterangan / Doa</label>
                        <textarea 
                            name="keterangan" 
                            rows="3" 
                            class="w-full px-4 py-3 rounded-lg text-sm text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300" 
                            placeholder="Tuliskan doa atau pesan Anda (opsional)">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-6 flex items-start gap-2 text-sm text-amber-500 font-medium">
                        <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p>Pastikan seluruh data donasi telah diisi dengan benar sebelum mengirim formulir donasi.</p>
                    </div>

                    <div class="flex justify-center mt-6">
                        <button type="submit" class="inline-flex items-center gap-2 justify-center rounded-full bg-green-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-green-700">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z M17 21v-8H7v8 M7 3v5h8" />
                            </svg>
                            Kirim Donasi
                        </button>
                    </div>
                </form>
            </section>
        @endif
    </div>
</div>

<!-- Elemen Notifikasi Toast - Posisi Atas Tengah -->
<div id="toastNotifikasi" class="fixed top-6 left-1/2 -translate-x-1/2 flex items-center gap-2 bg-green-600 text-white px-5 py-3 rounded-lg shadow-lg transform transition-all duration-300 -translate-y-4 opacity-0 pointer-events-none z-50">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
    </svg>
    <span id="toastMessage" class="text-sm font-medium whitespace-nowrap">Berhasil!</span>
</div>

@section('extra_scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {

        // ────────────────────────────────────────────────
        // 1. Nominal handler
        // ────────────────────────────────────────────────
        const forms = document.querySelectorAll('form');

        forms.forEach(form => {
            const nominalRadios = form.querySelectorAll('.nominal-radio');
            const manualContainer = form.querySelector('.nominal-manual-container');
            const manualInput = form.querySelector('.nominal-manual');
            const hiddenInput = form.querySelector('.nominal-hidden');

            if (!manualInput) return;

            function formatRupiah(value) {
                if (!value) return '';
                return new Intl.NumberFormat('id-ID').format(value);
            }

            function updateNominal() {
                let selectedRadio = form.querySelector('.nominal-radio:checked');
                if (!selectedRadio) return;

                if (selectedRadio.value === 'lainnya') {
                    manualContainer.style.display = 'block';
                    let rawValue = manualInput.value.replace(/[^0-9]/g, '');
                    hiddenInput.value = rawValue;
                } else {
                    manualContainer.style.display = 'none';
                    hiddenInput.value = selectedRadio.value;
                }
            }

            nominalRadios.forEach(radio => {
                radio.addEventListener('change', updateNominal);
            });

            manualInput.addEventListener('input', function () {
                let rawValue = this.value.replace(/[^0-9]/g, '');
                this.value = formatRupiah(rawValue);
                updateNominal();
            });

            // Initialization
            if (hiddenInput.value && !['10000', '50000', '100000'].includes(hiddenInput.value)) {
                manualInput.value = formatRupiah(hiddenInput.value);
                let radio = form.querySelector('.nominal-radio[value="lainnya"]');
                if (radio) radio.checked = true;
            } else if (hiddenInput.value) {
                let radio = form.querySelector(`.nominal-radio[value="${hiddenInput.value}"]`);
                if (radio) radio.checked = true;
            }

            updateNominal();
        });

        // ────────────────────────────────────────────────
        // 2. Metode pembayaran – overlay + centang hijau
        // ────────────────────────────────────────────────
        function initPaymentCards(group) {
            const cards = group.querySelectorAll('.payment-card');

            function updateCards() {
                cards.forEach(card => {
                    const radio   = card.querySelector('input[type="radio"]');
                    const overlay = card.querySelector('.payment-overlay');
                    const imgs    = card.querySelectorAll('img');

                    if (radio && radio.checked) {
                        // Active: border hijau, gambar memudar, overlay+centang muncul
                        card.classList.add('border-green-500');
                        card.classList.remove('border-gray-200');
                        if (overlay) overlay.style.opacity = '1';
                        imgs.forEach(img => img.style.opacity = '0.35');
                    } else {
                        // Inactive: kembalikan ke normal
                        card.classList.remove('border-green-500');
                        card.classList.add('border-gray-200');
                        if (overlay) overlay.style.opacity = '0';
                        imgs.forEach(img => img.style.opacity = '1');
                    }
                });
            }

            cards.forEach(card => {
                card.addEventListener('click', () => {
                    const radio = card.querySelector('input[type="radio"]');
                    if (radio) {
                        radio.checked = true;
                        updateCards();
                    }
                });
            });

            // Init on load
            updateCards();
        }

        document.querySelectorAll('.payment-group').forEach(initPaymentCards);

        // Toast Notification Logic
        function showToast(message) {
            const toast = document.getElementById('toastNotifikasi');
            const toastMessage = document.getElementById('toastMessage');
            
            if (toast && toastMessage) {
                toastMessage.textContent = message;
                
                toast.classList.remove('-translate-y-4', 'opacity-0');
                toast.classList.add('translate-y-0', 'opacity-100');
                
                setTimeout(() => {
                    toast.classList.remove('translate-y-0', 'opacity-100');
                    toast.classList.add('-translate-y-4', 'opacity-0');
                }, 3000);
            }
        }

        window.salinNomorRekening = function(text) {
            navigator.clipboard.writeText(text).then(() => {
                showToast('Nomor rekening berhasil disalin!');
            }).catch(err => {
                console.error('Gagal menyalin: ', err);
            });
        };

        // Setup Image Preview
        function setupImagePreview(inputId, previewContainerId, previewImageId, removeButtonId) {
            const input = document.getElementById(inputId);
            const container = document.getElementById(previewContainerId);
            const image = document.getElementById(previewImageId);
            const removeBtn = document.getElementById(removeButtonId);

            if (!input || !container || !image || !removeBtn) return;

            input.addEventListener('change', function() {
                const file = this.files[0];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        image.src = e.target.result;
                        container.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                } else {
                    container.classList.add('hidden');
                    image.src = '#';
                }
            });

            removeBtn.addEventListener('click', function() {
                input.value = ''; // Reset input file
                container.classList.add('hidden');
                image.src = '#';
            });
        }

        setupImagePreview('bukti_transfer_input_1', 'preview_container_1', 'bukti_transfer_preview_1', 'remove_preview_1');
        setupImagePreview('bukti_transfer_input_2', 'preview_container_2', 'bukti_transfer_preview_2', 'remove_preview_2');
    });
</script>
@endsection

@endsection