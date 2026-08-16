@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div>
    
    <div class="mb-6">
        <h2 class="text-2xl font-extrabold text-gray-900">Selamat Datang, {{ Auth::user()->name }}!</h2>
        <p class="mt-1 text-sm font-medium text-gray-500">Ini adalah dashboard utama pengelolaan Yayasan Mawar Kasih.</p>
    </div>

    <div class="mb-6 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <!-- total anak asuh -->
        <div class="group rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md">
            <div class="flex items-center gap-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-100 text-blue-600">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-gray-500">Total Anak Asuh</p>
                    <p class="mt-1 text-3xl font-extrabold text-gray-900">{{ $totalAnak ?? 0 }}</p>
                </div>
            </div>
            <a href="{{ route('anak-asuh.index') }}" class="mt-5 block w-full rounded-xl bg-blue-600 px-3 py-2.5 text-center text-sm font-bold text-white transition hover:bg-blue-700">Lihat Data</a>
        </div>

        <!-- total pengasuh -->
        <div class="group rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md">
            <div class="flex items-center gap-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-600">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-gray-500">Total Pengasuh</p>
                    <p class="mt-1 text-3xl font-extrabold text-gray-900">{{ $totalPengasuh ?? 0 }}</p>
                </div>
            </div>
            <a href="{{ route('pengasuh.index') }}" class="mt-5 block w-full rounded-xl bg-emerald-600 px-3 py-2.5 text-center text-sm font-bold text-white transition hover:bg-emerald-700">Lihat Data</a>
        </div>

        <!-- total donatur -->
        <div class="group rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md">
            <div class="flex items-center gap-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-violet-100 text-violet-600">
                    <svg class="h-7 w-7" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><polyline points="16 11 18 13 22 9"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-gray-500">Total Donatur</p>
                    <p class="mt-1 text-3xl font-extrabold text-gray-900">{{ $totalDonatur ?? 0 }}</p>
                </div>
            </div>
            <a href="{{ route('donatur.index') }}" class="mt-5 block w-full rounded-xl bg-violet-600 px-3 py-2.5 text-center text-sm font-bold text-white transition hover:bg-violet-700">Lihat Data</a>
        </div>

        <!-- total kegiatan -->
        <div class="group rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md">
            <div class="flex items-center gap-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-100 text-amber-600">
                    <svg class="h-7 w-7" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-gray-500">Total Kegiatan</p>
                    <p class="mt-1 text-3xl font-extrabold text-gray-900">{{ $totalKegiatan ?? 0 }}</p>
                </div>
            </div>
            <a href="{{ route('kegiatan.index') }}" class="mt-5 block w-full rounded-xl bg-amber-500 px-3 py-2.5 text-center text-sm font-bold text-white transition hover:bg-amber-600">Lihat Data</a>
        </div>
    </div>

    <div class="grid gap-5">
    <div class="grid gap-5">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6">
            <div class="flex flex-col gap-4 border-b border-gray-200 pb-4 mb-4 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex items-center gap-3">
                    <h3 class="text-base font-extrabold text-gray-900">Donasi Terbaru</h3>
                    @if(isset($totalDonasiPending) && $totalDonasiPending > 0)
                        <span class="inline-flex items-center justify-center rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-bold text-amber-800">
                            {{ $totalDonasiPending }} Pending
                        </span>
                    @endif
                </div>
                <a href="{{ route('donasi.index') }}" class="text-sm font-bold text-blue-600 hover:text-blue-700">Lihat semua →</a>
            </div>

            @if(isset($donasiTerbaru) && $donasiTerbaru->count() > 0)
<div class="overflow-x-auto custom-scrollbar">
    <table class="w-full text-left text-sm whitespace-nowrap">
        <thead class="border-b border-gray-200 bg-gray-50">
            <tr>
                <th class="px-4 py-2.5 font-semibold text-gray-700">
                    Tanggal & Waktu
                </th>
                <th class="px-4 py-2.5 font-semibold text-gray-700">
                    Donatur
                </th>
                <th class="px-4 py-2.5 font-semibold text-gray-700">
                    Jumlah
                </th>
                <th class="px-4 py-2.5 font-semibold text-gray-700">
                    Metode
                </th>
                <th class="px-4 py-2.5 text-center font-semibold text-gray-700">
                    Bukti
                </th>
                <th class="sticky right-0 z-10 bg-gray-50 px-4 py-2.5 text-center font-semibold text-gray-700 shadow-[inset_1px_0_0_#e5e7eb]">
                    Aksi
                </th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-100">
            @foreach($donasiTerbaru as $donasi)
                <tr class="group transition-colors hover:bg-gray-50">

                    {{-- Tanggal & Waktu --}}
                    <td class="px-4 py-2.5 text-gray-700">
                        {{ $donasi->created_at
                            ? $donasi->created_at->format('d M Y, H:i')
                            : \Carbon\Carbon::parse($donasi->tanggal)->format('d M Y')
                        }}
                    </td>

                    {{-- Donatur --}}
                    <td class="px-4 py-2.5 font-semibold text-gray-900">
                        {{ $donasi->nama_donatur }}
                    </td>

                    {{-- Jumlah --}}
                    <td class="px-4 py-2.5 font-semibold text-gray-900">
                        Rp {{ number_format($donasi->nominal, 0, ',', '.') }}
                    </td>

                    {{-- Metode --}}
                    <td class="px-4 py-2.5 text-gray-700">
                        {{ $donasi->metode_pembayaran }}
                    </td>

                    {{-- Bukti Transfer --}}
                    <td class="px-4 py-2.5 text-center">
                        @if($donasi->bukti_transfer)
                            <button
                                type="button"
                                class="inline-flex"
                                onclick="openImagePreview('{{ asset('storage/' . $donasi->bukti_transfer) }}')"
                                aria-label="Perbesar bukti transfer"
                            >
                                <img
                                    src="{{ asset('storage/' . $donasi->bukti_transfer) }}"
                                    class="h-10 w-10 cursor-pointer rounded border border-gray-200 object-cover transition duration-200 hover:scale-105"
                                    alt="Bukti transfer"
                                    title="Klik untuk memperbesar"
                                >
                            </button>
                        @else
                            <span class="font-medium text-gray-400">-</span>
                        @endif
                    </td>

                    {{-- Aksi --}}
                    <td class="sticky right-0 z-10 bg-white px-4 py-2.5 text-center shadow-[inset_1px_0_0_#e5e7eb] transition-colors group-hover:bg-gray-50">
                        <div class="flex justify-center gap-1">

                            {{-- Terima --}}
                            <button
                                type="button"
                                class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700 transition hover:bg-emerald-600 hover:text-white"
                                title="Terima"
                                data-validasi-route="{{ route('donasi.validasi', $donasi->id) }}"
                                data-kode-donasi="{{ $donasi->kode_donasi }}"
                                onclick="openValidasiModal(this)"
                            >
                                <svg
                                    class="h-3.5 w-3.5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2.5"
                                        d="M5 13l4 4L19 7"
                                    />
                                </svg>
                            </button>

                            {{-- Tolak --}}
                            <button
                                type="button"
                                class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-red-100 text-red-700 transition hover:bg-red-600 hover:text-white"
                                title="Tolak"
                                data-tolak-route="{{ route('donasi.tolak', $donasi->id) }}"
                                data-kode-donasi="{{ $donasi->kode_donasi }}"
                                onclick="openTolakModal(this)"
                            >
                                <svg
                                    class="h-3.5 w-3.5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2.5"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>

                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>            @else
                <div class="flex min-h-[200px] flex-col items-center justify-center gap-3 px-6 py-10 text-center text-gray-500">
                    <p class="text-sm font-semibold text-gray-900">Belum ada data donasi terbaru</p>
                </div>
            @endif
        </div>
        </div>
    </div>
</div>

@endsection

@push('modals')
    @include('admin.partials.donasi_action_modals')
@endpush
