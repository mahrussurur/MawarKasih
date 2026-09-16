@extends('public.layouts.app')

@section('title', 'Profil Donatur')

@section('content')
@include('public.components.page-header', ['title' => 'Profil Donatur'])
<div class="bg-gray-50 py-10 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">

        <div class="rounded-3xl border border-gray-200 bg-white p-6 sm:p-8 md:p-10 shadow-sm">
            <h2 class="text-xl font-bold text-gray-900 mb-8 pb-4 border-b border-gray-100">Informasi Pribadi</h2>
            
            <div class="flex flex-col md:flex-row gap-8 items-center md:items-start">

                <!-- Kiri: Icon Person & Status & Tombol Aksi -->
                <div class="flex flex-col items-center gap-3 flex-shrink-0 w-full md:w-48">
                    <div class="w-32 h-32 md:w-40 md:h-40 rounded-2xl bg-gradient-to-br from-blue-50 to-slate-100 border border-slate-200 shadow-sm flex items-center justify-center">
                        <svg class="w-16 h-16 md:w-20 md:h-20 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                    </div>
                    
                    <div class="text-center">
                        <h3 class="text-base md:text-lg font-bold text-gray-900 block truncate max-w-[220px]" title="{{ $donatur->nama }}">
                            {{ \Illuminate\Support\Str::words($donatur->nama, 2, '') }}
                        </h3>
                        <span class="inline-block mt-1.5 px-3 py-1 rounded-full text-xs font-semibold {{ strtolower($donatur->status) == 'aktif' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                            {{ ucfirst($donatur->status) }}
                        </span>
                    </div>

                    <!-- Tombol Aksi (Mobile: Kanan Kiri / Desktop: Atas Bawah) -->
                    <div class="w-full flex flex-row md:flex-col gap-2.5 mt-2">
                        <button type="button" class="flex-1 w-full inline-flex items-center justify-center gap-1.5 rounded-xl bg-brand-600 px-3.5 py-2.5 text-xs font-semibold text-white shadow-sm transition hover:bg-brand-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            <span>Edit Profil</span>
                        </button>
                        
                        <a href="{{ route('public.donatur.history') }}" class="flex-1 w-full inline-flex items-center justify-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-xs font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 hover:border-slate-300 text-center">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Riwayat Donasi</span>
                        </a>
                    </div>
                </div>

                <!-- Divider vertikal (desktop) / horizontal (mobile) -->
                <div class="hidden md:block w-px self-stretch bg-gray-100 my-2"></div>
                <div class="md:hidden w-full h-px bg-gray-100 my-2"></div>

                <!-- Kanan: Detail Data Donatur -->
                <div class="w-full flex-grow space-y-4">
                    <div class="rounded-xl bg-gray-50 border border-gray-100 p-4 min-w-0">
                        <p class="text-xs uppercase tracking-[0.15em] text-gray-400 font-semibold">Nama Lengkap</p>
                        <p class="mt-1.5 text-sm font-semibold text-gray-900 break-all">{{ $donatur->nama }}</p>
                    </div>
                    
                    <div class="rounded-xl bg-gray-50 border border-gray-100 p-4 min-w-0">
                        <p class="text-xs uppercase tracking-[0.15em] text-gray-400 font-semibold">Email</p>
                        <p class="mt-1.5 text-sm font-semibold text-gray-900 break-all">{{ $donatur->email }}</p>
                    </div>

                    <div class="rounded-xl bg-gray-50 border border-gray-100 p-4 min-w-0">
                        <p class="text-xs uppercase tracking-[0.15em] text-gray-400 font-semibold">No. Telepon / HP</p>
                        <p class="mt-1.5 text-sm font-semibold text-gray-900 break-all">{{ $donatur->no_hp }}</p>
                    </div>

                    <div class="rounded-xl bg-gray-50 border border-gray-100 p-4 min-w-0">
                        <p class="text-xs uppercase tracking-[0.15em] text-gray-400 font-semibold">Alamat</p>
                        <p class="mt-1.5 text-sm font-semibold text-gray-900 break-all">{{ $donatur->alamat }}</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
