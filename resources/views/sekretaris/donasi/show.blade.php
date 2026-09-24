@extends('layouts.app')
@section('page-title', 'Detail Donasi')

@section('content')
<div class="max-w-3xl mx-auto overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        
        <!-- Header -->
        <div class="border-b border-gray-200 bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex justify-between items-center gap-4">
            <div class="min-w-0">
                <h2 class="text-lg font-bold text-white truncate">Detail Donasi</h2>
                <p class="text-xs md:text-sm text-gray-200">Informasi lengkap donasi.</p>
            </div>
            <a href="{{ route('sekretaris.donasi.index') }}" class="text-xs md:text-sm font-semibold text-white hover:text-gray-200 flex items-center transition-colors whitespace-nowrap">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="hidden sm:inline">Kembali</span>
            </a>
        </div>

        <div class="p-4 md:p-6">
            <div class="flex flex-col gap-6 items-center">
                
                <!-- Section kode & badge -->
                <div class="flex flex-col items-center gap-3 flex-shrink-0">
                    <div class="text-center">
                        <span class="text-base md:text-lg font-bold text-gray-900 block text-center whitespace-normal break-words max-w-full md:max-w-none px-2">
                            {{ $donasi->kode_donasi }}
                        </span><br>
                        <span class="inline-block mt-1 px-3 py-0.5 rounded-full text-xs font-semibold 
                        {{ $donasi->donatur_id ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-700' }}">
                            {{ $donasi->donatur_id ? 'Donatur Tetap' : 'Donatur Umum' }}
                        </span>
                    </div>
                </div>

                <div class="border-t border-gray-200 my-1 w-full"></div>

                <!-- Detail Section -->
                <div class="w-full space-y-2.5">

                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-28 flex-shrink-0">Nama Donatur</span>
                            <span class="text-gray-400">:</span>
                            <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">{{ $donasi->nama_donatur }}</span>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-28 flex-shrink-0">Nomor HP</span>
                            <span class="text-gray-400">:</span>
                            <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">{{ $donasi->no_hp ?? '-' }}</span>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-28 flex-shrink-0">Nominal</span>
                            <span class="text-gray-400">:</span>
                            <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">{{ $donasi->nominal_rupiah }}</span>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-28 flex-shrink-0">Tanggal</span>
                            <span class="text-gray-400">:</span>
                            <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">{{ \Carbon\Carbon::parse($donasi->tanggal)->format('d - m - Y') }}</span>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-28 flex-shrink-0">Keterangan</span>
                            <span class="text-gray-400">:</span>
                            <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">{{ $donasi->keterangan ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-28 flex-shrink-0">Metode Pembayaran</span>
                            <span class="text-gray-400">:</span>
                            <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">{{ ucfirst($donasi->metode_pembayaran) ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-28 flex-shrink-0">Status</span>
                            <span class="text-gray-400">:</span>
                            <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">
                                <span class="inline-flex items-center rounded-full px-3 py-1 text-[11px] font-semibold {{ $donasi->status === 'pending' ? 'bg-amber-100 text-amber-800' : ($donasi->status === 'diterima' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($donasi->status) }}
                                </span>
                            </span>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-28 flex-shrink-0">Catatan Admin</span>
                            <span class="text-gray-400">:</span>
                            <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">{{ $donasi->catatan_admin ?? '-' }}</span>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-28 flex-shrink-0">Bukti Transfer</span>
                            <span class="text-gray-400">:</span>
                            @if($donasi->bukti_transfer)
                                <div class="mt-1">
                                    <button type="button" class="inline-flex" onclick="openImagePreview('{{ Storage::url($donasi->bukti_transfer) }}')" aria-label="Perbesar bukti transfer {{ $donasi->kode_donasi }}">
                                        <img src="{{ Storage::url($donasi->bukti_transfer) }}" alt="Bukti transfer {{ $donasi->kode_donasi }}" class="h-32 w-32 rounded-lg border-2 border-gray-200 object-cover cursor-pointer transition duration-200 hover:scale-105">
                                    </button>
                                </div>
                            @else
                                <span class="text-sm text-gray-500 font-medium">-</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
