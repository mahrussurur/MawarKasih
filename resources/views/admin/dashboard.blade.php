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
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4">
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
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-[11px] font-bold uppercase tracking-[0.12em] text-gray-400">Tanggal & Waktu</th>
                                <th class="px-4 py-3 text-left text-[11px] font-bold uppercase tracking-[0.12em] text-gray-400">Donatur</th>
                                <th class="px-4 py-3 text-left text-[11px] font-bold uppercase tracking-[0.12em] text-gray-400">Jumlah</th>
                                <th class="px-4 py-3 text-left text-[11px] font-bold uppercase tracking-[0.12em] text-gray-400">Metode</th>
                                <th class="px-4 py-3 text-left text-[11px] font-bold uppercase tracking-[0.12em] text-gray-400">Bukti</th>
                                <th class="px-4 py-3 text-left text-[11px] font-bold uppercase tracking-[0.12em] text-gray-400">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($donasiTerbaru as $donasi)
                            <tr class="border-t border-gray-100 hover:bg-gray-50/80">
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $donasi->created_at ? $donasi->created_at->format('d M Y, H:i') : \Carbon\Carbon::parse($donasi->tanggal)->format('d M Y') }}</td>
                                <td class="px-4 py-3 text-sm font-bold text-gray-900">{{ $donasi->nama_donatur }}</td>
                                <td class="px-4 py-3 text-sm font-bold text-gray-900">Rp {{ number_format($donasi->nominal, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $donasi->metode_pembayaran }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">
                                    @if($donasi->bukti_transfer)
                                        <button type="button" onclick="openImagePreview('{{ asset('storage/' . $donasi->bukti_transfer) }}')" class="text-blue-600 hover:underline">Lihat Bukti</button>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-2">
                                        <button type="button"
                                                class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600 transition hover:bg-emerald-600 hover:text-white"
                                                title="Terima"
                                                data-validasi-route="{{ route('donasi.validasi', $donasi->id) }}"
                                                data-kode-donasi="{{ $donasi->kode_donasi }}"
                                                onclick="openValidasiModal(this)">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </button>
                                        <button type="button"
                                                class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-100 text-red-600 transition hover:bg-red-600 hover:text-white"
                                                title="Tolak"
                                                data-tolak-route="{{ route('donasi.tolak', $donasi->id) }}"
                                                data-kode-donasi="{{ $donasi->kode_donasi }}"
                                                onclick="openTolakModal(this)">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="flex flex-col items-center justify-center px-6 py-12 text-gray-300">
                    <p class="text-sm font-semibold text-gray-400">Belum ada data donasi terbaru</p>
                </div>
            @endif
        </div>
    </div>
</div>

@include('admin.partials.donasi_action_modals')
@endsection
