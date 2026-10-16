@extends('layouts.app')

@section('title', 'Dashboard Bendahara')
@section('page-title', 'Dashboard')

@section('content')
<div>
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-extrabold text-gray-900">Selamat Datang, {{ Auth::user()->name ?? Auth::user()->nama }}!</h2>
            <p class="mt-1 text-sm font-medium text-gray-500">Ringkasan keuangan dan status donasi yayasan.</p>
        </div>
        <a href="{{ route('bendahara.laporan-bulanan.index') }}" class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 transition">
            Buat / Review Laporan Bulanan
        </a>
    </div>

    {{-- Keuangan MTD --}}
    <h3 class="text-lg font-bold text-gray-900 mb-3">Keuangan Bulan Ini ({{ \Carbon\Carbon::now()->translatedFormat('F Y') }})</h3>
    <div class="mb-8 grid gap-4 grid-cols-1 sm:grid-cols-2 xl:grid-cols-4">
        <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm hover:-translate-y-0.5 hover:shadow-md transition duration-200">
            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-blue-100 text-blue-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Saldo Saat Ini</p>
                <p class="text-lg font-bold text-gray-900">Rp {{ number_format($saldoSaatIni ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>
        <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm hover:-translate-y-0.5 hover:shadow-md transition duration-200">
            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-green-100 text-green-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Pemasukan Bulan Ini</p>
                <p class="text-lg font-bold text-gray-900">+Rp {{ number_format($pemasukanBulanIni ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>
        <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm hover:-translate-y-0.5 hover:shadow-md transition duration-200">
            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-red-100 text-red-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Pengeluaran Bulan Ini</p>
                <p class="text-lg font-bold text-gray-900">-Rp {{ number_format($pengeluaranBulanIni ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>
        <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-gradient-to-br from-blue-500 to-blue-600 p-5 shadow-sm hover:-translate-y-0.5 hover:shadow-md transition duration-200">
            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-white/20 text-white">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-blue-100">Saldo Bulan Ini</p>
                <p class="text-xl font-bold text-white">Rp {{ number_format($saldoBulanIni ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-3 mb-8">
        {{-- Laporan Bulanan Status --}}
        <div class="xl:col-span-1 bg-white rounded-2xl shadow-sm border border-gray-200 p-5 flex flex-col justify-between">
            <div>
                <h3 class="text-base font-bold text-gray-900 border-b border-gray-100 pb-3 mb-4">Status Laporan Bulanan</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-gray-400"></span> Draft
                        </span>
                        <span class="font-bold text-gray-900">{{ $laporanCounts['draft'] ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-blue-500"></span> Diajukan
                        </span>
                        <span class="font-bold text-gray-900">{{ $laporanCounts['diajukan'] ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-red-500"></span> Dikembalikan
                        </span>
                        <span class="font-bold text-red-600">{{ $laporanCounts['dikembalikan'] ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-green-500"></span> Disetujui
                        </span>
                        <span class="font-bold text-gray-900">{{ $laporanCounts['disetujui'] ?? 0 }}</span>
                    </div>
                </div>
            </div>
            <div class="mt-6 pt-4 border-t border-gray-100">
                <a href="{{ route('bendahara.laporan-bulanan.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700">Manajemen Laporan →</a>
            </div>
        </div>

        {{-- Donasi Pending Terbaru --}}
        <div class="xl:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-200 p-5">
            <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-4">
                <div class="flex items-center gap-2">
                    <h3 class="text-base font-bold text-gray-900">Donasi Menunggu Verifikasi</h3>
                    @if($totalPending > 0)
                        <span class="inline-flex rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-bold text-amber-800">{{ $totalPending }}</span>
                    @endif
                </div>
                <a href="{{ route('bendahara.donasi.index', ['status' => 'pending']) }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700">Lihat Semua →</a>
            </div>

            @forelse($donasiTerbaru as $item)
            <div class="flex items-center justify-between py-3 border-b border-gray-50 last:border-0">
                <div>
                    <p class="text-sm font-semibold text-gray-900">{{ $item->nama_donatur }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">{{ $item->kode_donasi }} · {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</p>
                </div>
                <div class="text-right flex-shrink-0 ml-4">
                    <p class="text-sm font-bold text-gray-900">{{ $item->nominal_rupiah }}</p>
                    <a href="{{ route('bendahara.donasi.show', $item->id) }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700">Lihat →</a>
                </div>
            </div>
            @empty
            <div class="flex min-h-[120px] items-center justify-center text-center text-gray-400 text-sm">
                <p>Tidak ada donasi pending. 🎉</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Grafik Nominal per Bulan --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5">
        <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-4">
            <h3 class="text-base font-bold text-gray-900">Nominal Donasi Diterima ({{ date('Y') }})</h3>
            <a href="{{ route('bendahara.donasi.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700">Semua Data →</a>
        </div>
        <div class="relative w-full h-[240px]">
            <canvas id="nominalBulananChart"></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('nominalBulananChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
            datasets: [{
                label: 'Nominal Diterima',
                data: @json($nominalPerBulan),
                backgroundColor: '#10b981',
                hoverBackgroundColor: '#059669',
                borderRadius: 8,
                borderSkipped: false,
                maxBarThickness: 30
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: val => 'Rp ' + new Intl.NumberFormat('id').format(val),
                        font: { size: 10 },
                        color: '#9ca3af'
                    },
                    grid: { color: '#f3f4f6', drawBorder: false }
                },
                x: {
                    ticks: { font: { size: 11, weight: '500' }, color: '#6b7280' },
                    grid: { display: false, drawBorder: false }
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0f172a',
                    padding: 12,
                    callbacks: {
                        label: ctx => 'Rp ' + new Intl.NumberFormat('id').format(ctx.parsed.y)
                    }
                }
            }
        }
    });
});
</script>
@endpush
