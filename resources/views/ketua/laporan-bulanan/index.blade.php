@extends('layouts.app')
@section('page-title', 'Laporan Keuangan Bulanan')

@section('content')
<div class="space-y-6">

    <!-- Alert Notifikasi -->
    @if(session('success'))
        <div class="rounded-xl border border-green-200 bg-green-50 p-4 text-sm font-semibold text-green-800 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm font-semibold text-red-800 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                <span>{{ session('error') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800">&times;</button>
        </div>
    @endif

    <!-- Kotak Utama Konten -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6">
        
        <!-- Filter & Header -->
        <div class="flex flex-col gap-4 border-b border-gray-200 pb-4 lg:flex-row lg:items-center lg:justify-between">
            <h3 class="text-base font-bold text-gray-900">Daftar Laporan Keuangan</h3>

            <!-- Filter Status -->
            <form method="GET" action="{{ route('ketua.laporan-bulanan.index') }}" class="w-full lg:w-auto">
                <select name="status" onchange="this.form.submit()" class="w-full appearance-none rounded-xl border border-gray-200 bg-gray-50 px-4 py-2 text-xs font-semibold text-gray-700 focus:border-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-500/20 lg:w-52">
                    <option value="">Semua Status</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="diajukan" {{ request('status') === 'diajukan' ? 'selected' : '' }}>Diajukan (Perlu Review)</option>
                    <option value="dikembalikan" {{ request('status') === 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                    <option value="disetujui" {{ request('status') === 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                </select>
            </form>
        </div>

        <!-- Table Data -->
        @if($laporans->isNotEmpty())
            <div class="overflow-x-auto mt-4 custom-scrollbar">
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
                                        <span class="inline-flex items-center gap-1.5 rounded-md bg-blue-50 px-2 py-1 text-xs font-semibold text-blue-700 ring-1 ring-inset ring-blue-600/20">
                                            <span class="h-1.5 w-1.5 rounded-full bg-blue-600 animate-pulse"></span>
                                            Diajukan
                                        </span>
                                    @elseif($laporan->status === 'dikembalikan')
                                        <span class="inline-flex rounded-md bg-red-50 px-2 py-1 text-xs font-semibold text-red-700 ring-1 ring-inset ring-red-600/10">Dikembalikan</span>
                                    @elseif($laporan->status === 'disetujui')
                                        <span class="inline-flex rounded-md bg-green-50 px-2 py-1 text-xs font-semibold text-green-700 ring-1 ring-inset ring-green-600/20">Disetujui</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('ketua.laporan-bulanan.show', $laporan) }}"
                                        class="inline-flex items-center gap-1 rounded-lg border border-teal-200 bg-teal-50 px-2.5 py-1.5 text-xs font-bold text-teal-700 transition hover:bg-teal-600 hover:text-white"
                                        title="Buka & Tinjau Laporan">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <span>Tinjau</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $laporans->links() }}
            </div>
        @else
            <div class="flex min-h-[250px] flex-col items-center justify-center gap-3 px-6 py-10 text-center text-gray-500">
                <svg class="h-10 w-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <p class="text-base font-semibold text-gray-900">Laporan tidak ditemukan.</p>
                <span class="text-xs text-gray-400">Belum ada laporan bulanan yang tercatat atau sesuai dengan filter status.</span>
            </div>
        @endif
    </div>

</div>
@endsection
