@extends('layouts.app')

@section('title', 'Dashboard Donatur')
@section('page-title', 'Dashboard')

@section('content')
<div>
    <div class="mb-6">
        <h2 class="text-2xl font-extrabold text-gray-900">Selamat Datang, {{ Auth::user()->nama }}!</h2>
        <p class="mt-1 text-sm font-medium text-gray-500">Pantau riwayat dan statistik donasi Anda di sini.</p>
    </div>

    <!-- Summary Cards -->
    <h3 class="text-lg font-bold text-gray-900 mb-3 mt-8">Ringkasan Donasi Anda</h3>
    <div class="mb-8 grid gap-4 md:grid-cols-3">
        <!-- Total Nominal Donasi -->
        <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm hover:-translate-y-0.5 hover:shadow-md transition duration-200">
            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-gray-500">Total Nominal Donasi</p>
                <p class="text-xl font-bold text-gray-900">Rp {{ number_format($totalNominal, 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Nominal Donasi Bulan Ini -->
        <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm hover:-translate-y-0.5 hover:shadow-md transition duration-200">
            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-blue-100 text-blue-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-gray-500">Donasi Bulan Ini</p>
                <p class="text-xl font-bold text-gray-900">Rp {{ number_format($nominalBulanIni, 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Frekuensi Donasi -->
        <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-gradient-to-br from-blue-500 to-blue-600 p-5 shadow-sm hover:-translate-y-0.5 hover:shadow-md transition duration-200">
            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-white/20 text-white">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-blue-100">Frekuensi Donasi</p>
                <p class="text-xl font-bold text-white">{{ $totalDonasi }} Kali</p>
            </div>
        </div>
    </div>

    <div class="grid gap-5">
        <!-- Riwayat Donasi Terbaru (diterima / ditolak) -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6">
            <div class="flex flex-col gap-4 border-b border-gray-200 pb-4 lg:flex-row lg:items-center lg:justify-between">
                <h3 class="text-base font-extrabold text-gray-900">Riwayat Donasi Terbaru</h3>
                <a href="{{ route('donatur.donasi.index') }}" class="text-sm font-bold text-blue-600 hover:text-blue-700">Lihat semua →</a>
            </div>

            @if($donasiTerbaru->count() > 0)
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="border-b border-gray-200 bg-gray-50">
                        <tr>
                            <th class="px-4 py-2.5 font-semibold text-gray-700">Tanggal</th>
                            <th class="px-4 py-2.5 font-semibold text-gray-700">Kode Donasi</th>
                            <th class="px-4 py-2.5 font-semibold text-gray-700">Nominal</th>
                            <th class="px-4 py-2.5 font-semibold text-gray-700">Metode</th>
                            <th class="px-4 py-2.5 text-center font-semibold text-gray-700">Status</th>
                            <th class="px-4 py-2.5 text-center font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($donasiTerbaru as $donasi)
                        <tr class="transition-colors hover:bg-gray-50">
                            <td class="px-4 py-2.5 text-gray-700">
                                {{ \Carbon\Carbon::parse($donasi->tanggal)->format('d M Y') }}
                            </td>
                            <td class="px-4 py-2.5 font-semibold text-gray-900">{{ $donasi->kode_donasi }}</td>
                            <td class="px-4 py-2.5 font-semibold text-gray-900">{{ $donasi->nominal_rupiah }}</td>
                            <td class="px-4 py-2.5 text-gray-700">{{ ucfirst($donasi->metode_pembayaran ?? '-') }}</td>
                            <td class="px-4 py-2.5 text-center">
                                @php
                                    $sc = [
                                        'diterima' => 'bg-emerald-100 text-emerald-800',
                                        'ditolak'  => 'bg-red-100 text-red-800',
                                    ];
                                @endphp
                                <span class="inline-flex rounded-md px-2 py-1 text-xs font-semibold {{ $sc[$donasi->status] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ ucfirst($donasi->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2.5 text-center">
                                <a href="{{ route('donatur.donasi.show', $donasi->id) }}"
                                   class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-blue-400 bg-blue-50 text-blue-600 transition hover:bg-blue-600 hover:text-white"
                                   title="Lihat Detail">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="flex min-h-[200px] flex-col items-center justify-center gap-3 px-6 py-10 text-center text-gray-500">
                <p class="text-sm font-semibold text-gray-900">Belum ada donasi yang selesai diproses</p>
                <span class="text-sm">Donasi yang diterima atau ditolak akan tampil di sini.</span>
            </div>
            @endif
        </div>

        <!-- Grafik Nominal Donasi Diterima Per Bulan -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 border-b border-gray-100 pb-4 mb-6">
                <h3 class="text-base font-bold text-gray-900">Jumlah Donasi ({{ date('Y') }})</h3>
            </div>
            <div class="relative w-full h-[280px]">
                <canvas id="monthlyDonationChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctxDonation = document.getElementById('monthlyDonationChart').getContext('2d');

        const gradientDonation = ctxDonation.createLinearGradient(0, 0, 0, 300);
        gradientDonation.addColorStop(0, 'rgba(59, 130, 246, 0.35)');
        gradientDonation.addColorStop(1, 'rgba(59, 130, 246, 0.0)');

        new Chart(ctxDonation, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Nominal Diterima',
                    data: @json($donasiPerBulan),
                    borderColor: '#3b82f6',
                    borderWidth: 3,
                    backgroundColor: gradientDonation,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointHoverRadius: 7,
                    pointBackgroundColor: '#3b82f6',
                    pointHoverBackgroundColor: '#1d4ed8',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { intersect: false, mode: 'index' },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: { family: "'Inter', sans-serif", size: 11 },
                            color: '#9ca3af',
                            callback: function(value) {
                                if (value >= 1000000000) return 'Rp ' + (value / 1000000000).toFixed(1).replace(/\.0$/, '') + ' M';
                                if (value >= 1000000)    return 'Rp ' + (value / 1000000).toFixed(1).replace(/\.0$/, '') + ' Jt';
                                if (value >= 1000)       return 'Rp ' + (value / 1000).toFixed(0) + ' Rb';
                                return 'Rp ' + value;
                            }
                        },
                        grid: { color: '#f3f4f6', drawBorder: false }
                    },
                    x: {
                        ticks: { font: { family: "'Inter', sans-serif", size: 12, weight: '500' }, color: '#6b7280' },
                        grid: { display: false, drawBorder: false }
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: { family: "'Inter', sans-serif", size: 12 },
                        bodyFont: { family: "'Inter', sans-serif", size: 13, weight: 'bold' },
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                const val = context.parsed.y || 0;
                                const formatted = new Intl.NumberFormat('id-ID', {
                                    style: 'currency', currency: 'IDR', minimumFractionDigits: 0
                                }).format(val);
                                return `Nominal Diterima: ${formatted}`;
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
