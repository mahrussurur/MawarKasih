@extends('layouts.app')
@section('title', 'Detail Anak Asuh')
@section('page-title', 'Detail Anak Asuh')

@section('content')
<div class="max-w-3xl mx-auto overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
    <!-- Header -->
    <div class="border-b border-gray-200 bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex justify-between items-center gap-4">
        <div class="min-w-0">
            <h2 class="text-lg font-bold text-white truncate">Detail Anak Asuh</h2>
            <p class="text-xs text-blue-100">Informasi lengkap anak asuh panti (akses baca-saja).</p>
        </div>
        <a href="{{ route('ketua.anak-asuh.index') }}" class="text-xs font-semibold text-white hover:text-blue-200 flex items-center transition-colors whitespace-nowrap">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>

    <div class="p-6">
        <div class="flex flex-col md:flex-row gap-6 items-center md:items-start">
            <!-- Foto Section -->
            <div class="flex flex-col items-center gap-3 flex-shrink-0">
                @if($anakAsuh->foto)
                    <button type="button"
                            onclick="openImagePreview('{{ asset('storage/'.$anakAsuh->foto) }}')"
                            aria-label="Perbesar foto {{ $anakAsuh->nama }}">
                        <img src="{{ asset('storage/'.$anakAsuh->foto) }}"
                             class="w-32 h-32 md:w-40 md:h-40 rounded-2xl object-cover border-2 border-gray-200 cursor-pointer transition duration-200 hover:scale-105"
                             alt="Foto {{ $anakAsuh->nama }}"
                             title="Klik untuk perbesar">
                    </button>
                @else
                    <div class="flex w-32 h-32 md:w-40 md:h-40 items-center justify-center rounded-2xl bg-blue-100 text-4xl font-extrabold text-blue-600 border border-blue-200">
                        {{ strtoupper(substr($anakAsuh->nama, 0, 1)) }}
                    </div>
                @endif
                <div class="text-center">
                    <span class="text-base font-bold text-gray-900 block truncate max-w-[200px]">
                        {{ $anakAsuh->nama }}
                    </span>
                    <span class="inline-block mt-1 px-3 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700">
                        {{ $anakAsuh->status_social_anak ?? '-' }}
                    </span>
                </div>
            </div>

            <!-- Detail Section -->
            <div class="w-full space-y-2.5 text-sm">
                <div class="bg-gray-50 rounded-xl px-4 py-3 border border-gray-100">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-semibold text-gray-500 w-36 shrink-0">Nama Panggilan</span>
                        <span class="text-gray-400">:</span>
                        <span class="font-medium text-gray-900">{{ $anakAsuh->nama_panggilan ?? '-' }}</span>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-xl px-4 py-3 border border-gray-100">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-semibold text-gray-500 w-36 shrink-0">Tempat, Tgl Lahir</span>
                        <span class="text-gray-400">:</span>
                        <span class="font-medium text-gray-900">
                            {{ $anakAsuh->tempat_lahir ?? '-' }}, {{ $anakAsuh->tanggal_lahir ? \Carbon\Carbon::parse($anakAsuh->tanggal_lahir)->format('d M Y') : '-' }}
                        </span>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-xl px-4 py-3 border border-gray-100">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-semibold text-gray-500 w-36 shrink-0">Jenis Kelamin</span>
                        <span class="text-gray-400">:</span>
                        <span class="font-medium text-gray-900">{{ $anakAsuh->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-xl px-4 py-3 border border-gray-100">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-semibold text-gray-500 w-36 shrink-0">Nama Ayah</span>
                        <span class="text-gray-400">:</span>
                        <span class="font-medium text-gray-900">{{ $anakAsuh->nama_ayah ?? '-' }}</span>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-xl px-4 py-3 border border-gray-100">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-semibold text-gray-500 w-36 shrink-0">Nama Ibu</span>
                        <span class="text-gray-400">:</span>
                        <span class="font-medium text-gray-900">{{ $anakAsuh->nama_ibu ?? '-' }}</span>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-xl px-4 py-3 border border-gray-100">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-semibold text-gray-500 w-36 shrink-0">Tinggal di LKSA Sejak</span>
                        <span class="text-gray-400">:</span>
                        <span class="font-medium text-gray-900">{{ $anakAsuh->tinggal_di_lksa_sejak ?? '-' }}</span>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-xl px-4 py-3 border border-gray-100">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-semibold text-gray-500 w-36 shrink-0">Pendidikan</span>
                        <span class="text-gray-400">:</span>
                        <span class="font-medium text-gray-900">{{ $anakAsuh->sekolah ?? '-' }} (Kelas {{ $anakAsuh->kelas ?? '-' }})</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
