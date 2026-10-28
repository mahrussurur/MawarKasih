@extends('layouts.app')
@section('page-title', 'Dashboard')

@section('content')
<div>
    <div class="mb-6">
        <h2 class="text-2xl font-extrabold text-gray-900">Selamat Datang, {{ Auth::user()->name ?? Auth::user()->nama }}!</h2>
        <p class="mt-1 text-sm font-medium text-gray-500">Ini adalah halaman ringkasan statistik keuangan dan donasi panti asuhan mawar kasih.</p>
    </div>

    <!-- Keuangan Summary Grid -->
    <h3 class="text-lg font-bold text-gray-900 mb-3 mt-8">Keuangan Bulan Ini ({{ \Carbon\Carbon::now()->translatedFormat('F Y') }})</h3>
    <div class="mb-8 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm hover:-translate-y-0.5 hover:shadow-md transition duration-200">
            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-blue-100 text-blue-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-gray-500">Saldo Saat Ini</p>
                <p class="text-xl font-bold text-gray-900">Rp {{ number_format($saldoSaatIni ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>
        <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm hover:-translate-y-0.5 hover:shadow-md transition duration-200">
            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-green-100 text-green-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-gray-500">Pemasukan Bulan Ini</p>
                <p class="text-lg font-bold text-gray-900">+Rp {{ number_format($pemasukanBulanIni ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>
        <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm hover:-translate-y-0.5 hover:shadow-md transition duration-200">
            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-red-100 text-red-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-gray-500">Pengeluaran Bulan Ini</p>
                <p class="text-lg font-bold text-gray-900">-Rp {{ number_format($pengeluaranBulanIni ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>
        <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-gradient-to-br from-blue-500 to-blue-600 p-5 shadow-sm hover:-translate-y-0.5 hover:shadow-md transition duration-200">
            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-white/20 text-white">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-blue-100">Saldo Bulan Ini</p>
                <p class="text-xl font-bold text-white">Rp {{ number_format($saldoBulanIni ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <div class="grid gap-5">

        <!-- Donasi Menunggu Verifikasi (full width) -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6">
            <div class="flex flex-col gap-4 border-b border-gray-200 pb-4 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex items-center gap-3">
                    <h3 class="text-base font-extrabold text-gray-900">Donasi Menunggu Verifikasi</h3>
                    @if($totalPending > 0)
                        <span class="inline-flex items-center justify-center rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-bold text-amber-800">
                            {{ $totalPending }} Pending
                        </span>
                    @endif
                </div>
                <a href="{{ route('bendahara.donasi.index', ['status' => 'pending']) }}" class="text-sm font-bold text-blue-600 hover:text-blue-700">Lihat semua →</a>
            </div>

            @if(isset($donasiTerbaru) && $donasiTerbaru->count() > 0)
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="border-b border-gray-200 bg-gray-50">
                        <tr>
                            <th class="px-4 py-2.5 font-semibold text-gray-700">Tanggal</th>
                            <th class="px-4 py-2.5 font-semibold text-gray-700">Donatur</th>
                            <th class="px-4 py-2.5 font-semibold text-gray-700">Kode</th>
                            <th class="px-4 py-2.5 font-semibold text-gray-700">Jumlah</th>
                            <th class="px-4 py-2.5 text-center font-semibold text-gray-700">Bukti</th>
                            <th class="px-4 py-2.5 text-center font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($donasiTerbaru as $item)
                            <tr class="group transition-colors hover:bg-gray-50">
                                <!-- Tanggal -->
                                <td class="px-4 py-2.5 text-gray-700">
                                    {{ $item->created_at
                                        ? $item->created_at->format('d M Y, H:i')
                                        : \Carbon\Carbon::parse($item->tanggal)->format('d M Y')
                                    }}
                                </td>
                                <!-- Donatur -->
                                <td class="px-4 py-2.5 font-semibold text-gray-900">{{ $item->nama_donatur }}</td>
                                <!-- Kode -->
                                <td class="px-4 py-2.5 text-gray-700">{{ $item->kode_donasi }}</td>
                                <!-- Jumlah -->
                                <td class="px-4 py-2.5 font-semibold text-gray-900">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                                <!-- Bukti Transfer -->
                                <td class="px-4 py-2.5 text-center">
                                    @if($item->bukti_transfer)
                                        <button type="button" class="inline-flex"
                                            onclick="openImagePreview('{{ asset('storage/' . $item->bukti_transfer) }}')"
                                            aria-label="Perbesar bukti transfer">
                                            <img src="{{ asset('storage/' . $item->bukti_transfer) }}"
                                                class="h-10 w-10 cursor-pointer rounded border border-gray-200 object-cover transition duration-200 hover:scale-105"
                                                alt="Bukti transfer" title="Klik untuk memperbesar">
                                        </button>
                                    @else
                                        <span class="font-medium text-gray-400">-</span>
                                    @endif
                                </td>
                                <!-- Aksi -->
                                <td class="px-4 py-2.5 text-center">
                                    <div class="flex justify-center gap-1">
                                        <!-- Terima -->
                                        <button type="button"
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700 transition hover:bg-emerald-600 hover:text-white"
                                            title="Terima"
                                            data-validasi-route="{{ route('bendahara.donasi.validasi', $item->id) }}"
                                            data-kode-donasi="{{ $item->kode_donasi }}"
                                            onclick="openValidasiModal(this)">
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </button>
                                        <!-- Tolak -->
                                        <button type="button"
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-red-100 text-red-700 transition hover:bg-red-600 hover:text-white"
                                            title="Tolak"
                                            data-tolak-route="{{ route('bendahara.donasi.tolak', $item->id) }}"
                                            data-kode-donasi="{{ $item->kode_donasi }}"
                                            onclick="openTolakModal(this)">
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
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
                    <p class="text-sm font-semibold text-gray-900">Belum ada donasi yang menunggu verifikasi</p>
                </div>
            @endif
        </div>

        <!-- Status Laporan Bulanan & Grafik Nominal berdampingan -->
        <div class="grid gap-5 xl:grid-cols-2">

            <!-- Status Laporan Bulanan -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 sm:p-6 flex flex-col justify-between">
                <div>
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 border-b border-gray-200 pb-4 mb-6">
                        <div>
                            <h3 class="text-base font-bold text-gray-900">Status Laporan Bulanan</h3>
                        </div>
                        <a href="{{ route('bendahara.laporan-bulanan.index') }}" class="text-sm font-bold text-blue-600 hover:text-blue-700">Manajemen Laporan →</a>
                    </div>
                    @php
                        $statusItems = [
                            ['label' => 'Draft',        'key' => 'draft',        'color' => 'bg-gray-400',  'textColor' => 'text-gray-900'],
                            ['label' => 'Diajukan',     'key' => 'diajukan',     'color' => 'bg-blue-500',  'textColor' => 'text-gray-900'],
                            ['label' => 'Dikembalikan', 'key' => 'dikembalikan', 'color' => 'bg-red-500',   'textColor' => 'text-red-600'],
                            ['label' => 'Disetujui',    'key' => 'disetujui',    'color' => 'bg-green-500', 'textColor' => 'text-gray-900'],
                        ];
                    @endphp
                    <div class="flex flex-col gap-3">
                        @foreach($statusItems as $s)
                        <div class="p-3 rounded-xl bg-gray-50/80 hover:bg-gray-100/80 transition-colors border border-gray-100/80">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2.5">
                                    <span class="w-3 h-3 rounded-full {{ $s['color'] }} ring-2 ring-white shadow-sm"></span>
                                    <span class="text-sm font-semibold text-gray-700">{{ $s['label'] }}</span>
                                </div>
                                <span class="text-sm font-bold {{ $s['textColor'] }}">{{ $laporanCounts[$s['key']] ?? 0 }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Grafik Nominal per Bulan -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 border-b border-gray-200 pb-4 mb-6">
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Nominal Donasi Diterima ({{ date('Y') }})</h3>
                    </div>
                    <a href="{{ route('bendahara.donasi.index') }}" class="text-sm font-bold text-blue-600 hover:text-blue-700">Semua Data →</a>
                </div>
                <div class="relative w-full h-[280px]">
                    <canvas id="nominalBulananChart"></canvas>
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
    const ctx = document.getElementById('nominalBulananChart').getContext('2d');

    // Gradient fill
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(16, 185, 129, 0.35)');
    gradient.addColorStop(1, 'rgba(16, 185, 129, 0.0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
            datasets: [{
                label: 'Nominal Diterima',
                data: @json($nominalPerBulan),
                borderColor: '#10b981',
                borderWidth: 3,
                backgroundColor: gradient,
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointHoverRadius: 7,
                pointBackgroundColor: '#10b981',
                pointHoverBackgroundColor: '#059669',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index',
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        font: { family: "'Inter', sans-serif", size: 11 },
                        color: '#9ca3af',
                        callback: function(value) {
                            if (value >= 1000000000) return 'Rp ' + (value / 1000000000).toFixed(1).replace(/\.0$/, '') + ' M';
                            if (value >= 1000000) return 'Rp ' + (value / 1000000).toFixed(1).replace(/\.0$/, '') + ' Jt';
                            if (value >= 1000) return 'Rp ' + (value / 1000).toFixed(0) + ' Rb';
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
                                style: 'currency',
                                currency: 'IDR',
                                minimumFractionDigits: 0
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

@push('modals')
    @include('layouts.partials.admin.donasi_action_modals')
@endpush
