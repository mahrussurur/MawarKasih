@extends('layouts.app')
@section('title', 'Detail Laporan Bulanan')
@section('page-title', 'Detail Laporan Keuangan')

@section('content')
<div class="space-y-6">

    <!-- Banner Status Laporan -->
    @if($laporan->status === 'diajukan')
        <div class="flex flex-col gap-4 rounded-2xl border border-blue-200 bg-blue-50 p-5 md:flex-row md:items-center md:justify-between">
            <div class="flex items-start gap-3">
                <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="text-base font-bold text-blue-900">Laporan Diajukan</h4>
                    <p class="mt-0.5 text-sm text-blue-700">
                        Diajukan oleh <span class="font-semibold text-blue-900">{{ $laporan->submitter->name ?? 'Bendahara' }}</span> pada {{ $laporan->submitted_at ? $laporan->submitted_at->format('d/m/Y H:i') : '-' }}
                    </p>
                </div>
            </div>
        </div>
    @elseif($laporan->status === 'dikembalikan')
        <div class="flex items-start gap-3 rounded-2xl border border-red-200 bg-red-50 p-5">
            <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-600">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div>
                <h4 class="text-base font-bold text-red-900">Laporan Dikembalikan</h4>
                <p class="mt-1 text-sm font-medium text-red-800">Catatan: "{{ $laporan->catatan_return }}"</p>
                <p class="mt-1 text-xs text-red-600">
                    Dikembalikan oleh {{ $laporan->returner->name ?? 'Admin' }} pada {{ $laporan->returned_at ? $laporan->returned_at->format('d/m/Y H:i') : '-' }}
                </p>
            </div>
        </div>
    @elseif($laporan->status === 'disetujui')
        <div class="flex items-start gap-3 rounded-2xl border border-green-200 bg-green-50 p-5">
            <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-green-100 text-green-600">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h4 class="text-base font-bold text-green-900">Laporan Telah Disetujui</h4>
                <p class="mt-0.5 text-sm text-green-700">Laporan periode ini sudah final dan terkunci.</p>
                <p class="mt-1 text-xs text-green-600">
                    Disetujui oleh {{ $laporan->approver->name ?? 'Admin' }} pada {{ $laporan->approved_at ? $laporan->approved_at->format('d/m/Y H:i') : '-' }}
                </p>
            </div>
        </div>
    @endif

    <!-- Kotak Utama Konten -->
    <div class="rounded-2xl border border-gray-200 bg-white p-4 sm:p-6">
        
        <!-- Header & Action Buttons -->
        <div class="flex gap-4 border-b border-gray-200 pb-5 sm:flex-row sm:items-center sm:justify-between">
            <h3 class="text-lg font-bold text-gray-900">
                Ringkasan Keuangan: {{ \Carbon\Carbon::create()->month((int)$laporan->bulan)->translatedFormat('F') }} {{ $laporan->tahun }}
            </h3>

            <!-- Group Tombol Aksi -->
            <div class="flex items-center gap-2 flex-shrink-0">
                <!-- Tombol Cetak PDF -->
                <a href="{{ route('sekretaris.laporan-bulanan.cetak', $laporan) }}" target="_blank" class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-gray-50 px-3 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-100" title="Cetak PDF">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    <span class="hidden sm:inline">Cetak PDF</span>
                </a>

                <!-- Tombol Kembali -->
                <a href="{{ route('sekretaris.laporan-bulanan.index') }}" class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-gray-50 px-3 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-100" title="Kembali">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span class="hidden sm:inline">Kembali</span>
                </a>
            </div>
        </div>

        <!-- Cards Statistik Keuangan -->
        <div class="my-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-xl border border-gray-100 bg-gray-50 p-4">
                <p class="text-xs font-semibold text-gray-500">Saldo Awal</p>
                <p class="mt-1 text-xl font-bold text-gray-900">Rp {{ number_format($laporan->saldo_awal, 0, ',', '.') }}</p>
            </div>
            <div class="rounded-xl border border-emerald-100 bg-emerald-50/60 p-4">
                <p class="text-xs font-semibold text-emerald-700">Total Pemasukan</p>
                <p class="mt-1 text-xl font-bold text-emerald-700">+ Rp {{ number_format($laporan->total_pemasukan, 0, ',', '.') }}</p>
            </div>
            <div class="rounded-xl border border-rose-100 bg-rose-50/60 p-4">
                <p class="text-xs font-semibold text-rose-700">Total Pengeluaran</p>
                <p class="mt-1 text-xl font-bold text-rose-700">- Rp {{ number_format($laporan->total_pengeluaran, 0, ',', '.') }}</p>
            </div>
            <div class="rounded-xl border border-blue-100 bg-blue-50/60 p-4">
                <p class="text-xs font-semibold text-blue-700">Saldo Akhir</p>
                <p class="mt-1 text-xl font-bold text-blue-900">Rp {{ number_format($laporan->saldo_akhir, 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Rincian Kategori -->
        <div class="mb-8 rounded-xl border border-gray-100 bg-gray-50/50 p-4 sm:p-5">
            <h4 class="mb-4 text-base font-bold text-gray-900">Rincian Berdasarkan Kategori</h4>
            <div class="grid gap-6 sm:grid-cols-2">
                <!-- Pemasukan -->
                <div class="rounded-xl border border-gray-200 bg-white p-4">
                    <h5 class="mb-3 border-b border-gray-100 pb-2 text-xs font-bold uppercase tracking-wider text-emerald-600">Pemasukan</h5>
                    <ul class="divide-y divide-gray-50 space-y-2">
                        @forelse($ringkasan->where('jenis', 'pemasukan') as $kategori)
                            <li class="flex items-center justify-between pt-2 text-sm">
                                <span class="text-gray-600">{{ $kategori->kategori }}</span>
                                <span class="font-semibold text-gray-900">Rp {{ number_format($kategori->total, 0, ',', '.') }}</span>
                            </li>
                        @empty
                            <li class="py-2 text-sm text-gray-400">Tidak ada pemasukan</li>
                        @endforelse
                    </ul>
                </div>

                <!-- Pengeluaran -->
                <div class="rounded-xl border border-gray-200 bg-white p-4">
                    <h5 class="mb-3 border-b border-gray-100 pb-2 text-xs font-bold uppercase tracking-wider text-rose-600">Pengeluaran</h5>
                    <ul class="divide-y divide-gray-50 space-y-2">
                        @forelse($ringkasan->where('jenis', 'pengeluaran') as $kategori)
                            <li class="flex items-center justify-between pt-2 text-sm">
                                <span class="text-gray-600">{{ $kategori->kategori }}</span>
                                <span class="font-semibold text-gray-900">Rp {{ number_format($kategori->total, 0, ',', '.') }}</span>
                            </li>
                        @empty
                            <li class="py-2 text-sm text-gray-400">Tidak ada pengeluaran</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <!-- Tabel Transaksi -->
        <div>
            <h4 class="mb-4 text-base font-bold text-gray-900">Daftar Transaksi ({{ $transaksis->count() }} Transaksi)</h4>
            
            @if($transaksis->isNotEmpty())
                <div class="overflow-x-auto rounded-xl border border-gray-200">
                    <table class="w-full text-left text-sm whitespace-nowrap">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 font-semibold text-gray-700">Tanggal</th>
                                <th class="px-6 py-4 font-semibold text-gray-700">Keterangan</th>
                                <th class="px-6 py-4 font-semibold text-gray-700">Kategori</th>
                                <th class="px-6 py-4 font-semibold text-gray-700 text-right">Pemasukan</th>
                                <th class="px-6 py-4 font-semibold text-gray-700 text-right">Pengeluaran</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($transaksis as $trx)
                                <tr class="transition-colors hover:bg-gray-50">
                                    <td class="px-6 py-4 text-gray-600">
                                        {{ \Carbon\Carbon::parse($trx->tanggal)->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ $trx->keterangan }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex rounded-md bg-gray-100 px-2 py-1 text-xs font-semibold text-gray-700">
                                            {{ $trx->kategori }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right font-medium text-emerald-600">
                                        {{ $trx->jenis === 'pemasukan' ? '+ Rp ' . number_format($trx->nominal, 0, ',', '.') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-right font-medium text-rose-600">
                                        {{ $trx->jenis === 'pengeluaran' ? '- Rp ' . number_format($trx->nominal, 0, ',', '.') : '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="flex min-h-[200px] flex-col items-center justify-center gap-2 rounded-xl border border-dashed border-gray-200 p-8 text-center text-gray-500">
                    <p class="text-base font-semibold text-gray-900">Tidak ada transaksi.</p>
                    <span class="text-sm">Belum ada transaksi yang tercatat pada periode ini.</span>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection