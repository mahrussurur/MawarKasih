@extends('layouts.app')
@section('page-title', 'Riwayat Donasi')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="overflow-hidden rounded-2xl bg-white shadow-sm border border-gray-200">

        {{-- Header / Banner --}}
        <div class="relative bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-6 sm:px-8 sm:py-7">
            <div class="flex flex-row items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-white sm:text-2xl">Detail Donasi</h2>
                    <p class="text-sm text-blue-100 mt-0.5">Informasi lengkap transaksi donasi Anda.</p>
                </div>
                {{-- Tombol Kembali --}}
                <a href="{{ route('donatur.donasi.index') }}"
                   class="inline-flex items-center gap-2 rounded-xl bg-white/20 backdrop-blur-sm border border-white/30 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-white/30 transition flex-shrink-0"
                   title="Kembali">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span class="hidden sm:inline">Kembali</span>
                </a>
            </div>
        </div>

        @if(session('success'))
        <div class="mx-6 mt-4 rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm font-medium text-emerald-700">
            {{ session('success') }}
        </div>
        @endif

        {{-- Layout Grid Content --}}
        <div class="grid grid-cols-1 divide-y divide-gray-100 lg:grid-cols-3 lg:divide-x lg:divide-y-0">

            {{-- Left Column: Rincian & Bukti --}}
            <div class="p-6 sm:p-8 lg:col-span-2 space-y-8">

                {{-- Rincian Transaksi --}}
                <section>
                    <h3 class="flex items-center text-base font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Rincian Transaksi
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Donatur</p>
                            <p class="mt-1 text-sm font-bold text-gray-900">{{ $donasi->nama_donatur ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor HP / WhatsApp</p>
                            <p class="mt-1 text-sm font-semibold text-gray-800">{{ $donasi->no_hp ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Nominal Donasi</p>
                            <p class="mt-1 text-base font-extrabold text-emerald-600">{{ $donasi->nominal_rupiah }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Metode Pembayaran</p>
                            <p class="mt-1 text-sm font-semibold text-gray-800">{{ ucfirst($donasi->metode_pembayaran ?? '-') }}</p>
                        </div>
                    </div>
                </section>

                {{-- Keterangan & Catatan --}}
                <section>
                    <h3 class="flex items-center text-base font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                        </svg>
                        Keterangan &amp; Catatan
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Keterangan Donasi</p>
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 text-sm text-gray-800 leading-relaxed break-words">
                                {{ $donasi->keterangan ?? 'Tidak ada keterangan.' }}
                            </div>
                        </div>
                        @if($donasi->catatan_admin)
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Catatan Admin</p>
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 text-sm text-gray-800 leading-relaxed break-words">
                                {{ $donasi->catatan_admin }}
                            </div>
                        </div>
                        @endif
                    </div>
                </section>

                {{-- Bukti Transfer --}}
                <section>
                    <h3 class="flex items-center text-base font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Bukti Transfer
                    </h3>
                    @if($donasi->bukti_transfer)
                        <div class="relative w-full aspect-video overflow-hidden rounded-xl border border-gray-200 bg-gray-100 shadow-sm flex items-center justify-center p-2">
                            <img src="{{ Storage::url($donasi->bukti_transfer) }}"
                                 alt="Bukti transfer {{ $donasi->kode_donasi }}"
                                 class="h-full w-full object-contain cursor-pointer"
                                 onclick="openImagePreview('{{ Storage::url($donasi->bukti_transfer) }}')"
                                 title="Klik untuk memperbesar">
                        </div>
                    @else
                        <div class="rounded-xl border border-dashed border-gray-200 bg-gray-50 p-6 text-center text-sm text-gray-400">
                            Tidak ada bukti transfer yang diunggah.
                        </div>
                    @endif

                    {{-- Upload Bukti (hanya jika pending) --}}
                    @if($donasi->status === 'pending')
                    <div class="mt-4 rounded-xl border-2 border-dashed border-blue-200 bg-blue-50 px-4 py-4">
                        <p class="text-sm font-semibold text-blue-700 mb-3">
                            {{ $donasi->bukti_transfer ? '🔄 Ganti Bukti Transfer' : '📎 Upload Bukti Transfer' }}
                        </p>
                        <form method="POST" action="{{ route('donatur.donasi.upload-bukti', $donasi->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="flex flex-col sm:flex-row gap-3">
                                <input type="file" name="bukti_transfer" accept="image/jpeg,image/png,image/jpg" required
                                       class="flex-1 rounded-xl border border-blue-200 bg-white px-3 py-2 text-sm file:mr-3 file:rounded-lg file:border-0 file:bg-blue-100 file:px-3 file:py-1 file:text-sm file:font-semibold file:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
                                <button type="submit"
                                        class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 whitespace-nowrap">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                    Upload
                                </button>
                            </div>
                            @error('bukti_transfer')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </form>
                    </div>
                    @endif
                </section>

            </div>

            {{-- Right Column: Informasi Status --}}
            <div class="bg-gray-50/50 p-6 sm:p-8 space-y-8">
                <section>
                    <h3 class="flex items-center text-base font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Informasi Status
                    </h3>

                    <div class="space-y-5">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Donasi</p>
                            <p class="mt-1 text-sm font-mono font-bold text-gray-900 leading-snug">{{ $donasi->kode_donasi }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe Donatur</p>
                            <p class="mt-1.5">
                                <span class="inline-flex items-center rounded-lg border px-2.5 py-1 text-xs font-semibold bg-emerald-50 text-emerald-700 border-emerald-100">
                                    Donatur Tetap
                                </span>
                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Status Transaksi</p>
                            <p class="mt-1.5">
                                <span class="inline-flex items-center rounded-lg border px-2.5 py-1 text-xs font-semibold
                                    {{ $donasi->status === 'pending'   ? 'bg-amber-50 text-amber-800 border-amber-200'   :
                                      ($donasi->status === 'diterima'  ? 'bg-emerald-50 text-emerald-800 border-emerald-200' :
                                                                         'bg-red-50 text-red-800 border-red-200') }}">
                                    {{ ucfirst($donasi->status) }}
                                </span>
                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Donasi</p>
                            <p class="mt-1.5">
                                <span class="inline-flex items-center gap-1.5 rounded-lg bg-blue-50 border border-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ \Carbon\Carbon::parse($donasi->tanggal)->format('d - m - Y') }}
                                </span>
                            </p>
                        </div>
                    </div>

                    {{-- Info penolakan --}}
                    @if($donasi->status === 'ditolak' && $donasi->catatan_admin)
                    <div class="mt-6 rounded-xl bg-red-50 border border-red-200 px-4 py-3">
                        <p class="text-xs font-semibold text-red-600 uppercase tracking-wider mb-1">Alasan Penolakan</p>
                        <p class="text-sm text-red-700">{{ $donasi->catatan_admin }}</p>
                    </div>
                    @endif
                </section>
            </div>

        </div>
    </div>
</div>
@endsection
