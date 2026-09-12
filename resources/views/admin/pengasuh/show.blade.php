@extends('layouts.app')
@section('page-title', 'Data Pengasuh')
@section('title', 'Data Pengasuh | Panti Asuhan Mawar Kasih')

@section('content')
<div class="max-w-3xl mx-auto overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm my-4">
        
        <!-- Header -->
        <div class="border-b border-gray-200 bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex justify-between items-center gap-4">
            <div class="min-w-0">
                <h2 class="text-lg font-bold text-white truncate">Detail Pengasuh</h2>
                <p class="text-xs md:text-sm text-gray-200">Informasi lengkap pengasuh.</p>
            </div>
            <a href="{{ route('pengasuh.index') }}" class="text-xs md:text-sm font-semibold text-white hover:text-gray-200 flex items-center transition-colors whitespace-nowrap">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="hidden sm:inline">Kembali</span>
            </a>
        </div>
        
        <div class="p-4 md:p-6">
            <!-- Layout: Foto di atas (mobile) / kiri (desktop) -->
            <div class="flex flex-col md:flex-row gap-6 items-center md:items-start">
            
                <!-- Foto Section -->
                <div class="flex flex-col items-center gap-3 flex-shrink-0">
                    <button type="button"
                            onclick="openImagePreview('{{ asset('storage/'.$pengasuh->foto) }}')"
                            aria-label="Perbesar foto {{ $pengasuh->nama }}">
                        <img src="{{ asset('storage/'.$pengasuh->foto) }}"
                            class="w-32 h-32 md:w-40 md:h-40 rounded-lg object-cover border-2 border-gray-200 cursor-pointer transition duration-200 hover:scale-105"
                            alt="Foto {{ $pengasuh->nama }}"
                            title="Klik untuk perbesar">
                    </button>
                    <div class="text-center">
                        <span class="text-base md:text-lg font-bold text-gray-900 block truncate max-w-[180px] md:max-w-none">
                            {{ $pengasuh->nama }}
                        </span>
                        <span class="inline-block mt-1 px-3 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                            {{ $pengasuh->jabatan }}
                        </span>
                    </div>
                </div>
                
                <!-- Divider horizontal (mobile only) -->
                <div class="md:hidden w-full h-px bg-gray-200"></div>
                
                <!-- Detail Section -->
                <div class="w-full space-y-2.5">

                    <!-- Tempat Lahir -->
                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-28 flex-shrink-0">Tempat Lahir</span>
                            <span class="text-gray-400">:</span>
                            <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">{{ $pengasuh->tempat_lahir ?? '-' }}</span>
                        </div>
                    </div>

                    <!-- Tanggal Lahir -->
                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-28 flex-shrink-0">Tanggal Lahir</span>
                            <span class="text-gray-400">:</span>
                            <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">
                                {{ \Carbon\Carbon::parse($pengasuh->tanggal_lahir)->isoFormat('D MMM Y') }}
                            </span>
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-28 flex-shrink-0">Alamat</span>
                            <span class="text-gray-400">:</span>
                            <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">{{ $pengasuh->alamat ?? '-' }}</span>
                        </div>
                    </div>
                    
                    <!-- Jenis Kelamin -->
                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-28 flex-shrink-0">Jenis Kelamin</span>
                            <span class="text-gray-400">:</span>
                            <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">{{ $pengasuh->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                        </div>
                    </div>

                    <!-- No. HP -->
                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-28 flex-shrink-0">No. HP</span>
                            <span class="text-gray-400">:</span>
                            <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">{{ $pengasuh->no_hp }}</span>
                        </div>
                    </div>
                </div>
            </div>

        <!-- Tombol Aksi -->
        <div class="mt-6 pt-4 border-t border-gray-200 flex flex-wrap gap-3 justify-center">
            <a href="{{ route('pengasuh.edit', $pengasuh->id) }}" 
            class="rounded-xl px-5 py-2 text-sm font-semibold text-amber-600 border border-amber-500 bg-yellow-100 transition hover:bg-amber-500 hover:text-white">
                Edit
            </a>
            <button type="button"
                    onclick="openDeleteModal(this)"
                    data-delete-route="{{ route('pengasuh.destroy', $pengasuh->id) }}"
                    data-name="{{ $pengasuh->nama }}"
                    class="rounded-xl px-5 py-2 text-sm font-semibold text-red-500 border border-red-500 bg-red-100 transition hover:bg-red-500 hover:text-white">
                Hapus
            </button>
        </div>
        </div>
    </div>
</div>


@endsection
