@extends('layouts.app')
@section('page-title', 'Data Donasi')

@section('content')
<div>
    <!-- Summary Cards -->
    <div class="grid gap-4 grid-cols-1 md:grid-cols-3 mb-4">
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Total Donasi Keseluruhan</p>
            <p class="text-xl font-bold text-gray-900 mt-1">Rp {{ number_format($totalNominal, 0, ',', '.') }}</p>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Jumlah Donatur Tetap</p>
            <p class="text-xl font-bold text-gray-900 mt-1">{{ $jumlahDonaturTetap }} Orang</p>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Jumlah Donatur Umum</p>
            <p class="text-xl font-bold text-gray-900 mt-1">{{ $jumlahDonaturUmum }} Orang</p>
        </div>
    </div>

    <!-- Toolbar -->
    <div class="flex justify-end mb-4">
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('sekretaris.donasi.cetak') }}" target="_blank" class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold shadow-sm transition hover:border-gray-300 hover:bg-gray-100">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak Laporan
            </a>
        </div>
    </div>

    <!-- Kotak Utama Konten -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6">

        <!-- Filter Bar -->
        <div class="flex flex-col gap-4 border-b border-gray-200 pb-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex flex-wrap gap-2">
                @php $activeStatus = request('status', 'semua'); @endphp

                <a href="{{ route('sekretaris.donasi.index', array_merge(request()->except('status','page'), ['status'=>'semua'])) }}"
                   class="inline-flex items-center gap-2 rounded-full border px-4 py-2 text-[11px] font-semibold transition {{ $activeStatus === 'semua' ? 'bg-gray-900 text-white border-gray-900' : 'bg-gray-100 text-gray-600 border-gray-200 hover:bg-gray-200' }}">
                    Semua
                    <span class="rounded-full bg-white px-2 py-0.5 text-[10px] font-bold text-gray-600 shadow-sm">{{ $totalDonasi }}</span>
                </a>
                <a href="{{ route('sekretaris.donasi.index', array_merge(request()->except('status','page'), ['status'=>'pending'])) }}"
                   class="inline-flex items-center gap-2 rounded-full border px-4 py-2 text-[11px] font-semibold transition {{ $activeStatus === 'pending' ? 'bg-amber-600 text-white border-amber-600' : 'bg-amber-100 text-amber-800 border-amber-100 hover:bg-amber-200' }}">
                    Pending
                    <span class="rounded-full bg-white px-2 py-0.5 text-[10px] font-bold text-gray-600 shadow-sm">{{ $totalPending }}</span>
                </a>
                <a href="{{ route('sekretaris.donasi.index', array_merge(request()->except('status','page'), ['status'=>'diterima'])) }}"
                   class="inline-flex items-center gap-2 rounded-full border px-4 py-2 text-[11px] font-semibold transition {{ $activeStatus === 'diterima' ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-emerald-100 text-emerald-800 border-emerald-100 hover:bg-emerald-200' }}">
                    Diterima
                    <span class="rounded-full bg-white px-2 py-0.5 text-[10px] font-bold text-gray-600 shadow-sm">{{ $totalValid }}</span>
                </a>
                <a href="{{ route('sekretaris.donasi.index', array_merge(request()->except('status','page'), ['status'=>'ditolak'])) }}"
                   class="inline-flex items-center gap-2 rounded-full border px-4 py-2 text-[11px] font-semibold transition {{ $activeStatus === 'ditolak' ? 'bg-red-600 text-white border-red-600' : 'bg-red-100 text-red-800 border-red-100 hover:bg-red-200' }}">
                    Ditolak
                    <span class="rounded-full bg-white px-2 py-0.5 text-[10px] font-bold text-gray-600 shadow-sm">{{ $totalDitolak }}</span>
                </a>
            </div>

            <!-- Search -->
            <form method="GET" action="{{ route('sekretaris.donasi.index') }}" class="flex w-full items-center gap-3 lg:w-auto">
                <input type="hidden" name="status" value="{{ $activeStatus }}">
                <label class="relative block w-full lg:w-[260px]">
                    <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-gray-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / kode..."
                           class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent text-sm" />
                </label>
            </form>
        </div>

        <!-- Table data -->
        @if($donasi->count() > 0)
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 font-semibold text-gray-700 text-center w-12">No</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Kode Donasi</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Nama Donatur</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Sumber Donatur</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">No. HP</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Tanggal</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Keterangan</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Nominal</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Metode Pembayaran</th>
                        <th class="px-6 py-4 font-semibold text-gray-700 text-center">Bukti</th>
                        <th class="px-6 py-4 font-semibold text-gray-700 text-center">Status</th>
                        <th class="px-6 py-4 font-semibold text-gray-700 text-center sticky right-0 bg-gray-50 z-10 shadow-[inset_1px_0_0_#e5e7eb]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($donasi as $index => $item)
                    <tr class="hover:bg-gray-50 transition-colors group">
                        <td class="px-6 py-4 text-center text-gray-700">{{ $donasi->firstItem() + $index }}</td>
                        <td class="px-6 py-4 font-semibold text-gray-900">{{ $item->kode_donasi }}</td>
                        <td class="px-6 py-4 font-semibold text-gray-900">{{ $item->nama_donatur ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-700">
                            <span class="inline-flex rounded-md px-2 py-1 text-xs font-semibold ring-1 ring-inset {{ $item->donatur_id ? 'bg-green-50 text-green-700 ring-green-600/20' : 'bg-gray-50 text-gray-700 ring-gray-600/10' }}">{{ $item->donatur_id ? 'Tetap' : 'Umum' }}</span>
                        </td>
                        <td class="px-6 py-4 text-gray-700">{{ $item->no_hp ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ \Carbon\Carbon::parse($item->tanggal)->format('d - m - Y') }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $item->keterangan ? \Illuminate\Support\Str::limit($item->keterangan, 35) : '-' }}</td>
                        <td class="px-6 py-4 font-semibold text-gray-900">{{ $item->nominal_rupiah }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ ucfirst($item->metode_pembayaran) ?? '-' }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($item->bukti_transfer)
                                <button type="button" class="inline-flex" onclick="openImagePreview('{{ Storage::url($item->bukti_transfer) }}')" aria-label="Perbesar bukti transfer {{ $item->kode_donasi }}">
                                    <img src="{{ Storage::url($item->bukti_transfer) }}" class="h-12 w-12 rounded border border-gray-200 object-cover transition duration-200 hover:scale-105 cursor-pointer" alt="Bukti transfer {{ $item->kode_donasi }}" title="Klik untuk perbesar">
                                </button>
                            @else
                                <span class="text-gray-400 font-medium">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-amber-50 text-amber-700 ring-amber-600/20',
                                    'diterima' => 'bg-green-50 text-green-700 ring-green-600/20',
                                    'ditolak' => 'bg-red-50 text-red-700 ring-red-600/10',
                                ];
                            @endphp
                            <span class="inline-flex rounded-md px-2 py-1 text-xs font-semibold ring-1 ring-inset {{ $statusClasses[$item->status] ?? 'bg-gray-50 text-gray-700 ring-gray-600/10' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center sticky right-0 bg-white group-hover:bg-gray-50 z-10 transition-colors shadow-[inset_1px_0_0_#e5e7eb]">
                            <div class="flex justify-center gap-1">
                                <!-- Tombol Lihat Detail -->
                                <a href="{{ route('sekretaris.donasi.show', $item->id) }}"
                                   class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-blue-400 bg-blue-50 text-blue-600 transition hover:bg-blue-600 hover:text-white"
                                   title="Lihat Detail">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @include('layouts.partials.admin._pagination', ['paginator' => $donasi])

        @else
        <div class="flex min-h-[300px] flex-col items-center justify-center gap-3 px-6 py-10 text-center text-gray-500">
            <p class="text-base font-semibold text-gray-900">Belum ada data donasi</p>
            <span class="text-sm text-gray-500">{{ request('search') ? 'Data "'. request('search') . '" tidak ditemukan' : 'Tidak ada data untuk ditampilkan' }}</span>
        </div>
        @endif

    </div>
</div>
@endsection
