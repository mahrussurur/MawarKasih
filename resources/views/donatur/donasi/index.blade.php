@extends('layouts.app')
@section('page-title', 'Riwayat Donasi')

@section('content')
<div>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6">
        <!-- Filter Bar -->
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
                        'pending'  => 'bg-amber-500 text-white border-amber-500',
                        'diterima' => 'bg-emerald-600 text-white border-emerald-600',
                        'ditolak'  => 'bg-red-600 text-white border-red-600',
                    };
                    $inactiveClass = match($val) {
                        'semua'    => 'bg-gray-100 text-gray-600 border-gray-200 hover:bg-gray-200',
                        'pending'  => 'bg-amber-100 text-amber-700 border-amber-100 hover:bg-amber-200',
                        'diterima' => 'bg-emerald-100 text-emerald-800 border-emerald-100 hover:bg-emerald-200',
                        'ditolak'  => 'bg-red-100 text-red-800 border-red-100 hover:bg-red-200',
                    };
                @endphp
                <a href="{{ route('donatur.donasi.index', array_merge(request()->except('status','page'), ['status'=>$val])) }}"
                   class="inline-flex items-center gap-2 rounded-xl border px-3 py-1.5 text-xs font-semibold transition {{ $activeStatus === $val ? $activeClass : $inactiveClass }}">
                    {{ $label }}
                    <span class="rounded-md bg-white px-1.5 py-0.5 text-[10px] font-bold text-gray-600 shadow-sm">{{ $count }}</span>
                </a>
                @endforeach
            </div>

            <!-- Search -->
            <form method="GET" action="{{ route('donatur.donasi.index') }}" class="flex w-full items-center gap-3 lg:w-auto">
                <input type="hidden" name="status" value="{{ $activeStatus }}">
                <label class="relative block w-full lg:w-[260px]">
                    <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-gray-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode / keterangan..."
                           class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-blue-500 text-sm" />
                </label>
            </form>
        </div>

        <!-- Table -->
        @if($donasi->count() > 0)
        <div class="overflow-hidden">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 font-semibold text-gray-700 text-center w-12">No</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Kode Donasi</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Tanggal</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Nominal</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Metode</th>
                        <th class="px-6 py-4 font-semibold text-gray-700 text-center">Bukti</th>
                        <th class="px-6 py-4 font-semibold text-gray-700 text-center">Status</th>
                        <th class="px-6 py-4 font-semibold text-gray-700 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($donasi as $index => $item)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-center text-gray-700">{{ $donasi->firstItem() + $index }}</td>
                        <td class="px-6 py-4 font-semibold text-gray-900">{{ $item->kode_donasi }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                        <td class="px-6 py-4 font-semibold text-gray-900">{{ $item->nominal_rupiah }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ ucfirst($item->metode_pembayaran ?? '-') }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($item->bukti_transfer)
                                <button type="button" onclick="openImagePreview('{{ Storage::url($item->bukti_transfer) }}')" aria-label="Lihat bukti">
                                    <img src="{{ Storage::url($item->bukti_transfer) }}"
                                         class="h-12 w-8 rounded border border-gray-400 object-cover hover:scale-105 transition cursor-pointer"
                                         alt="Bukti transfer {{ $item->kode_donasi }}"
                                         title="Klik untuk perbesar">
                                </button>
                            @else
                                <span class="text-gray-400 font-medium">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $sc = ['pending'=>'bg-amber-100 text-amber-800','diterima'=>'bg-emerald-100 text-emerald-800','ditolak'=>'bg-red-100 text-red-800'];
                            @endphp
                            <span class="inline-flex rounded-md px-2 py-1 text-xs font-semibold {{ $sc[$item->status] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('donatur.donasi.show', $item->id) }}"
                               class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-blue-400 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition"
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

        <!-- Pagination -->
        @include('layouts.partials.admin._pagination', ['paginator' => $donasi])

        @else
        <div class="flex min-h-[300px] flex-col items-center justify-center gap-3 px-6 py-10 text-center text-gray-500">
            <p class="text-base font-semibold text-gray-900">Belum ada data donasi</p>
            <span class="text-sm">{{ request('search') ? 'Data "' . request('search') . '" tidak ditemukan' : 'Donasi Anda akan tampil di sini.' }}</span>
        </div>
        @endif
    </div>
</div>
@endsection
