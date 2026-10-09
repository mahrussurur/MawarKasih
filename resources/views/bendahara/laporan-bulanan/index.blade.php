@extends('layouts.app')
@section('title', 'Draft & Preview Laporan Bulanan')
@section('page-title', 'Laporan Keuangan Bulanan')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8 mb-6">
        <form method="GET" action="{{ route('bendahara.laporan-bulanan.index') }}" class="flex flex-col sm:flex-row gap-4 items-end">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Bulan</label>
                <select name="bulan" class="rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 min-w-[150px]">
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month((int)$m)->translatedFormat('F') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tahun</label>
                <select name="tahun" class="rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 min-w-[120px]">
                    @foreach(range(date('Y') - 3, date('Y') + 1) as $y)
                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="rounded-xl bg-gray-100 text-gray-800 px-6 py-2.5 text-sm font-semibold hover:bg-gray-200 transition">
                Tampilkan
            </button>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8 relative overflow-hidden">
        @if($laporan->status === 'returned')
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl">
                <h4 class="font-bold text-red-800">Laporan Dikembalikan (Return)</h4>
                <p class="text-sm text-red-700 mt-1">{{ $laporan->catatan_return }}</p>
                <p class="text-xs text-red-500 mt-2">Oleh: {{ $laporan->returner->name ?? 'Admin' }} pada {{ $laporan->returned_at->format('d/m/Y H:i') }}</p>
            </div>
        @endif

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Preview Laporan</h3>
                <p class="text-gray-500 text-sm mt-1">Periode: {{ \Carbon\Carbon::create()->month((int)$bulan)->translatedFormat('F') }} {{ $tahun }}</p>
            </div>
            <div class="flex items-center gap-3">
                @if($laporan->status === 'draft')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">Draft</span>
                @elseif($laporan->status === 'submitted')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">Submitted</span>
                @elseif($laporan->status === 'returned')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">Returned</span>
                @elseif($laporan->status === 'approved')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">Approved</span>
                @endif

                @if($laporan->id)
                <a href="{{ route('bendahara.laporan-bulanan.cetak', $laporan) }}" target="_blank" class="inline-flex items-center gap-1.5 rounded-xl bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Cetak PDF
                </a>
                @endif
            </div>
        </div>

        <div class="grid sm:grid-cols-2 gap-6 mb-8">
            <div class="p-5 rounded-2xl bg-gray-50 border border-gray-100">
                <p class="text-sm text-gray-500 font-medium mb-1">Saldo Awal</p>
                <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($laporan->saldo_awal, 0, ',', '.') }}</p>
            </div>
            
            <div class="p-5 rounded-2xl bg-green-50 border border-green-100">
                <p class="text-sm text-green-600 font-medium mb-1">Total Pemasukan</p>
                <p class="text-2xl font-bold text-green-700">+ Rp {{ number_format($laporan->total_pemasukan, 0, ',', '.') }}</p>
            </div>

            <div class="p-5 rounded-2xl bg-red-50 border border-red-100">
                <p class="text-sm text-red-600 font-medium mb-1">Total Pengeluaran</p>
                <p class="text-2xl font-bold text-red-700">- Rp {{ number_format($laporan->total_pengeluaran, 0, ',', '.') }}</p>
            </div>

            <div class="p-5 rounded-2xl bg-blue-50 border border-blue-100">
                <p class="text-sm text-blue-600 font-medium mb-1">Saldo Akhir</p>
                <p class="text-2xl font-bold text-blue-700">Rp {{ number_format($laporan->saldo_akhir, 0, ',', '.') }}</p>
            </div>
        </div>

        @if(in_array($laporan->status, ['draft', 'returned']))
            <div class="border-t border-gray-100 pt-6 flex justify-end">
                <form method="POST" action="{{ route('bendahara.laporan-bulanan.submit', $laporan) }}" onsubmit="return confirm('Apakah Anda yakin ingin submit laporan ini? Transaksi pada periode ini akan dikunci dan tidak bisa diubah lagi.');">
                    @csrf
                    <button type="submit" class="rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Submit Laporan
                    </button>
                </form>
            </div>
        @else
            <div class="border-t border-gray-100 pt-6">
                <p class="text-sm text-gray-500">
                    <svg class="inline w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    Laporan ini sudah dikunci karena statusnya <strong>{{ ucfirst($laporan->status) }}</strong>. Transaksi bulan ini tidak dapat diubah lagi.
                </p>
            </div>
        @endif
    </div>
</div>
@endsection
