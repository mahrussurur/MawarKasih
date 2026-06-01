@extends('public.layouts.app')

@section('title', 'Validasi Donasi')

@section('content')
<div class="min-h-screen bg-gray-50 py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="rounded-3xl border border-gray-200 bg-white p-10 shadow-sm text-center">
            <h1 class="text-3xl font-bold text-gray-900">Validasi Donasi</h1>
            <p class="mt-4 text-sm text-gray-600">Masukkan kode donasi Anda untuk memeriksa status validasi.</p>
            <form action="#" method="GET" class="mt-8 space-y-5">
                <div>
                    <input type="text" name="kode_donasi" placeholder="Masukkan kode donasi" class="w-full rounded-3xl border border-gray-300 px-4 py-4 text-sm text-gray-900 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100" required>
                </div>
                <div>
                    <button type="submit" class="inline-flex rounded-full bg-brand-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-brand-700">Cek Status</button>
                </div>
            </form>
            <div class="mt-8">
                <a href="{{ route('public.donasi.form') }}" class="inline-flex rounded-full bg-gray-100 px-6 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-200">Kembali ke Form Donasi</a>
            </div>
        </div>
    </div>
</div>
@endsection
