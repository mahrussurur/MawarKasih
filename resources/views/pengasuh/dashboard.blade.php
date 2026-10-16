@extends('layouts.app')

@section('title', 'Dashboard Pengasuh')
@section('page-title', 'Dashboard')

@section('content')
<div>
    <div class="mb-6">
        <h2 class="text-2xl font-extrabold text-gray-900">Selamat Datang, {{ Auth::user()->nama }}!</h2>
        <p class="mt-1 text-sm font-medium text-gray-500">Berikut adalah ringkasan data anak asuh dan alumni panti.</p>
    </div>
    
    <!-- Distribusi Data -->
    <div class="mb-6 grid gap-4 md:grid-cols-2">
        <!-- Total Anak Asuh -->
        <div class="group rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md">
            <div class="flex items-center gap-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-100 text-blue-600">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-gray-500">Total Anak Asuh</p>
                    <p class="mt-1 text-3xl font-extrabold text-gray-900">{{ $totalAnak ?? 0 }}</p>
                </div>
            </div>
            <a href="{{ route('pengasuh.anak-asuh.index') }}" class="mt-5 block w-full rounded-xl bg-blue-600 px-3 py-2.5 text-center text-sm font-bold text-white transition hover:bg-blue-700">Lihat Data</a>
        </div>

        <!-- Total Alumni -->
        <div class="group rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md">
            <div class="flex items-center gap-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-600">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0v6" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-gray-500">Total Alumni</p>
                    <p class="mt-1 text-3xl font-extrabold text-gray-900">{{ $totalAlumni ?? 0 }}</p>
                </div>
            </div>
            <a href="{{ route('pengasuh.alumni.index') }}" class="mt-5 block w-full rounded-xl bg-emerald-600 px-3 py-2.5 text-center text-sm font-bold text-white transition hover:bg-emerald-700">Lihat Data</a>
        </div>
    </div>
    
    <div class="grid gap-5 md:grid-cols-2">
        <!-- Anak Asuh Baru Terdaftar Tahun Ini -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6">
            <div class="flex flex-col gap-4 border-b border-gray-200 pb-4 lg:flex-row lg:items-center lg:justify-between">
                <h3 class="text-base font-extrabold text-gray-900">Anak Asuh Baru {{ now()->year }}</h3>
                <a href="{{ route('pengasuh.anak-asuh.index') }}" class="text-sm font-bold text-blue-600 hover:text-blue-700">Lihat Semua →</a>
            </div>

            @if(isset($anakTahunIni) && $anakTahunIni->count() > 0)
            <div class="divide-y divide-gray-100">
                @foreach($anakTahunIni as $anak)
                <div class="flex items-center gap-3 py-3">
                    <div class="h-9 w-9 flex-shrink-0 rounded-full overflow-hidden bg-gray-100">
                        @if($anak->foto)
                            <img src="{{ Storage::url($anak->foto) }}" alt="Foto" class="h-full w-full object-cover">
                        @else
                            <div class="flex h-full w-full items-center justify-center text-xs font-bold text-gray-400">{{ strtoupper(substr($anak->nama, 0, 1)) }}</div>
                        @endif
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $anak->nama }}</p>
                        <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($anak->tanggal_lahir)->age }} Tahun · {{ $anak->sekolah ?? '-' }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="flex min-h-[200px] flex-col items-center justify-center gap-2 text-center text-gray-500">
                <svg class="h-10 w-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                <p class="text-sm font-semibold text-gray-900">Belum ada data</p>
                <span class="text-xs text-gray-500">Belum ada anak asuh terdaftar tahun {{ now()->year }}</span>
            </div>
            @endif
        </div>

        <!-- Alumni Ditambahkan Tahun Ini -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6">
            <div class="flex flex-col gap-4 border-b border-gray-200 pb-4 lg:flex-row lg:items-center lg:justify-between">
                <h3 class="text-base font-extrabold text-gray-900">Alumni Baru {{ now()->year }}</h3>
                <a href="{{ route('pengasuh.alumni.index') }}" class="text-sm font-bold text-emerald-600 hover:text-emerald-700">Lihat Semua →</a>
            </div>

            @if(isset($alumniTahunIni) && $alumniTahunIni->count() > 0)
            <div class="divide-y divide-gray-100">
                @foreach($alumniTahunIni as $alumni)
                <div class="flex items-center gap-3 py-3">
                    <div class="h-9 w-9 flex-shrink-0 rounded-full overflow-hidden bg-gray-100">
                        @if($alumni->foto)
                            <img src="{{ Storage::url($alumni->foto) }}" alt="Foto" class="h-full w-full object-cover">
                        @else
                            <div class="flex h-full w-full items-center justify-center text-xs font-bold text-gray-400">{{ strtoupper(substr($alumni->nama, 0, 1)) }}</div>
                        @endif
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $alumni->nama }}</p>
                        <p class="text-xs text-gray-500">{{ $alumni->pendidikan_terakhir ?? '-' }} · Keluar {{ \Carbon\Carbon::parse($alumni->tanggal_keluar)->format('d M Y') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="flex min-h-[200px] flex-col items-center justify-center gap-2 text-center text-gray-500">
                <svg class="h-10 w-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5zm0 0v6" /></svg>
                <p class="text-sm font-semibold text-gray-900">Belum ada data</p>
                <span class="text-xs text-gray-500">Belum ada alumni ditambahkan tahun {{ now()->year }}</span>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
