@extends('layouts.app')

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
        <!-- Section Donasi Terbaru -->
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
                <a href="{{ route('donasi.index', ['status' => 'pending']) }}" class="text-sm font-bold text-blue-600 hover:text-blue-700">Lihat semua →</a>
            </div>

            @if(isset($donasiTerbaru) && $donasiTerbaru->count() > 0)
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="border-b border-gray-200 bg-gray-50">
                        <tr>
                            <th class="px-4 py-2.5 font-semibold text-gray-700">Tanggal & Waktu</th>
                            <th class="px-4 py-2.5 font-semibold text-gray-700">Donatur</th>
                            <th class="px-4 py-2.5 font-semibold text-gray-700">Jumlah</th>
                            <th class="px-4 py-2.5 font-semibold text-gray-700">Metode</th>
                            <th class="px-4 py-2.5 text-center font-semibold text-gray-700">Bukti</th>
                            <th class="sticky right-0 z-10 bg-gray-50 px-4 py-2.5 text-center font-semibold text-gray-700 shadow-[inset_1px_0_0_#e5e7eb]">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @foreach($donasiTerbaru as $donasi)
                            <tr class="group transition-colors hover:bg-gray-50">

                                <!-- Tanggal & Waktu -->
                                <td class="px-4 py-2.5 text-gray-700">
                                    {{ $donasi->created_at
                                        ? $donasi->created_at->format('d M Y, H:i')
                                        : \Carbon\Carbon::parse($donasi->tanggal)->format('d M Y')
                                    }}
                                </td>

                                <!-- Donatur -->
                                <td class="px-4 py-2.5 font-semibold text-gray-900">{{ $donasi->nama_donatur }}</td>

                                <!-- Jumlah -->
                                <td class="px-4 py-2.5 font-semibold text-gray-900">Rp {{ number_format($donasi->nominal, 0, ',', '.') }}</td>

                                <!-- Metode -->
                                <td class="px-4 py-2.5 text-gray-700">{{ $donasi->metode_pembayaran }}</td>

                                <!-- Bukti Transfer -->
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

                                <!-- Aksi -->
                                <td class="sticky right-0 z-10 bg-white px-4 py-2.5 text-center shadow-[inset_1px_0_0_#e5e7eb] transition-colors group-hover:bg-gray-50">
                                    <div class="flex justify-center gap-1">

                                        <!-- Terima -->
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

                                        <!-- Tolak -->
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
                </div>       
            @else
                <div class="flex min-h-[200px] flex-col items-center justify-center gap-3 px-6 py-10 text-center text-gray-500">
                    <p class="text-sm font-semibold text-gray-900">Belum ada data donasi terbaru</p>
                </div>
            @endif
        </div>

        <div class="grid gap-5 xl:grid-cols-2">
            <!-- Grafik Distribusi Data -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 sm:p-6">
                <!-- Header Card -->
                <div class="flex items-center justify-between border-b border-gray-200 pb-4 mb-6">
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Distribusi Data Utama</h3>
                    </div>
                </div>

                @php
                    $tAnak = $totalAnak ?? 0;
                    $tPengasuh = $totalPengasuh ?? 0;
                    $tDonatur = $totalDonatur ?? 0;
                    $tKegiatan = $totalKegiatan ?? 0;
                    $grandTotal = $tAnak + $tPengasuh + $tDonatur + $tKegiatan;

                    $items = [
                        ['label' => 'Anak Asuh', 'value' => $tAnak, 'bg' => 'bg-blue-500', 'lightBg' => 'bg-blue-50', 'textColor' => 'text-blue-600'],
                        ['label' => 'Pengasuh', 'value' => $tPengasuh, 'bg' => 'bg-emerald-500', 'lightBg' => 'bg-emerald-50', 'textColor' => 'text-emerald-600'],
                        ['label' => 'Donatur', 'value' => $tDonatur, 'bg' => 'bg-violet-500', 'lightBg' => 'bg-violet-50', 'textColor' => 'text-violet-600'],
                        ['label' => 'Kegiatan', 'value' => $tKegiatan, 'bg' => 'bg-amber-500', 'lightBg' => 'bg-amber-50', 'textColor' => 'text-amber-600'],
                    ];
                @endphp

                <!-- Content Layout: Grid 2 Kolom -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
                    <!-- Kolom Kiri: Doughnut Chart + Center Overlay -->
                    <div class="lg:col-span-5 flex justify-center items-center py-2">
                        <div class="relative w-[160px] h-[160px] sm:w-[180px] sm:h-[180px]">
                            <canvas id="dataDistributionChart"></canvas>
                            
                            <!-- Teks di Tengah Doughnut -->
                            <div class="absolute inset-0 flex flex-col items-center justify-center text-center pointer-events-none">
                                <span class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                                    {{ number_format($grandTotal) }}
                                </span>
                                <span class="text-[11px] font-semibold uppercase tracking-wider text-gray-400 mt-0.5">Total Data</span>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan: Detail Jumlah & Persentase -->
                    <div class="lg:col-span-7 flex flex-col gap-3">
                        @foreach($items as $item)
                            @php
                                $percentage = $grandTotal > 0 ? round(($item['value'] / $grandTotal) * 100, 1) : 0;
                            @endphp
                            <div class="p-3 rounded-xl bg-gray-50/80 hover:bg-gray-100/80 transition-colors border border-gray-100/80">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-2.5">
                                        <span class="w-3 h-3 rounded-full {{ $item['bg'] }} ring-2 ring-white shadow-sm"></span>
                                        <span class="text-sm font-semibold text-gray-700">{{ $item['label'] }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-bold text-gray-900">{{ number_format($item['value']) }}</span>
                                        <span class="text-xs font-bold px-2 py-0.5 rounded-md {{ $item['lightBg'] }} {{ $item['textColor'] }}">
                                            {{ $percentage }}%
                                        </span>
                                    </div>
                                </div>
                                <!-- Mini Progress Bar -->
                                <div class="w-full bg-gray-200/80 h-1.5 rounded-full overflow-hidden">
                                    <div class="{{ $item['bg'] }} h-full rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Grafik Donatur Per Bulan -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 sm:p-6">
                <!-- Header Card -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 border-b border-gray-100 pb-4 mb-6">
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Jumlah Donatur (Tahun Ini)</h3>
                    </div>
                </div>

                <!-- Canvas Wrapper -->
                <div class="relative w-full h-[280px]">
                    <canvas id="monthlyDonationChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('dataDistributionChart').getContext('2d');
        const dataDistributionChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Anak Asuh', 'Pengasuh', 'Donatur', 'Kegiatan'],
                datasets: [{
                    data: [
                        {{ $totalAnak ?? 0 }},
                        {{ $totalPengasuh ?? 0 }},
                        {{ $totalDonatur ?? 0 }},
                        {{ $totalKegiatan ?? 0 }}
                    ],
                    backgroundColor: [
                        '#3b82f6', // blue-500
                        '#10b981', // emerald-500
                        '#8b5cf6', // violet-500
                        '#f59e0b'  // amber-500
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                    borderRadius: 6,
                    spacing: 3,
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '80%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        padding: 12,
                        titleFont: { family: "'Inter', sans-serif", size: 13 },
                        bodyFont: { family: "'Inter', sans-serif", size: 13, weight: 'bold' },
                        displayColors: true,
                        boxPadding: 6,
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) label += ': ';
                                if (context.parsed !== null) {
                                    let dataset = context.chart.data.datasets[0];
                                    let total = dataset.data.reduce((a, b) => a + b, 0);
                                    let percentage = total > 0 ? ((context.parsed / total) * 100).toFixed(1) + '%' : '0%';
                                    label += context.parsed + ' (' + percentage + ')';
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });

        const ctxDonation = document.getElementById('monthlyDonationChart').getContext('2d');
        const monthlyDonationChart = new Chart(ctxDonation, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Jumlah Donatur',
                    data: @json($donasiPerBulan ?? array_fill(0, 12, 0)),
                    backgroundColor: '#3b82f6',
                    hoverBackgroundColor: '#1d4ed8',
                    borderRadius: 8,
                    borderSkipped: false,
                    maxBarThickness: 28
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            precision: 0,
                            font: { family: "'Inter', sans-serif", size: 11 },
                            color: '#9ca3af'
                        },
                        grid: {
                            color: '#f3f4f6',
                            drawBorder: false
                        }
                    },
                    x: {
                        ticks: {
                            font: { family: "'Inter', sans-serif", size: 12, weight: '500' },
                            color: '#6b7280'
                        },
                        grid: {
                            display: false,
                            drawBorder: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: { family: "'Inter', sans-serif", size: 12 },
                        bodyFont: { family: "'Inter', sans-serif", size: 13, weight: 'bold' },
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return `Donatur: ${context.parsed.y} Orang`;
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush

@push('modals')
    @include('layouts.partials.donasi_action_modals')
@endpush
