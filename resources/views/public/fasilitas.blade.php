@extends('public.layouts.app')

@section('title', 'Fasilitas')

@section('content')
<div class="min-h-screen bg-gray-50 py-20">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="rounded-3xl border border-gray-200 bg-white p-10 shadow-sm text-center">
            <h1 class="text-3xl font-bold text-gray-900">Fasilitas</h1>
            <p class="mt-4 text-sm text-gray-600">Halaman fasilitas sedang dalam pengembangan. Informasi fasilitas akan ditampilkan di sini.</p>
            <div class="mt-8">
                <a href="{{ route('public.home') }}" class="inline-flex rounded-full bg-brand-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-brand-700">Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</div>
@endsection