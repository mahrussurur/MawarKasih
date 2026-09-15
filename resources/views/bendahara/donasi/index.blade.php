@extends('layouts.app')
@section('page-title', 'Data Donasi')
@section('title', 'Data Donasi | Panti Asuhan Mawar Kasih')

@section('content')
<div>
    <!-- Summary Cards -->
    <div class="grid gap-4 grid-cols-1 md:grid-cols-3 mb-4">
        <!-- Total Semua Donasi -->
        <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-blue-100 text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M3.75 5.25h16.5a1.5 1.5 0 011.5 1.5v10.5a1.5 1.5 0 01-1.5 1.5H3.75a1.5 1.5 0 01-1.5-1.5V6.75a1.5 1.5 0 011.5-1.5z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 14.25h2.25" />
                </svg>
            </div>
            <div class="min-w-0">
                <p class="truncate text-xs font-semibold uppercase tracking-[0.18em] text-gray-500">
                    Total Donasi Keseluruhan
                </p>
                <p class="truncate text-lg font-bold text-gray-900">
                    Rp {{ number_format($totalNominal, 0, ',', '.') }}
                </p>
            </div>
        </div>

        <!-- Jumlah Donatur Tetap -->
        <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-600">
                <svg class="h-5 w-5 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><polyline points="16 11 18 13 22 9"/>
                </svg>
            </div>
            <div class="min-w-0">
                <p class="truncate text-xs font-semibold uppercase tracking-[0.18em] text-gray-500">
                    Jumlah Donatur Tetap
                </p>
                <p class="truncate text-lg font-bold text-gray-900">
                    {{ $jumlahDonaturTetap }} <span class="text-sm font-normal text-gray-500">Orang</span>
                </p>
            </div>
        </div>
        
        <!-- Jumlah Donatur Umum -->
        <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-gray-100 text-gray-600">
                <svg class="h-5 w-5 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
            </div>
            <div class="min-w-0">
                <p class="truncate text-xs font-semibold uppercase tracking-[0.18em] text-gray-500">
                    Jumlah Donatur Umum
                </p>
                <p class="truncate text-lg font-bold text-gray-900">
                    {{ $jumlahDonaturUmum }} <span class="text-sm font-normal text-gray-500">Orang</span>
                </p>
            </div>
        </div>

    </div>

    <div class="flex justify-end mb-4">
        <form method="GET" action="{{ route('bendahara.donasi.cetak') }}" target="_blank" class="flex items-center gap-2">
            <select name="tahun"
                    class="rounded-xl border border-gray-200 bg-white px-3 py-2.5 text-sm font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Tahun</option>
                @foreach($tahunList as $t)
                    <option value="{{ $t }}">{{ $t }}</option>
                @endforeach
            </select>
            <button type="submit"
                    class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold shadow-sm transition hover:border-gray-300 hover:bg-gray-100">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak Laporan
            </button>
        </form>
    </div>

    <!-- Kotak Utama Konten -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6">

        <!-- Filter Bar -->
        <div class="flex flex-col gap-4 border-b border-gray-200 pb-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex flex-wrap gap-2">
                @php $activeStatus = request('status', 'semua'); @endphp

                <a href="{{ route('bendahara.donasi.index', array_merge(request()->except('status','page'), ['status'=>'semua'])) }}"
                   class="inline-flex items-center gap-2 rounded-full border px-4 py-2 text-[11px] font-semibold transition {{ $activeStatus === 'semua' ? 'bg-gray-900 text-white border-gray-900' : 'bg-gray-100 text-gray-600 border-gray-200 hover:bg-gray-200' }}">
                    Semua
                    <span class="rounded-full bg-white px-2 py-0.5 text-[10px] font-bold text-gray-600 shadow-sm">{{ $totalDonasi }}</span>
                </a>
                <a href="{{ route('bendahara.donasi.index', array_merge(request()->except('status','page'), ['status'=>'pending'])) }}"
                   class="inline-flex items-center gap-2 rounded-full border px-4 py-2 text-[11px] font-semibold transition {{ $activeStatus === 'pending' ? 'bg-amber-600 text-white border-amber-600' : 'bg-amber-100 text-amber-800 border-amber-100 hover:bg-amber-200' }}">
                    Pending
                    <span class="rounded-full bg-white px-2 py-0.5 text-[10px] font-bold text-gray-600 shadow-sm">{{ $totalPending }}</span>
                </a>
                <a href="{{ route('bendahara.donasi.index', array_merge(request()->except('status','page'), ['status'=>'diterima'])) }}"
                   class="inline-flex items-center gap-2 rounded-full border px-4 py-2 text-[11px] font-semibold transition {{ $activeStatus === 'diterima' ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-emerald-100 text-emerald-800 border-emerald-100 hover:bg-emerald-200' }}">
                    Diterima
                    <span class="rounded-full bg-white px-2 py-0.5 text-[10px] font-bold text-gray-600 shadow-sm">{{ $totalValid }}</span>
                </a>
                <a href="{{ route('bendahara.donasi.index', array_merge(request()->except('status','page'), ['status'=>'ditolak'])) }}"
                   class="inline-flex items-center gap-2 rounded-full border px-4 py-2 text-[11px] font-semibold transition {{ $activeStatus === 'ditolak' ? 'bg-red-600 text-white border-red-600' : 'bg-red-100 text-red-800 border-red-100 hover:bg-red-200' }}">
                    Ditolak
                    <span class="rounded-full bg-white px-2 py-0.5 text-[10px] font-bold text-gray-600 shadow-sm">{{ $totalDitolak }}</span>
                </a>
            </div>

            <!-- Search -->
            <form method="GET" action="{{ route('bendahara.donasi.index') }}" class="flex w-full items-center gap-3 lg:w-auto">
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
            <table class="w-full text-left divide-y divide-gray-200 text-sm border-b border-gray-200 whitespace-nowrap">
                <thead class="bg-gray-50">
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
                            @if($item->donatur_id)
                                <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-[11px] font-semibold text-emerald-800">Tetap</span>
                                <!-- <div class="mt-1 text-[11px] text-gray-500">ID: {{ $item->donatur_id }}</div> -->
                            @else
                                <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-[11px] font-semibold text-gray-700">Umum</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-700">{{ $item->no_hp ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ \Carbon\Carbon::parse($item->tanggal)->format('d - m - Y') }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $item->keterangan ? \Illuminate\Support\Str::limit($item->keterangan, 35) : '-' }}</td>
                        <td class="px-6 py-4 font-semibold text-gray-900">{{ $item->nominal_rupiah }}</td>
                        <td class="px-6 py-4 text-gray-700">
                            {{ ucfirst($item->metode_pembayaran) ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($item->bukti_transfer)
                                <button type="button"
                                        class="inline-flex"
                                        onclick="openImagePreview('{{ Storage::url($item->bukti_transfer) }}')"
                                        aria-label="Perbesar bukti transfer {{ $item->kode_donasi }}">
                                    <img src="{{ Storage::url($item->bukti_transfer) }}"
                                         class="h-12 w-12 rounded border border-gray-200 object-cover transition duration-200 hover:scale-105 cursor-pointer"
                                         alt="Bukti transfer {{ $item->kode_donasi }}"
                                         title="Klik untuk perbesar">
                                </button>
                            @else
                                <span class="text-gray-400 font-medium">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-amber-100 text-amber-800',
                                    'diterima' => 'bg-emerald-100 text-emerald-800',
                                    'ditolak' => 'bg-red-100 text-red-800',
                                ];
                            @endphp
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-[11px] font-semibold {{ $statusClasses[$item->status] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center sticky right-0 bg-white group-hover:bg-gray-50 z-10 transition-colors shadow-[inset_1px_0_0_#e5e7eb]">
                            <div class="flex justify-center gap-1">
                                <!-- Tombol Lihat Detail -->
                                <a href="{{ route('bendahara.donasi.show', $item->id) }}"
                                   class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-blue-500 bg-sky-100 text-blue-600 transition hover:bg-blue-500 hover:text-white"
                                   title="Lihat Detail">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>

                                @if($item->status === 'pending')
                                    <button type="button"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700 transition hover:bg-emerald-600 hover:text-white"
                                            title="Validasi"
                                            data-validasi-route="{{ route('bendahara.donasi.validasi', $item->id) }}"
                                            data-kode-donasi="{{ $item->kode_donasi }}"
                                            onclick="openValidasiModal(this)">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </button>
                                    <button type="button"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-red-100 text-red-700 transition hover:bg-red-600 hover:text-white"
                                            title="Tolak"
                                            data-tolak-route="{{ route('bendahara.donasi.tolak', $item->id) }}"
                                            data-kode-donasi="{{ $item->kode_donasi }}"
                                            onclick="openTolakModal(this)">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                @else
                                    <!-- Hanya tampilkan badge status (tombol aksi edit/hapus hanya untuk Admin) -->
                                @endif
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
            <span class="text-sm text-gray-500">{{ request('search') ? 'Data "'. request('search') . '" tidak ditemukan' : 'Tambahkan donasi pertama' }}</span>
        </div>
        @endif

    </div>
</div>

@endsection

@push('modals')
    @include('layouts.partials.admin.donasi_action_modals')
@endpush
