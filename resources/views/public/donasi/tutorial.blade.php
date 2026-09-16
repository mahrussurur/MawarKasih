@extends('public.layouts.app')

@section('title', 'Tutorial Donasi')

@section('content')
<div class="bg-gray-50 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="rounded-3xl border border-gray-200 bg-white p-10 shadow-sm">
            <h1 class="text-3xl font-bold text-gray-900">Tutorial Donasi</h1>
            <p class="mt-4 text-sm text-gray-600">Ikuti langkah sederhana ini untuk menyelesaikan donasi Anda.</p>
            <div class="mt-8 space-y-6 text-sm text-gray-700">
                <div>
                    <h2 class="font-semibold text-gray-900">1. Pilih Nominal</h2>
                    <p class="mt-2">Masukkan jumlah donasi yang ingin Anda berikan di halaman Form Donasi.</p>
                </div>
                <div>
                    <h2 class="font-semibold text-gray-900">2. Transfer ke Rekening</h2>
                    <p class="mt-2">Gunakan rekening resmi yang ada di halaman Rekening Donasi.</p>
                </div>
                <div>
                    <h2 class="font-semibold text-gray-900">3. Unggah Bukti Transfer</h2>
                    <p class="mt-2">Simpan bukti transfer Anda lalu unggah di form donasi.</p>
                </div>
                <div>
                    <h2 class="font-semibold text-gray-900">4. Tunggu Validasi</h2>
                    <p class="mt-2">Admin akan memeriksa bukti transfer dan memperbarui status donasi Anda.</p>
                </div>
            </div>
            <div class="mt-8">
                <a href="{{ route('public.donasi.form') }}" class="inline-flex rounded-full bg-brand-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-brand-700">Kembali ke Form Donasi</a>
            </div>
        </div>
    </div>
</div>
@endsection
