@extends('layouts.app')
@section('page-title', 'Data Anak Asuh')
@section('title', 'Data Anak Asuh | Panti Asuhan Mawar Kasih')

@section('content')
<div class="max-w-3xl mx-auto overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
    
    <!-- Header -->
    <div class="border-b border-gray-200 bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex justify-between items-center gap-4">
        <div class="min-w-0">
            <h2 class="text-lg font-bold text-white truncate">Detail Anak Asuh</h2>
            <p class="text-xs md:text-sm text-gray-200">Informasi lengkap anak asuh.</p>
        </div>
        <a href="{{ route('pengasuh.anak-asuh.index') }}" class="text-xs md:text-sm font-semibold text-white hover:text-gray-200 flex items-center transition-colors whitespace-nowrap">
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
                        onclick="openImagePreview('{{ asset('storage/'.$anakAsuh->foto) }}')"
                        aria-label="Perbesar foto {{ $anakAsuh->nama }}">
                    <img src="{{ asset('storage/'.$anakAsuh->foto) }}"
                         class="w-32 h-32 md:w-40 md:h-40 rounded-lg object-cover border-2 border-gray-200 cursor-pointer transition duration-200 hover:scale-105"
                         alt="Foto {{ $anakAsuh->nama }}"
                         title="Klik untuk perbesar">
                </button>
                <div class="text-center">
                    <span class="text-base md:text-lg font-bold text-gray-900 block truncate max-w-[180px] md:max-w-none">
                        {{ $anakAsuh->nama }}
                    </span>
                    <span class="inline-block mt-1 px-3 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                        {{ $anakAsuh->status_social_anak }}
                    </span>
                </div>
            </div>
                        
            <!-- Divider horizontal (mobile only) -->
            <div class="md:hidden w-full h-px bg-gray-200"></div>

            <!-- Detail Section -->
            <div class="w-full space-y-2.5">
                
                <!-- Nama Panggilan -->
                <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-semibold text-gray-600 w-32 flex-shrink-0">Nama Panggilan</span>
                        <span class="text-gray-400">:</span>
                        <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">{{ $anakAsuh->nama_panggilan }}</span>
                    </div>
                </div>

                <!-- Tempat Lahir -->
                <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-semibold text-gray-600 w-32 flex-shrink-0">Tempat Lahir</span>
                        <span class="text-gray-400">:</span>
                        <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">{{ $anakAsuh->tempat_lahir }}</span>
                    </div>
                </div>

                <!-- Tanggal Lahir -->
                <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-semibold text-gray-600 w-32 flex-shrink-0">Tanggal Lahir</span>
                        <span class="text-gray-400">:</span>
                        <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">
                            {{ \Carbon\Carbon::parse($anakAsuh->tanggal_lahir)->isoFormat('D MMM Y') }}
                        </span>
                    </div>
                </div>

                <!-- Jenis Kelamin -->
                <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-semibold text-gray-600 w-32 flex-shrink-0">Jenis Kelamin</span>
                        <span class="text-gray-400">:</span>
                        <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">
                            {{ $anakAsuh->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </span>
                    </div>
                </div>

                <!-- Nama Ayah -->
                <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-semibold text-gray-600 w-32 flex-shrink-0">Nama Ayah</span>
                        <span class="text-gray-400">:</span>
                        <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">{{ $anakAsuh->nama_ayah ?? '-' }}</span>
                    </div>
                </div>

                <!-- Nama Ibu -->
                <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-semibold text-gray-600 w-32 flex-shrink-0">Nama Ibu</span>
                        <span class="text-gray-400">:</span>
                        <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">{{ $anakAsuh->nama_ibu ?? '-' }}</span>
                    </div>
                </div>

                <!-- Tinggal di LKSA -->
                <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-semibold text-gray-600 w-32 flex-shrink-0">Tinggal di LKSA Sejak</span>
                        <span class="text-gray-400">:</span>
                        <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">{{ $anakAsuh->tinggal_di_lksa_sejak }}</span>
                    </div>
                </div>

                <!-- Sekolah -->
                <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-semibold text-gray-600 w-32 flex-shrink-0">Sekolah</span>
                        <span class="text-gray-400">:</span>
                        <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">{{ $anakAsuh->sekolah }}</span>
                    </div>
                </div>

                <!-- Kelas -->
                <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-semibold text-gray-600 w-32 flex-shrink-0">Kelas</span>
                        <span class="text-gray-400">:</span>
                        <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">{{ $anakAsuh->kelas }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="mt-6 pt-4 border-t border-gray-200 flex flex-wrap gap-3 justify-center">
            <a href="{{ route('pengasuh.anak-asuh.edit', $anakAsuh->id) }}" 
            class="rounded-xl px-5 py-2 text-sm font-semibold text-amber-600 border border-amber-500 bg-yellow-100 transition hover:bg-amber-500 hover:text-white">
                Edit
            </a>
            <a href="{{ route('pengasuh.alumni.create', $anakAsuh->id) }}"
                class="rounded-xl px-5 py-2 text-sm font-semibold text-purple-600 border border-purple-500 bg-purple-100 transition hover:bg-purple-500 hover:text-white">
                Jadikan Alumni
            </a>
        </div>
    </div>
</div>

@endsection
