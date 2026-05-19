@extends('public.layouts.app')

@section('title', 'Login Donatur')

@section('content')
<div class="min-h-screen bg-gray-50 py-20">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="rounded-3xl border border-gray-200 bg-white p-10 shadow-sm">
            <div class="text-center mb-10">
                <h1 class="text-3xl font-bold text-gray-900">Login Donatur</h1>
                <p class="mt-3 text-sm text-gray-500">Masuk dengan email dan password yang Anda gunakan saat registrasi.</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 rounded-3xl border border-red-200 bg-red-50 p-5 text-sm text-red-700">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('public.donasi.login.submit') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="mt-3 w-full rounded-3xl border border-gray-300 px-4 py-4 text-sm text-gray-900 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100" placeholder="alamat email Anda" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700">Password</label>
                    <input type="password" name="password" class="mt-3 w-full rounded-3xl border border-gray-300 px-4 py-4 text-sm text-gray-900 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100" placeholder="Kata sandi" required>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <a href="{{ route('public.donasi.registrasi') }}" class="inline-flex items-center justify-center rounded-full border border-gray-300 bg-white px-6 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-100">Belum punya akun?</a>
                    <button type="submit" class="inline-flex items-center justify-center rounded-full bg-brand-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-brand-700">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
