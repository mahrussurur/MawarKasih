@extends('layouts.app')
@section('page-title', 'Data Donasi')

@section('content')
<div>
    <!-- Summary Cards -->
    <div class="grid gap-4 grid-cols-1 md:grid-cols-3 mb-4">
        <!-- Total Semua Donasi -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Total Donasi Keseluruhan</p>
            <p class="text-xl font-bold text-gray-900 mt-1">Rp {{ number_format($totalNominal, 0, ',', '.') }}</p>
        </div>
        <!-- Total Donasi Donatur Tetap -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Total Donasi Donatur Tetap</p>
            <p class="text-xl font-bold text-gray-900 mt-1">Rp {{ number_format($nominalDonaturTetap ?? 0, 0, ',', '.') }}</p>
        </div>
        <!-- Total Donasi Donatur Umum -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Total Donasi Donatur Umum</p>
            <p class="text-xl font-bold text-gray-900 mt-1">Rp {{ number_format($nominalDonaturUmum ?? 0, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Toolbar -->
    <div class="flex justify-between mb-4">
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('donasi.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Donasi
            </a>
        </div>
    </div>

    <!-- Kotak Utama Konten -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6">

        <!-- Filter Bar -->
        <div class="flex flex-col gap-4 border-b border-gray-200 pb-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex flex-wrap gap-2">
                @php $activeStatus = request('status', 'semua'); @endphp

                <a href="{{ route('donasi.index', array_merge(request()->except('status','page'), ['status'=>'semua'])) }}"
                class="inline-flex items-center gap-2 rounded-xl border px-3 py-1.5 text-xs font-semibold transition {{ $activeStatus === 'semua' ? 'bg-gray-900 text-white border-gray-900' : 'bg-gray-100 text-gray-600 border-gray-200 hover:bg-gray-200' }}">
                    Semua
                    <span class="rounded-md bg-white px-1.5 py-0.5 text-[10px] font-bold text-gray-600 shadow-sm">{{ $totalDonasi }}</span>
                </a>

                <a href="{{ route('donasi.index', array_merge(request()->except('status','page'), ['status'=>'pending'])) }}"
                class="inline-flex items-center gap-2 rounded-xl border px-3 py-1.5 text-xs font-semibold transition {{ $activeStatus === 'pending' ? 'bg-amber-500 text-white border-amber-500' : 'bg-amber-100 text-amber-700 border-amber-100 hover:bg-amber-200' }}">
                    Pending
                    <span class="rounded-md bg-white px-1.5 py-0.5 text-[10px] font-bold text-gray-600 shadow-sm">{{ $totalPending }}</span>
                </a>

                <a href="{{ route('donasi.index', array_merge(request()->except('status','page'), ['status'=>'diterima'])) }}"
                class="inline-flex items-center gap-2 rounded-xl border px-3 py-1.5 text-xs font-semibold transition {{ $activeStatus === 'diterima' ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-emerald-100 text-emerald-800 border-emerald-100 hover:bg-emerald-200' }}">
                    Diterima
                    <span class="rounded-md bg-white px-1.5 py-0.5 text-[10px] font-bold text-gray-600 shadow-sm">{{ $totalValid }}</span>
                </a>

                <a href="{{ route('donasi.index', array_merge(request()->except('status','page'), ['status'=>'ditolak'])) }}"
                class="inline-flex items-center gap-2 rounded-xl border px-3 py-1.5 text-xs font-semibold transition {{ $activeStatus === 'ditolak' ? 'bg-red-600 text-white border-red-600' : 'bg-red-100 text-red-800 border-red-100 hover:bg-red-200' }}">
                    Ditolak
                    <span class="rounded-md bg-white px-1.5 py-0.5 text-[10px] font-bold text-gray-600 shadow-sm">{{ $totalDitolak }}</span>
                </a>
            </div>

            <!-- Search -->
            <form method="GET" action="{{ route('donasi.index') }}" class="flex w-full items-center gap-3 lg:w-auto">
                <input type="hidden" name="status" value="{{ $activeStatus }}">
                <label class="relative block w-full lg:w-[260px]">
                    <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-gray-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Donasi..."
                           class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent text-sm" />
                </label>
            </form>
        </div>

        <!-- Table data -->
        @if($donasi->count() > 0)
        <div class="overflow-hidden">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 font-semibold text-gray-700 text-center w-12">No</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Kode Donasi</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Nama Donatur</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Sumber Donatur</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Nominal</th>
                        <th class="px-6 py-4 font-semibold text-gray-700 text-center">Bukti</th>
                        <th class="px-6 py-4 font-semibold text-gray-700 text-center">Aksi</th>
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
                        <td class="px-6 py-4 font-semibold text-gray-900">{{ $item->nominal_rupiah }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($item->bukti_transfer)
                                <button type="button"
                                        class="inline-flex"
                                        onclick="openImagePreview('{{ Storage::url($item->bukti_transfer) }}')"
                                        aria-label="Perbesar bukti transfer {{ $item->kode_donasi }}">
                                    <img src="{{ Storage::url($item->bukti_transfer) }}"
                                         class="h-12 w-8 rounded border border-gray-200 object-cover transition duration-200 hover:scale-105 cursor-pointer"
                                         alt="Bukti transfer {{ $item->kode_donasi }}"
                                         title="Klik untuk perbesar">
                                </button>
                            @else
                                <span class="text-gray-400 font-medium">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center gap-1">
                                 <!-- Tombol Lihat Detail -->
                                 <a href="{{ route('donasi.show', $item->id) }}"
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-blue-400 bg-blue-50 text-blue-600 transition hover:bg-blue-600 hover:text-white"
                                    title="Lihat Detail">
                                     <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>

                                 @if($item->status === 'pending')
                                     <button type="button"
                                             class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-emerald-400 bg-emerald-50 text-emerald-600 transition hover:bg-emerald-500 hover:text-white"
                                            title="Validasi"
                                            data-validasi-route="{{ route('donasi.validasi', $item->id) }}"
                                            data-kode-donasi="{{ $item->kode_donasi }}"
                                            onclick="openValidasiModal(this)">
                                         <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </button>
                                     <button type="button"
                                             class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-red-400 bg-red-50 text-red-600 transition hover:bg-red-600 hover:text-white"
                                            title="Tolak"
                                            data-tolak-route="{{ route('donasi.tolak', $item->id) }}"
                                            data-kode-donasi="{{ $item->kode_donasi }}"
                                            onclick="openTolakModal(this)">
                                         <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                 @else
                                     <a href="{{ route('donasi.edit', $item->id) }}"
                                         class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-amber-400 bg-amber-50 text-amber-600 transition hover:bg-amber-500 hover:text-white"
                                         title="Edit">
                                         <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                     <button type="button"
                                             class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-red-400 bg-red-50 text-red-600 transition hover:bg-red-600 hover:text-white"
                                            title="Hapus"
                                            data-delete-route="{{ route('donasi.destroy', $item->id) }}"
                                            data-name="{{ $item->kode_donasi }}"
                                            onclick="openDeleteModal(this)">
                                         <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
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
