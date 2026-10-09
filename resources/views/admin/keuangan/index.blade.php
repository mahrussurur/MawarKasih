@extends('layouts.app')
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
    <div class="flex justify-end mb-4">

        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('admin.keuangan.cetak', request()->only(['jenis', 'search'])) }}" target="_blank" class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold shadow-sm transition hover:border-gray-300 hover:bg-gray-100">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak Laporan
            </a>
        </div>
    </div>

    <!-- Konten Tabel -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6">
        <div class="flex flex-col gap-4 border-b border-gray-200 pb-4 lg:flex-row lg:items-center lg:justify-between">
            @php $activeJenis = request('jenis', 'semua'); @endphp
            <div class="flex gap-2">
                <a href="{{ route('admin.keuangan.index', ['jenis' => 'semua']) }}" class="inline-flex rounded-full border px-4 py-2 text-[11px] font-semibold transition {{ $activeJenis === 'semua' ? 'bg-gray-900 text-white' : 'bg-gray-50 text-gray-600 hover:bg-gray-100' }}">
                    Semua
                </a>
                <a href="{{ route('admin.keuangan.index', ['jenis' => 'pemasukan']) }}" class="inline-flex rounded-full border px-4 py-2 text-[11px] font-semibold transition {{ $activeJenis === 'pemasukan' ? 'bg-emerald-600 text-white' : 'bg-emerald-50 text-emerald-800 hover:bg-emerald-100' }}">
                    Pemasukan
                </a>
                <a href="{{ route('admin.keuangan.index', ['jenis' => 'pengeluaran']) }}" class="inline-flex rounded-full border px-4 py-2 text-[11px] font-semibold transition {{ $activeJenis === 'pengeluaran' ? 'bg-red-600 text-white' : 'bg-red-50 text-red-800 hover:bg-red-100' }}">
                    Pengeluaran
                </a>
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
        
        <!-- Table data -->
        @if($transaksi->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-center w-10">No</th>
                        <th class="px-6 py-4 font-semibold text-gray-600">Tanggal</th>
                        <th class="px-6 py-4 font-semibold text-gray-600">Jenis</th>
                        <th class="px-6 py-4 font-semibold text-gray-600">Nominal</th>
                        <th class="px-6 py-4 font-semibold text-gray-600">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($transaksi as $index => $item)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-center text-gray-600">{{ $transaksi->firstItem() + $index }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-xs font-semibold">
                            @if($item->jenis === 'pemasukan')
                                <span class="text-emerald-600">Pemasukan</span>
                            @else
                                <span class="text-red-600">Pengeluaran</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-bold text-gray-900">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-gray-600 whitespace-normal min-w-[250px]">{{ $item->keterangan }}</td>
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
