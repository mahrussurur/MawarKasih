@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="px-8 pt-4 bg-gray-100 min-h-screen">
    
    <div class="mb-6">
        <h2 class="text-2xl font-extrabold text-slate-900">Selamat Datang, {{ Auth::user()->name }}!</h2>
        <p class="mt-1 text-sm font-medium text-slate-500">Ini adalah dashboard utama pengelolaan Yayasan Mawar Kasih.</p>
    </div>

    <div class="mb-6 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <div class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md">
            <div class="flex items-center gap-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-100 text-blue-600">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Total Anak Asuh</p>
                    <p class="mt-1 text-3xl font-extrabold text-slate-900">{{ $totalAnak ?? 0 }}</p>
                </div>
            </div>
            <a href="{{ route('anak-asuh.index') }}" class="mt-5 block w-full rounded-xl bg-blue-600 px-3 py-2.5 text-center text-sm font-bold text-white transition hover:bg-blue-700">Lihat Data</a>
        </div>

        <div class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md">
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
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Total Pengasuh</p>
                    <p class="mt-1 text-3xl font-extrabold text-slate-900">{{ $totalPengasuh ?? 0 }}</p>
                </div>
            </div>
            <a href="{{ route('pengasuh.index') }}" class="mt-5 block w-full rounded-xl bg-emerald-600 px-3 py-2.5 text-center text-sm font-bold text-white transition hover:bg-emerald-700">Lihat Data</a>
        </div>

        <div class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md">
            <div class="flex items-center gap-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-violet-100 text-violet-600">
                    <svg class="h-7 w-7" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><polyline points="16 11 18 13 22 9"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Total Donatur</p>
                    <p class="mt-1 text-3xl font-extrabold text-slate-900">{{ $totalDonatur ?? 0 }}</p>
                </div>
            </div>
            <a href="{{ route('donatur.index') }}" class="mt-5 block w-full rounded-xl bg-violet-600 px-3 py-2.5 text-center text-sm font-bold text-white transition hover:bg-violet-700">Lihat Data</a>
        </div>

        <div class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md">
            <div class="flex items-center gap-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-100 text-amber-600">
                    <svg class="h-7 w-7" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Total Kegiatan</p>
                    <p class="mt-1 text-3xl font-extrabold text-slate-900">{{ $totalKegiatan ?? 0 }}</p>
                </div>
            </div>
            <a href="{{ route('kegiatan.index') }}" class="mt-5 block w-full rounded-xl bg-amber-500 px-3 py-2.5 text-center text-sm font-bold text-white transition hover:bg-amber-600">Lihat Data</a>
        </div>
    </div>

    <div class="grid gap-5 lg:grid-cols-2">
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                <h3 class="text-base font-extrabold text-slate-900">Donasi Terbaru</h3>
                <a href="{{ route('donasi.index') }}" class="text-sm font-bold text-blue-600 hover:text-blue-700">Lihat semua →</a>
            </div>

            @if(isset($donasiTerbaru) && $donasiTerbaru->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-[11px] font-bold uppercase tracking-[0.12em] text-slate-400">Donatur</th>
                                <th class="px-4 py-3 text-left text-[11px] font-bold uppercase tracking-[0.12em] text-slate-400">Jumlah</th>
                                <th class="px-4 py-3 text-left text-[11px] font-bold uppercase tracking-[0.12em] text-slate-400">Tanggal</th>
                                <th class="px-4 py-3 text-left text-[11px] font-bold uppercase tracking-[0.12em] text-slate-400">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($donasiTerbaru as $donasi)
                            <tr class="border-t border-slate-100 hover:bg-slate-50/80">
                                <td class="px-4 py-3 text-sm font-bold text-slate-900">{{ $donasi->nama_donatur }}</td>
                                <td class="px-4 py-3 text-sm font-bold text-slate-900">Rp {{ number_format($donasi->jumlah, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-sm text-slate-600">{{ \Carbon\Carbon::parse($donasi->tanggal)->format('d M Y') }}</td>
                                <td class="px-4 py-3">
                                    @if($donasi->status === 'diterima')
                                        <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-1 text-[11px] font-bold text-emerald-700">Diterima</span>
                                    @elseif($donasi->status === 'pending')
                                        <span class="inline-flex rounded-full bg-amber-100 px-2.5 py-1 text-[11px] font-bold text-amber-700">Pending</span>
                                    @else
                                        <span class="inline-flex rounded-full bg-blue-100 px-2.5 py-1 text-[11px] font-bold text-blue-700">{{ $donasi->status }}</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="flex flex-col items-center justify-center px-6 py-12 text-slate-300">
                    <svg class="mb-3 h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    <p class="text-sm font-semibold text-slate-400">Belum ada data donasi terbaru</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
