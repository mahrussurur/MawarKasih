@extends('public.layouts.app')

@section('title', 'Profil Donatur')

@section('content')
<div class="min-h-screen bg-gray-50 py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Profil Donatur</h1>
                <p class="mt-2 text-sm text-gray-500">Lihat detail data Anda sebagai donatur tetap.</p>
            </div>
            <a href="{{ route('public.donasi.form') }}" class="inline-flex items-center gap-2 rounded-full bg-brand-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-brand-700">Donasi Sekarang</a>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="rounded-3xl border border-gray-200 bg-white p-8 shadow-sm">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Informasi Pribadi</h2>
                <div class="space-y-5 text-sm text-gray-700">
                    <div>
                        <p class="text-xs text-gray-500">Nama Lengkap</p>
                        <p class="mt-2 font-semibold text-gray-900">{{ $donatur->nama }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Email</p>
                        <p class="mt-2 font-semibold text-gray-900">{{ $donatur->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Nomor HP</p>
                        <p class="mt-2 font-semibold text-gray-900">{{ $donatur->no_hp }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Alamat</p>
                        <p class="mt-2 font-semibold text-gray-900">{{ $donatur->alamat }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Status Donatur</p>
                        <p class="mt-2 inline-flex rounded-full bg-green-100 px-3 py-1 text-sm font-semibold text-green-700">{{ ucfirst($donatur->status) }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl border border-gray-200 bg-white p-8 shadow-sm">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Aksi Cepat</h2>
                <div class="space-y-4">
                    <a href="{{ route('public.donatur.history') }}" class="block rounded-3xl border border-brand-600 bg-brand-50 px-5 py-4 text-sm font-semibold text-brand-700 transition hover:bg-brand-100">Lihat Riwayat Donasi</a>
                    <form action="{{ route('public.donatur.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full rounded-3xl bg-red-500 px-5 py-4 text-sm font-semibold text-white transition hover:bg-red-600">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
