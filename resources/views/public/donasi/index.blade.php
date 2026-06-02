@extends('public.layouts.app')
@section('title', 'Donasi - Panti Asuhan Mawar Kasih')

@section('content')
@php
    $errorBag = $errors instanceof \Illuminate\Support\ViewErrorBag ? $errors : new \Illuminate\Support\ViewErrorBag();
@endphp
<div class="min-h-screen bg-gray-50 py-20">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-10 text-center">
            <!-- <span class="inline-flex items-center rounded-full bg-brand-50 px-4 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-brand-700">Formulir Donasi</span> -->
            <!-- <h1 class="mt-4 text-3xl font-bold text-gray-900">Pilih jalur donasi yang sesuai</h1> -->
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
                    <h2 class="mt-2 text-xl font-bold text-gray-900">Formulir Donasi</h2>
                </div>
                <p class="mt-4 text-sm leading-6 text-gray-600">Isi nama, nomor HP, dan email Anda yang sesuai agar donasi dapat dicatat secara aman.</p>

                <form action="{{ route('public.donasi.kirim') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-5">
                    @csrf
                    <input type="text" name="website" value="" autocomplete="off" tabindex="-1" class="hidden" aria-hidden="true">

                    <div>
                        <label class="text-sm font-semibold text-gray-700">Nama Donatur</label>
                        <input type="text" name="nama_donatur" value="{{ old('nama_donatur') }}" maxlength="255" placeholder="Masukkan Nama lengkap..." class="mt-2 w-full rounded-2xl border border-gray-300 px-4 py-3 text-sm text-gray-900 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100" required>
                        @error('nama_donatur')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" maxlength="255" placeholder="contoh@gmail.com" class="mt-2 w-full rounded-2xl border border-gray-300 px-4 py-3 text-sm text-gray-900 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100" required>
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
                        <p class="mt-2 text-xs text-gray-500">Contoh: Rp 10000</p>
                        @error('nominal')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-700 block mb-2">Metode Pembayaran</label>
                        <div class="grid grid-cols-3 gap-4">
                            
                            <!-- QRIS - Kotak Besar di Kiri -->
                            <label class="cursor-pointer relative">
                                <input type="radio" name="metode_pembayaran" value="qris" class="peer sr-only" required>
                                <div class="flex flex-col items-center justify-start h-full p-1 rounded-2xl border-2 border-gray-200 bg-white hover:border-brand-300 transition-all peer-checked:border-brand-500 peer-checked:bg-brand-50 peer-checked:ring-2 peer-checked:ring-brand-100" style="min-height: 280px;">
                                    <img src="{{ asset('images/qris-logo.png') }}" alt="QRIS" class="h-20 object-contain mb-4">
                                    <span class="text-sm font-semibold text-gray-700 peer-checked:text-brand-700">QRIS</span>
                                </div>
                            </label>
                            <!-- Container untuk 4 Bank (2x2 Grid) -->
                            <div class="col-span-2 grid grid-cols-2 gap-4">
                                
                                <!-- MANDIRI -->
                                <label class="cursor-pointer relative">
                                    <input type="radio" name="metode_pembayaran" value="mandiri" class="peer sr-only">
                                    <div class="flex flex-col items-center justify-center h-full p-5 rounded-2xl border-2 border-gray-200 bg-white hover:border-brand-300 transition-all peer-checked:border-brand-500 peer-checked:bg-brand-50 peer-checked:ring-2 peer-checked:ring-brand-100" style="min-height: 130px;">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/a/ad/Bank_Mandiri_logo_2016.svg" alt="Mandiri" class="h-10 object-contain mb-2">
                                    </div>
                                </label>

                                <!-- BCA -->
                                <label class="cursor-pointer relative">
                                    <input type="radio" name="metode_pembayaran" value="bca" class="peer sr-only">
                                    <div class="flex flex-col items-center justify-center h-full p-5 rounded-2xl border-2 border-gray-200 bg-white hover:border-brand-300 transition-all peer-checked:border-brand-500 peer-checked:bg-brand-50 peer-checked:ring-2 peer-checked:ring-brand-100" style="min-height: 130px;">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg" alt="BCA" class="h-10 object-contain mb-2">
                                    </div>
                                </label>

                                <!-- BNI -->
                                <label class="cursor-pointer relative">
                                    <input type="radio" name="metode_pembayaran" value="bni" class="peer sr-only">
                                    <div class="flex flex-col items-center justify-center h-full p-5 rounded-2xl border-2 border-gray-200 bg-white hover:border-brand-300 transition-all peer-checked:border-brand-500 peer-checked:bg-brand-50 peer-checked:ring-2 peer-checked:ring-brand-100" style="min-height: 130px;">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/e/e0/Bank_Negara_Indonesia_logo_%282004%29.svg" alt="BNI" class="h-10 object-contain mb-2">
                                    </div>
                                </label>

                                <!-- BRI -->
                                <label class="cursor-pointer relative">
                                    <input type="radio" name="metode_pembayaran" value="bri" class="peer sr-only">
                                    <div class="flex flex-col items-center justify-center h-full p-5 rounded-2xl border-2 border-gray-200 bg-white hover:border-brand-300 transition-all peer-checked:border-brand-500 peer-checked:bg-brand-50 peer-checked:ring-2 peer-checked:ring-brand-100" style="min-height: 130px;">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/6/68/BANK_BRI_logo.svg" alt="BRI" class="h-10 object-contain mb-2">
                                    </div>
                                </label>

                            </div>
                        </div>
                        @error('metode_pembayaran')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-700">Bukti Transfer</label>
                        <input type="file" name="bukti_transfer" accept="image/jpg, image/png, image/jpeg" class="mt-3 w-full rounded-2xl file:mr-4 file:py-2 file:px-4 file:rounded-2xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-[#1a56db] hover:file:bg-blue-100 cursor-pointer" required>
                        <p class="mt-2 text-xs text-gray-500">Format yang diterima: JPG, PNG. Maksimal 2 MB.</p>
                        @error('bukti_transfer')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="mt-4">
                        <label class="text-sm font-semibold text-gray-700 block mb-2">Keterangan / Doa</label>
                        <textarea name="keterangan" rows="3" class="w-full rounded-2xl border border-gray-300 px-4 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100" placeholder="Tuliskan doa atau pesan Anda (opsional)">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <label class="flex items-start gap-3 rounded-2xl bg-gray-50 px-4 py-3 text-sm text-gray-700">
                        <input type="checkbox" name="agree" value="1" class="mt-1 rounded border-gray-300 text-brand-600 focus:ring-brand-500" required>
                        <span>Saya menyetujui bahwa data yang saya kirimkan akan diproses untuk tujuan donasi dan verifikasi transfer.</span>
                    </label>
                    @error('agree')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror

                    <button type="submit" class="inline-flex w-full items-center justify-center rounded-full bg-brand-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-brand-700">Kirim Donasi</button>
                </form>
            </section>
        @else
            <section class="mx-auto max-w-3xl rounded-[28px] border border-brand-100 bg-white p-8 shadow-sm">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h2 class="mt-2 text-xl font-bold text-gray-900">Formulir Donasi</h2>
                    </div>
                </div>
                <p class="mt-4 text-sm leading-6 text-gray-600">Data profil Anda akan digunakan otomatis. Isi nominal dan upload bukti transfer yang sesuai !</p>

                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    <div class="rounded-2xl bg-gray-100 p-4">
                        <p class="text-xs uppercase tracking-[0.2em] text-gray-500">Nama</p>
                        <p class="mt-2 text-sm font-semibold text-gray-900">{{ $donatur->nama }}</p>
                    </div>
                    <div class="rounded-2xl bg-gray-100 p-4">
                        <p class="text-xs uppercase tracking-[0.2em] text-gray-500">Email</p>
                        <p class="mt-2 text-sm font-semibold text-gray-900">{{ $donatur->email }}</p>
                    </div>
                    <div class="rounded-2xl bg-gray-100 p-4">
                        <p class="text-xs uppercase tracking-[0.2em] text-gray-500">No. HP</p>
                        <p class="mt-2 text-sm font-semibold text-gray-900">{{ $donatur->no_hp }}</p>
                    </div>
                    <div class="rounded-2xl bg-gray-100 p-4">
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
                        <label class="text-sm font-semibold text-gray-700 block mb-2">Metode Pembayaran</label>
                        <div class="grid grid-cols-3 gap-4">
                            
                            <!-- QRIS - Kotak Besar di Kiri -->
                            <label class="cursor-pointer relative">
                                <input type="radio" name="metode_pembayaran" value="qris" class="peer sr-only" required>
                                <div class="flex flex-col items-center justify-start h-full p-1 rounded-2xl border-2 border-gray-200 bg-white hover:border-brand-300 transition-all peer-checked:border-brand-500 peer-checked:bg-brand-50 peer-checked:ring-2 peer-checked:ring-brand-100" style="min-height: 280px;">
                                    <img src="{{ asset('images/qris-logo.png') }}" alt="QRIS" class="h-20 object-contain mb-4">
                                    <span class="text-sm font-semibold text-gray-700 peer-checked:text-brand-700">QRIS</span>
                                </div>
                            </label>
                            <!-- Container untuk 4 Bank (2x2 Grid) -->
                            <div class="col-span-2 grid grid-cols-2 gap-4">
                                
                                <!-- MANDIRI -->
                                <label class="cursor-pointer relative">
                                    <input type="radio" name="metode_pembayaran" value="mandiri" class="peer sr-only">
                                    <div class="flex flex-col items-center justify-center h-full p-5 rounded-2xl border-2 border-gray-200 bg-white hover:border-brand-300 transition-all peer-checked:border-brand-500 peer-checked:bg-brand-50 peer-checked:ring-2 peer-checked:ring-brand-100" style="min-height: 130px;">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/a/ad/Bank_Mandiri_logo_2016.svg" alt="Mandiri" class="h-10 object-contain mb-2">
                                    </div>
                                </label>

                                <!-- BCA -->
                                <label class="cursor-pointer relative">
                                    <input type="radio" name="metode_pembayaran" value="bca" class="peer sr-only">
                                    <div class="flex flex-col items-center justify-center h-full p-5 rounded-2xl border-2 border-gray-200 bg-white hover:border-brand-300 transition-all peer-checked:border-brand-500 peer-checked:bg-brand-50 peer-checked:ring-2 peer-checked:ring-brand-100" style="min-height: 130px;">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg" alt="BCA" class="h-10 object-contain mb-2">
                                    </div>
                                </label>

                                <!-- BNI -->
                                <label class="cursor-pointer relative">
                                    <input type="radio" name="metode_pembayaran" value="bni" class="peer sr-only">
                                    <div class="flex flex-col items-center justify-center h-full p-5 rounded-2xl border-2 border-gray-200 bg-white hover:border-brand-300 transition-all peer-checked:border-brand-500 peer-checked:bg-brand-50 peer-checked:ring-2 peer-checked:ring-brand-100" style="min-height: 130px;">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/e/e0/Bank_Negara_Indonesia_logo_%282004%29.svg" alt="BNI" class="h-10 object-contain mb-2">
                                    </div>
                                </label>

                                <!-- BRI -->
                                <label class="cursor-pointer relative">
                                    <input type="radio" name="metode_pembayaran" value="bri" class="peer sr-only">
                                    <div class="flex flex-col items-center justify-center h-full p-5 rounded-2xl border-2 border-gray-200 bg-white hover:border-brand-300 transition-all peer-checked:border-brand-500 peer-checked:bg-brand-50 peer-checked:ring-2 peer-checked:ring-brand-100" style="min-height: 130px;">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/6/68/BANK_BRI_logo.svg" alt="BRI" class="h-10 object-contain mb-2">
                                    </div>
                                </label>

                            </div>
                        </div>
                        @error('metode_pembayaran')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label class="text-sm font-semibold text-gray-700 block mb-2">Keterangan / Doa</label>
                        <textarea name="keterangan" rows="3" class="w-full rounded-2xl border border-gray-300 px-4 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100" placeholder="Tuliskan doa atau pesan Anda (opsional)">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-700">Bukti Transfer</label>
                        <input type="file" name="bukti_transfer" accept="image/jpg, image/png,image/jpeg,image" class="mt-3 w-full rounded-2xl file:mr-4 file:py-2 file:px-4 file:rounded-2xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-[#1a56db] hover:file:bg-blue-100 cursor-pointer" required>
                        <p class="mt-2 text-xs text-gray-500">Format yang diterima: JPG, PNG, JPEG. Maksimal 2 MB.</p>
                        @error('bukti_transfer')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <label class="flex items-start gap-3 rounded-2xl bg-white px-4 py-3 text-sm text-gray-700">
                        <input type="checkbox" name="agree" value="1" class="mt-1 rounded border-gray-300 text-brand-600 focus:ring-brand-500" required>
                        <span>Saya menyetujui bahwa data yang saya kirimkan akan diproses untuk tujuan donasi dan verifikasi transfer.</span>
                    </label>
                    @error('agree')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror

                    <button type="submit" class="inline-flex w-full items-center justify-center rounded-full bg-brand-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-brand-700">Kirim Donasi</button>
                </form>
            </section>
        @endif
    </div>
</div>
@endsection
