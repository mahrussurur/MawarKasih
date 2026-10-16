@extends('layouts.app')
@section('page-title', 'Laporan Keuangan Bulanan')

@section('content')
<!-- Kotak Utama Konten -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6">
    
    <!-- Filter & Header -->
    <div class="flex flex-col gap-4 border-b border-gray-200 pb-4 lg:flex-row lg:items-center lg:justify-between">
        <h3 class="text-base font-bold text-gray-900">Daftar Laporan Keuangan</h3>

        <!-- Filter Status -->
        <form method="GET" action="{{ route('sekretaris.laporan-bulanan.index') }}" class="w-full lg:w-auto">
            <select name="status" onchange="this.form.submit()" class="w-full appearance-none rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm font-semibold text-gray-600 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-brand-500 lg:w-52">
                <option value="">Semua Status</option>
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="diajukan" {{ request('status') === 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                <option value="dikembalikan" {{ request('status') === 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                <option value="disetujui" {{ request('status') === 'disetujui' ? 'selected' : '' }}>Disetujui</option>
            </select>
        </form>
    </div>

    <!-- Table Data -->
    @if($laporans->isNotEmpty())
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-center font-semibold text-gray-700 w-12">No</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Periode</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Pemasukan</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Pengeluaran</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Saldo Akhir</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-4 text-center font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($laporans as $index => $laporan)
                        <tr class="transition-colors hover:bg-gray-50">
                            <td class="px-6 py-4 text-center text-gray-700">{{ $laporans->firstItem() + $index }}</td>
                            <td class="px-6 py-4 font-semibold text-gray-900">
                                {{ \Carbon\Carbon::create()->month($laporan->bulan)->translatedFormat('F') }} {{ $laporan->tahun }}
                            </td>
                            <td class="px-6 py-4 font-medium text-emerald-600">
                                + Rp{{ number_format($laporan->total_pemasukan, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 font-medium text-rose-600">
                                - Rp{{ number_format($laporan->total_pengeluaran, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-900">
                                Rp{{ number_format($laporan->saldo_akhir, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4">
                                @if($laporan->status === 'draft')
                                    <span class="inline-flex rounded-md bg-gray-50 px-2 py-1 text-xs font-semibold text-gray-700 ring-1 ring-inset ring-gray-600/20">Draft</span>
                                @elseif($laporan->status === 'diajukan')
                                    <span class="inline-flex rounded-md bg-blue-50 px-2 py-1 text-xs font-semibold text-blue-700 ring-1 ring-inset ring-blue-600/20">Diajukan</span>
                                @elseif($laporan->status === 'dikembalikan')
                                    <span class="inline-flex rounded-md bg-red-50 px-2 py-1 text-xs font-semibold text-red-700 ring-1 ring-inset ring-red-600/10">Dikembalikan</span>
                                @elseif($laporan->status === 'disetujui')
                                    <span class="inline-flex rounded-md bg-green-50 px-2 py-1 text-xs font-semibold text-green-700 ring-1 ring-inset ring-green-600/20">Disetujui</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('sekretaris.laporan-bulanan.show', $laporan) }}"
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-blue-400 bg-blue-50 text-blue-600 transition hover:bg-blue-600 hover:text-white"
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

        @include('layouts.partials.admin._pagination', ['paginator' => $laporans])
    @else
        <div class="flex min-h-[300px] flex-col items-center justify-center gap-3 px-6 py-10 text-center text-gray-500">
            <p class="text-base font-semibold text-gray-900">Laporan tidak ditemukan.</p>
            <span class="text-sm">Belum ada laporan bulanan yang tercatat atau sesuai filter status.</span>
        </div>
    @endif
</div>
@endsection
