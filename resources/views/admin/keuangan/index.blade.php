@extends('layouts.app')

@section('title', 'Data Keuangan')
@section('page-title', 'Transaksi Keuangan')

@section('content')
<div>
    <div class="mb-6 grid gap-4 grid-cols-1 sm:grid-cols-3">
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Saldo Yayasan</p>
            <p class="text-xl font-bold text-gray-900 mt-1">Rp {{ number_format($saldo, 0, ',', '.') }}</p>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Total Pemasukan</p>
            <p class="text-xl font-bold text-emerald-600 mt-1">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Total Pengeluaran</p>
            <p class="text-xl font-bold text-red-600 mt-1">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Toolbar -->
    <div class="flex justify-between mb-4">
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('admin.keuangan.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Catat Transaksi Manual
            </a>
            <a href="{{ route('admin.keuangan.cetak', request()->only(['jenis', 'search'])) }}" target="_blank" class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm font-semibold text-gray-700 shadow-sm transition hover:border-gray-300 hover:bg-gray-100">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9V2h12v7m-12 9H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2m-12 0h12v4H6v-4z"/></svg>
                Cetak Laporan
            </a>
        </div>
    </div>

    <!-- Konten Tabel -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6">
        <div class="flex flex-col gap-4 border-b border-gray-200 pb-4 lg:flex-row lg:items-center lg:justify-between">
            @php $activeJenis = request('jenis', 'semua'); @endphp
            <div class="flex gap-2">
                <a href="{{ route('admin.keuangan.index', ['jenis' => 'semua']) }}" class="inline-flex rounded-full border px-4 py-2 text-[11px] font-semibold transition {{ $activeJenis === 'semua' ? 'bg-gray-900 text-white' : 'bg-gray-50 text-gray-600 hover:bg-gray-100' }}">Semua</a>
                <a href="{{ route('admin.keuangan.index', ['jenis' => 'pemasukan']) }}" class="inline-flex rounded-full border px-4 py-2 text-[11px] font-semibold transition {{ $activeJenis === 'pemasukan' ? 'bg-emerald-600 text-white' : 'bg-emerald-50 text-emerald-800 hover:bg-emerald-100' }}">Pemasukan</a>
                <a href="{{ route('admin.keuangan.index', ['jenis' => 'pengeluaran']) }}" class="inline-flex rounded-full border px-4 py-2 text-[11px] font-semibold transition {{ $activeJenis === 'pengeluaran' ? 'bg-red-600 text-white' : 'bg-red-50 text-red-800 hover:bg-red-100' }}">Pengeluaran</a>
            </div>

            <!-- Search -->
            <form method="GET" action="{{ route('admin.keuangan.index') }}" class="flex items-center gap-2">
                <input type="hidden" name="jenis" value="{{ $activeJenis }}">
                <label class="relative block w-full lg:w-[240px]">
                    <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-gray-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari keterangan..."
                           class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" />
                </label>
            </form>
        </div>

        @if($transaksi->count() > 0)
        <div class="overflow-x-auto mt-4">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-gray-600 text-center w-10">No</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Tanggal</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Jenis</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Nominal</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Keterangan</th>
                        <th class="px-4 py-3 font-semibold text-gray-600 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($transaksi as $index => $item)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 text-center text-gray-600">{{ $transaksi->firstItem() + $index }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                        <td class="px-4 py-3 font-semibold">
                            @if($item->jenis === 'pemasukan')
                                <span class="text-emerald-600">Pemasukan</span>
                            @else
                                <span class="text-red-600">Pengeluaran</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 font-bold text-gray-900">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-gray-600 whitespace-normal min-w-[250px]">{{ $item->keterangan }}</td>
                        <td class="px-4 py-3 text-center">
                            @if(!$item->donasi_id)
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.keuangan.edit', $item->id) }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-amber-100 text-amber-700 transition hover:bg-amber-600 hover:text-white" title="Edit">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form action="{{ route('admin.keuangan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus transaksi ini?');" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-red-100 text-red-700 transition hover:bg-red-600 hover:text-white" title="Hapus">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                            @else
                                <span class="text-xs text-gray-400 bg-gray-100 px-2 py-1 rounded">Sistem (Donasi)</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $transaksi->links() }}</div>
        @else
        <div class="flex min-h-[250px] flex-col items-center justify-center gap-2 text-center text-gray-500 mt-4">
            <p class="font-semibold text-gray-900">Belum ada transaksi</p>
        </div>
        @endif
    </div>
</div>
@endsection

