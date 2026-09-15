@extends('layouts.app')
@section('page-title', 'Riwayat Donasi Saya')
@section('title', 'Riwayat Donasi | Panti Asuhan Mawar Kasih')

@section('content')
<div>
    {{-- Summary Cards --}}
    <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 mb-4">
        <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-blue-100 text-blue-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-gray-500">Total Donasi</p>
                <p class="text-xl font-bold text-gray-900">{{ $totalDonasi }}</p>
            </div>
        </div>

        <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-amber-100 text-amber-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-gray-500">Pending</p>
                <p class="text-xl font-bold text-gray-900">{{ $totalPending }}</p>
            </div>
        </div>

        <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-gray-500">Diterima</p>
                <p class="text-xl font-bold text-gray-900">{{ $totalValid }}</p>
            </div>
        </div>

        <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-gray-500">Total Nominal</p>
                <p class="text-lg font-bold text-gray-900">Rp {{ number_format($totalNominal, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="flex justify-end mb-4">
        <a href="{{ route('donatur.donasi.cetak') }}" target="_blank"
           class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold shadow-sm transition hover:border-gray-300 hover:bg-gray-100">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Cetak Laporan
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6">
        {{-- Filter Bar --}}
        <div class="flex flex-col gap-4 border-b border-gray-200 pb-4 lg:flex-row lg:items-center lg:justify-between">
            @php $activeStatus = request('status', 'semua'); @endphp
            <div class="flex flex-wrap gap-2">
                @foreach(['semua' => 'Semua', 'pending' => 'Pending', 'diterima' => 'Diterima', 'ditolak' => 'Ditolak'] as $val => $label)
                @php
                    $count = match($val) {
                        'semua'    => $totalDonasi,
                        'pending'  => $totalPending,
                        'diterima' => $totalValid,
                        'ditolak'  => $totalDitolak,
                    };
                    $activeClass = match($val) {
                        'semua'    => 'bg-gray-900 text-white border-gray-900',
                        'pending'  => 'bg-amber-600 text-white border-amber-600',
                        'diterima' => 'bg-emerald-600 text-white border-emerald-600',
                        'ditolak'  => 'bg-red-600 text-white border-red-600',
                    };
                    $inactiveClass = match($val) {
                        'semua'    => 'bg-gray-100 text-gray-600 border-gray-200 hover:bg-gray-200',
                        'pending'  => 'bg-amber-100 text-amber-800 border-amber-100 hover:bg-amber-200',
                        'diterima' => 'bg-emerald-100 text-emerald-800 border-emerald-100 hover:bg-emerald-200',
                        'ditolak'  => 'bg-red-100 text-red-800 border-red-100 hover:bg-red-200',
                    };
                @endphp
                <a href="{{ route('donatur.donasi.index', array_merge(request()->except('status','page'), ['status'=>$val])) }}"
                   class="inline-flex items-center gap-2 rounded-full border px-4 py-2 text-[11px] font-semibold transition {{ $activeStatus === $val ? $activeClass : $inactiveClass }}">
                    {{ $label }}
                    <span class="rounded-full bg-white px-2 py-0.5 text-[10px] font-bold text-gray-600 shadow-sm">{{ $count }}</span>
                </a>
                @endforeach
            </div>

            {{-- Search --}}
            <form method="GET" action="{{ route('donatur.donasi.index') }}" class="flex items-center gap-2">
                <input type="hidden" name="status" value="{{ $activeStatus }}">
                <label class="relative block w-full lg:w-[240px]">
                    <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-gray-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode / keterangan..."
                           class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" />
                </label>
            </form>
        </div>

        {{-- Table --}}
        @if($donasi->count() > 0)
        <div class="overflow-x-auto mt-4">
            <table class="w-full text-left divide-y divide-gray-200 text-sm whitespace-nowrap">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-gray-600 text-center w-10">No</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Kode Donasi</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Tanggal</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Keterangan</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Nominal</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Metode</th>
                        <th class="px-4 py-3 font-semibold text-gray-600 text-center">Bukti</th>
                        <th class="px-4 py-3 font-semibold text-gray-600 text-center">Status</th>
                        <th class="px-4 py-3 font-semibold text-gray-600 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($donasi as $index => $item)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 text-center text-gray-600">{{ $donasi->firstItem() + $index }}</td>
                        <td class="px-4 py-3 font-semibold text-gray-900">{{ $item->kode_donasi }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $item->keterangan ? \Illuminate\Support\Str::limit($item->keterangan, 30) : '-' }}</td>
                        <td class="px-4 py-3 font-semibold text-gray-900">{{ $item->nominal_rupiah }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ ucfirst($item->metode_pembayaran ?? '-') }}</td>
                        <td class="px-4 py-3 text-center">
                            @if($item->bukti_transfer)
                                <button type="button" onclick="openImagePreview('{{ Storage::url($item->bukti_transfer) }}')" aria-label="Lihat bukti">
                                    <img src="{{ Storage::url($item->bukti_transfer) }}" class="h-10 w-10 rounded border border-gray-200 object-cover hover:scale-105 transition cursor-pointer">
                                </button>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            @php
                                $sc = ['pending'=>'bg-amber-100 text-amber-800','diterima'=>'bg-emerald-100 text-emerald-800','ditolak'=>'bg-red-100 text-red-800'];
                            @endphp
                            <span class="inline-flex rounded-full px-2.5 py-0.5 text-[11px] font-semibold {{ $sc[$item->status] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <a href="{{ route('donatur.donasi.show', $item->id) }}"
                               class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-blue-400 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition"
                               title="Lihat Detail">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @include('layouts.partials.admin._pagination', ['paginator' => $donasi])
        @else
        <div class="flex min-h-[250px] flex-col items-center justify-center gap-2 text-center text-gray-500 mt-4">
            <p class="font-semibold text-gray-900">Belum ada data donasi</p>
            <span class="text-sm">{{ request('search') ? 'Data "' . request('search') . '" tidak ditemukan' : 'Donasi Anda akan tampil di sini.' }}</span>
        </div>
        @endif
    </div>
</div>
@endsection
