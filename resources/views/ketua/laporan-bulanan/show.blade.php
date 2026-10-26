@extends('layouts.app')
@section('title', 'Detail & Persetujuan Laporan Bulanan')
@section('page-title', 'Detail & Persetujuan Laporan Keuangan')

@section('content')
<div class="space-y-6">

    <!-- Alert Sukses / Error -->
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

    @if($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm font-medium text-red-800">
            <p class="font-bold mb-1">Gagal memproses aksi:</p>
            <ul class="list-disc list-inside text-xs space-y-0.5">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Banner Status Laporan & Tombol Keputusan (Ketua Exclusives) -->
    @if($laporan->status === 'diajukan')
        <div class="flex flex-col gap-4 rounded-2xl border border-blue-200 bg-blue-50 p-5 md:flex-row md:items-center md:justify-between">
            <div class="flex items-start gap-3">
                <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="text-base font-bold text-blue-900">Laporan Menunggu Persetujuan Anda</h4>
                    <p class="mt-0.5 text-sm text-blue-700">
                        Diajukan oleh <span class="font-semibold text-blue-900">{{ $laporan->submitter?->nama ?? $laporan->submitter?->name ?? 'Bendahara' }}</span> pada {{ $laporan->submitted_at ? $laporan->submitted_at->format('d/m/Y H:i') : '-' }} WIB
                    </p>
                    <p class="mt-0.5 text-xs text-blue-600">Silakan tinjau rincian keuangan di bawah. Anda dapat menyetujui atau mengembalikan laporan jika terdapat ketidaksesuaian.</p>
                </div>
            </div>
            <!-- Tombol Aksi Ketua -->
            <div class="flex items-center gap-2 self-end md:self-auto flex-shrink-0">
                <button type="button" onclick="document.getElementById('modalReturn').classList.remove('hidden')" class="inline-flex items-center gap-1.5 rounded-xl border border-red-300 bg-white px-4 py-2.5 text-sm font-semibold text-red-600 shadow-sm transition hover:bg-red-50">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                    <span>Kembalikan</span>
                </button>
                <form method="POST" action="{{ route('ketua.laporan-bulanan.approve', $laporan) }}" onsubmit="return confirm('Yakin ingin menyetujui laporan ini? Aksi ini akan mengesahkan dan mengunci laporan secara permanen.');">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl bg-teal-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-teal-700">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Setujui Laporan</span>
                    </button>
                </form>
            </div>
        </div>
    @elseif($laporan->status === 'dikembalikan')
        <div class="flex items-start gap-3 rounded-2xl border border-red-200 bg-red-50 p-5">
            <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-600">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div>
                <h4 class="text-base font-bold text-red-900">Laporan Telah Dikembalikan ke Bendahara</h4>
                <p class="mt-1 text-sm font-medium text-red-800">Catatan Perbaikan: "{{ $laporan->catatan_return }}"</p>
                <p class="mt-1 text-xs text-red-600">
                    Dikembalikan oleh {{ $laporan->returner?->nama ?? $laporan->returner?->name ?? 'Ketua' }} pada {{ $laporan->returned_at ? $laporan->returned_at->format('d/m/Y H:i') : '-' }} WIB
                </p>
            </div>
        </div>
    @elseif($laporan->status === 'disetujui')
        <div class="flex items-start gap-3 rounded-2xl border border-green-200 bg-green-50 p-5">
            <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-green-100 text-green-600">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h4 class="text-base font-bold text-green-900">Laporan Resmi Disetujui</h4>
                <p class="mt-0.5 text-sm text-green-700">Laporan periode ini telah sah, final, dan terkunci.</p>
                <p class="mt-1 text-xs text-green-600">
                    Disetujui oleh {{ $laporan->approver?->nama ?? $laporan->approver?->name ?? 'Ketua' }} pada {{ $laporan->approved_at ? $laporan->approved_at->format('d/m/Y H:i') : '-' }} WIB
                </p>
            </div>
        </div>
    @elseif($laporan->status === 'draft')
        <div class="flex items-start gap-3 rounded-2xl border border-gray-200 bg-gray-50 p-5">
            <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-gray-200 text-gray-600">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <div>
                <h4 class="text-base font-bold text-gray-800">Status Laporan: Draft</h4>
                <p class="mt-0.5 text-xs text-gray-500">Laporan ini masih berstatus draft dan belum diajukan secara resmi oleh Bendahara.</p>
            </div>
        </div>
    @endif

    <!-- Kotak Utama Konten -->
    <div class="rounded-2xl border border-gray-200 bg-white p-4 sm:p-6">
        
        <!-- Header & Action Buttons -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-gray-200 pb-5">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <a href="{{ route('ketua.laporan-bulanan.index') }}" class="text-xs font-semibold text-teal-600 hover:text-teal-800 flex items-center gap-1">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Kembali ke Daftar Laporan
                    </a>
                </div>
                <h3 class="text-lg font-bold text-gray-900">
                    Ringkasan Keuangan: {{ \Carbon\Carbon::create()->month((int)$laporan->bulan)->translatedFormat('F') }} {{ $laporan->tahun }}
                </h3>
            </div>

            <!-- Group Tombol Aksi -->
            <div class="flex items-center gap-2 flex-shrink-0">
                <!-- Tombol Cetak PDF -->
                <a href="{{ route('ketua.laporan-bulanan.cetak', $laporan) }}" target="_blank" class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-gray-50 px-3.5 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-100" title="Cetak PDF">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    <span>Cetak PDF</span>
                </a>
            </div>
        </div>

        <!-- Cards Statistik Keuangan -->
        <div class="my-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-xl border border-gray-100 bg-gray-50 p-4">
                <p class="text-xs font-semibold text-gray-500">Saldo Awal</p>
                <p class="mt-1 text-xl font-bold text-gray-900">Rp {{ number_format($laporan->saldo_awal, 0, ',', '.') }}</p>
            </div>
            <div class="rounded-xl border border-emerald-100 bg-emerald-50/60 p-4">
                <p class="text-xs font-semibold text-emerald-700">Total Pemasukan</p>
                <p class="mt-1 text-xl font-bold text-emerald-700">+ Rp {{ number_format($laporan->total_pemasukan, 0, ',', '.') }}</p>
            </div>
            <div class="rounded-xl border border-rose-100 bg-rose-50/60 p-4">
                <p class="text-xs font-semibold text-rose-700">Total Pengeluaran</p>
                <p class="mt-1 text-xl font-bold text-rose-700">- Rp {{ number_format($laporan->total_pengeluaran, 0, ',', '.') }}</p>
            </div>
            <div class="rounded-xl border border-teal-100 bg-teal-50/60 p-4">
                <p class="text-xs font-semibold text-teal-700">Saldo Akhir</p>
                <p class="mt-1 text-xl font-bold text-teal-900">Rp {{ number_format($laporan->saldo_akhir, 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Rincian Kategori -->
        <div class="mb-8 rounded-xl border border-gray-100 bg-gray-50/50 p-4 sm:p-5">
            <h4 class="mb-4 text-base font-bold text-gray-900">Rincian Berdasarkan Kategori</h4>
            <div class="grid gap-6 sm:grid-cols-2">
                <!-- Pemasukan -->
                <div class="rounded-xl border border-gray-200 bg-white p-4">
                    <h5 class="mb-3 border-b border-gray-100 pb-2 text-xs font-bold uppercase tracking-wider text-emerald-600">Pemasukan</h5>
                    <ul class="divide-y divide-gray-50 space-y-2">
                        @forelse($ringkasan->where('jenis', 'pemasukan') as $kategori)
                            <li class="flex items-center justify-between pt-2 text-sm">
                                <span class="text-gray-600">{{ $kategori->kategori }}</span>
                                <span class="font-semibold text-gray-900">Rp {{ number_format($kategori->total, 0, ',', '.') }}</span>
                            </li>
                        @empty
                            <li class="py-2 text-sm text-gray-400">Tidak ada pemasukan</li>
                        @endforelse
                    </ul>
                </div>

                <!-- Pengeluaran -->
                <div class="rounded-xl border border-gray-200 bg-white p-4">
                    <h5 class="mb-3 border-b border-gray-100 pb-2 text-xs font-bold uppercase tracking-wider text-rose-600">Pengeluaran</h5>
                    <ul class="divide-y divide-gray-50 space-y-2">
                        @forelse($ringkasan->where('jenis', 'pengeluaran') as $kategori)
                            <li class="flex items-center justify-between pt-2 text-sm">
                                <span class="text-gray-600">{{ $kategori->kategori }}</span>
                                <span class="font-semibold text-gray-900">Rp {{ number_format($kategori->total, 0, ',', '.') }}</span>
                            </li>
                        @empty
                            <li class="py-2 text-sm text-gray-400">Tidak ada pengeluaran</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <!-- Tabel Transaksi -->
        <div>
            <h4 class="mb-4 text-base font-bold text-gray-900">Daftar Transaksi ({{ $transaksis->count() }} Transaksi)</h4>
            
            @if($transaksis->isNotEmpty())
                <div class="overflow-x-auto rounded-xl border border-gray-200 custom-scrollbar">
                    <table class="w-full text-left text-sm whitespace-nowrap">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 font-semibold text-gray-700">Tanggal</th>
                                <th class="px-6 py-4 font-semibold text-gray-700">Keterangan</th>
                                <th class="px-6 py-4 font-semibold text-gray-700">Kategori</th>
                                <th class="px-6 py-4 font-semibold text-gray-700 text-right">Pemasukan</th>
                                <th class="px-6 py-4 font-semibold text-gray-700 text-right">Pengeluaran</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($transaksis as $trx)
                                <tr class="transition-colors hover:bg-gray-50">
                                    <td class="px-6 py-4 text-gray-600">
                                        {{ \Carbon\Carbon::parse($trx->tanggal)->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ $trx->keterangan }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex rounded-md bg-gray-100 px-2 py-1 text-xs font-semibold text-gray-700">
                                            {{ $trx->kategori }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right font-medium text-emerald-600">
                                        {{ $trx->jenis === 'pemasukan' ? '+ Rp ' . number_format($trx->nominal, 0, ',', '.') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-right font-medium text-rose-600">
                                        {{ $trx->jenis === 'pengeluaran' ? '- Rp ' . number_format($trx->nominal, 0, ',', '.') : '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="flex min-h-[200px] flex-col items-center justify-center gap-2 rounded-xl border border-dashed border-gray-200 p-8 text-center text-gray-500">
                    <p class="text-base font-semibold text-gray-900">Tidak ada transaksi.</p>
                    <span class="text-xs text-gray-400">Belum ada transaksi yang tercatat pada periode ini.</span>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Return (Ketua Exclusive) -->
    <div id="modalReturn" class="fixed inset-0 z-[100] hidden">
        <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm" onclick="document.getElementById('modalReturn').classList.add('hidden')"></div>
        <div class="absolute top-1/2 left-1/2 w-full max-w-lg -translate-x-1/2 -translate-y-1/2 rounded-2xl bg-white p-6 shadow-xl sm:p-8">
            <div class="mb-4 flex items-center justify-between border-b border-gray-100 pb-3">
                <h3 class="text-lg font-bold text-gray-900">Kembalikan Laporan ke Bendahara</h3>
                <button type="button" onclick="document.getElementById('modalReturn').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <form method="POST" action="{{ route('ketua.laporan-bulanan.return', $laporan) }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Catatan Perbaikan <span class="text-red-500">*</span></label>
                    <textarea name="catatan_return" rows="4" required placeholder="Tuliskan catatan perbaikan atau alasan pengembalian laporan..."
                              class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-red-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/20"></textarea>
                    <p class="mt-1 text-xs text-gray-500">Berikan instruksi yang jelas agar Bendahara dapat melakukan revisi secara tepat (minimal 5 karakter).</p>
                </div>
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="button" onclick="document.getElementById('modalReturn').classList.add('hidden')" class="rounded-xl px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100 transition">Batal</button>
                    <button type="submit" class="rounded-xl bg-red-600 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-700 transition">Kirim Catatan ke Bendahara</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
