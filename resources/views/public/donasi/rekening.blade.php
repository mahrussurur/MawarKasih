@extends('public.layouts.app')

@section('title', 'Rekening Donasi')

@section('content')
<div class="min-h-screen bg-gray-50 py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="rounded-3xl border border-gray-200 bg-white p-10 shadow-sm text-center">
            <h1 class="text-3xl font-bold text-gray-900">Rekening Donasi</h1>
            <p class="mt-4 text-sm text-gray-600">Silakan gunakan rekening resmi di bawah ini untuk melakukan transfer donasi.</p>
            <div class="mt-10 grid gap-6 sm:grid-cols-2">
                <div class="rounded-3xl border border-gray-200 bg-brand-50 p-6">
                    <p class="text-sm text-gray-500">Bank</p>
                    <p class="mt-2 text-xl font-semibold text-gray-900">BCA</p>
                    <p class="mt-1 text-sm text-gray-700">123-456-7890</p>
                    <p class="mt-1 text-sm text-gray-600">a.n. Panti Asuhan Mawar Kasih</p>
                </div>
                <div class="rounded-3xl border border-gray-200 bg-brand-50 p-6">
                    <p class="text-sm text-gray-500">Bank</p>
                    <p class="mt-2 text-xl font-semibold text-gray-900">Mandiri</p>
                    <p class="mt-1 text-sm text-gray-700">987-654-3210</p>
                    <p class="mt-1 text-sm text-gray-600">a.n. Panti Asuhan Mawar Kasih</p>
                </div>
            </div>
            <div class="mt-8">
                <a href="{{ route('public.donasi.form') }}" class="inline-flex rounded-full bg-brand-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-brand-700">Kembali ke Form Donasi</a>
            </div>
        </div>
    </div>
</div>
@endsection
