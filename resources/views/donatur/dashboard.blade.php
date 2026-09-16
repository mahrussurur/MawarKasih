@extends('layouts.app')

@section('title', 'Dashboard Donatur')
@section('page-title', 'Dashboard')

@section('content')
<div>
    <div class="mb-6">
        <p class="mt-1 text-sm font-medium text-gray-500">Terima kasih atas donasi dan kebaikan Anda.</p>
    </div>
    
    <div class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 mb-6">
        <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Total Nominal Donasi</p>
                <p class="text-xl font-bold text-gray-900">Rp {{ number_format($totalNominal, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-blue-100 text-blue-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Frekuensi Donasi</p>
                <p class="text-xl font-bold text-gray-900">{{ $totalDonasi }} Kali</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4 border-b border-gray-100 pb-4">
            <h3 class="text-lg font-bold text-gray-900">Riwayat Donasi Terbaru</h3>
            <a href="{{ route('donatur.donasi.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700">Lihat Semua →</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-4 py-3 font-semibold text-gray-600">Kode</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Tanggal</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Nominal</th>
                        <th class="px-4 py-3 font-semibold text-gray-600 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($donasiTerbaru as $donasi)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $donasi->kode_donasi }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ \Carbon\Carbon::parse($donasi->tanggal)->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-gray-900 font-semibold">{{ $donasi->nominal_rupiah }}</td>
                            <td class="px-4 py-3 text-center">
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-amber-100 text-amber-800',
                                        'diterima' => 'bg-emerald-100 text-emerald-800',
                                        'ditolak' => 'bg-red-100 text-red-800',
                                    ];
                                @endphp
                                <span class="inline-flex items-center rounded-full px-3 py-1 text-[11px] font-semibold {{ $statusClasses[$donasi->status] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ ucfirst($donasi->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-gray-500">Belum ada donasi yang tercatat</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
