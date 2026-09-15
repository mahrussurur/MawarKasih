@extends('layouts.app')
@section('page-title', 'Detail Donasi')
@section('title', 'Detail Donasi | Panti Asuhan Mawar Kasih')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('donatur.donasi.index') }}"
           class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-500 hover:text-gray-800 transition">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Riwayat Donasi
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm font-medium text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-blue-200 uppercase tracking-wider">Kode Donasi</p>
                <h2 class="text-lg font-bold text-white mt-0.5">{{ $donasi->kode_donasi }}</h2>
            </div>
            @php
                $sc = ['pending'=>'bg-amber-100 text-amber-800','diterima'=>'bg-emerald-100 text-emerald-800','ditolak'=>'bg-red-100 text-red-800'];
            @endphp
            <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $sc[$donasi->status] ?? 'bg-gray-100 text-gray-700' }}">
                {{ ucfirst($donasi->status) }}
            </span>
        </div>

        <div class="p-6 space-y-3">
            {{-- Info Grid --}}
            @php
                $rows = [
                    'Nama Donatur'      => $donasi->nama_donatur ?? '-',
                    'Nomor HP'          => $donasi->no_hp ?? '-',
                    'Nominal'           => $donasi->nominal_rupiah,
                    'Tanggal'           => \Carbon\Carbon::parse($donasi->tanggal)->format('d M Y'),
                    'Metode Pembayaran' => ucfirst($donasi->metode_pembayaran ?? '-'),
                    'Keterangan'        => $donasi->keterangan ?? '-',
                    'Catatan Admin'     => $donasi->catatan_admin ?? '-',
                ];
            @endphp
            @foreach($rows as $label => $value)
            <div class="flex gap-3 rounded-xl bg-gray-50 border border-gray-100 px-4 py-3">
                <span class="w-36 flex-shrink-0 text-xs font-semibold text-gray-500 uppercase tracking-wider self-center">{{ $label }}</span>
                <span class="text-sm text-gray-900 font-medium">{{ $value }}</span>
            </div>
            @endforeach

            {{-- Bukti Transfer --}}
            <div class="rounded-xl bg-gray-50 border border-gray-100 px-4 py-3">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Bukti Transfer</p>
                @if($donasi->bukti_transfer)
                    <button type="button" onclick="openImagePreview('{{ Storage::url($donasi->bukti_transfer) }}')" aria-label="Perbesar bukti">
                        <img src="{{ Storage::url($donasi->bukti_transfer) }}"
                             alt="Bukti Transfer"
                             class="h-32 w-32 rounded-xl border border-gray-200 object-cover hover:scale-105 transition cursor-pointer">
                    </button>
                    @if($donasi->status === 'pending')
                        <p class="mt-2 text-xs text-gray-400">Klik gambar untuk perbesar. Anda bisa mengganti bukti selama status masih pending.</p>
                    @endif
                @else
                    <p class="text-sm text-gray-500 italic">Belum ada bukti transfer.</p>
                @endif
            </div>

            {{-- Upload Bukti (hanya jika pending) --}}
            @if($donasi->status === 'pending')
            <div class="rounded-xl border-2 border-dashed border-blue-200 bg-blue-50 px-4 py-4">
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

            @if($donasi->status === 'ditolak' && $donasi->catatan_admin)
            <div class="rounded-xl bg-red-50 border border-red-200 px-4 py-3">
                <p class="text-xs font-semibold text-red-600 uppercase tracking-wider mb-1">Alasan Penolakan</p>
                <p class="text-sm text-red-700">{{ $donasi->catatan_admin }}</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
