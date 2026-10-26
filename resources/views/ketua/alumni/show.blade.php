@extends('layouts.app')
@section('title', 'Detail Alumni')
@section('page-title', 'Detail Alumni')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-900">Detail Profil Alumni</h2>
            <p class="text-xs text-gray-500">Informasi lengkap data diri alumni (akses baca-saja).</p>
        </div>
        <a href="{{ route('ketua.alumni.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm border border-gray-200 hover:bg-gray-50">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    <!-- Main Card -->
    <div class="overflow-hidden rounded-2xl bg-white shadow-sm border border-gray-200">
        <!-- Banner -->
        <div class="relative h-28 bg-gradient-to-r from-violet-600 to-purple-800">
            <div class="absolute -bottom-10 left-6">
                <div class="rounded-2xl bg-white p-1.5 shadow-md">
                    @if($alumni->foto)
                        <img src="{{ asset('storage/' . $alumni->foto) }}" alt="Foto {{ $alumni->nama }}" class="h-20 w-20 rounded-xl object-cover cursor-pointer" onclick="openImagePreview('{{ asset('storage/' . $alumni->foto) }}')">
                    @else
                        <div class="flex h-20 w-20 items-center justify-center rounded-xl bg-violet-100 text-2xl font-extrabold text-violet-600">
                            {{ strtoupper(substr($alumni->nama, 0, 1)) }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="px-6 pb-6 pt-12">
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 border-b border-gray-100 pb-5">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $alumni->nama }}</h1>
                    <p class="text-xs text-gray-500 mt-0.5">Nama Panggilan: {{ $alumni->nama_panggilan ?? '-' }}</p>
                </div>
                <span class="inline-flex rounded-full bg-violet-50 px-3 py-1 text-xs font-bold text-violet-700 ring-1 ring-inset ring-violet-600/20">
                    Alumni Panti
                </span>
            </div>

            <!-- Detail Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 text-sm">
                <div class="space-y-4">
                    <h4 class="font-bold text-gray-900 border-b border-gray-100 pb-2">Data Pribadi</h4>
                    <div>
                        <p class="text-xs font-semibold text-gray-500">Tempat, Tanggal Lahir</p>
                        <p class="font-medium text-gray-900 mt-0.5">
                            {{ $alumni->tempat_lahir ?? '-' }}, {{ $alumni->tanggal_lahir ? \Carbon\Carbon::parse($alumni->tanggal_lahir)->format('d F Y') : '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500">Jenis Kelamin</p>
                        <p class="font-medium text-gray-900 mt-0.5">{{ $alumni->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500">No. WhatsApp / HP</p>
                        <p class="font-medium text-gray-900 mt-0.5">{{ $alumni->no_hp ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500">Alamat Saat Ini</p>
                        <p class="font-medium text-gray-900 mt-0.5">{{ $alumni->alamat ?? '-' }}</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <h4 class="font-bold text-gray-900 border-b border-gray-100 pb-2">Riwayat &amp; Status Terkini</h4>
                    <div>
                        <p class="text-xs font-semibold text-gray-500">Pendidikan Terakhir</p>
                        <p class="font-medium text-gray-900 mt-0.5">
                            {{ $alumni->pendidikan_terakhir ?? '-' }} &mdash; {{ $alumni->nama_sekolah_terakhir ?? '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500">Pekerjaan Saat Ini</p>
                        <p class="font-medium text-gray-900 mt-0.5">{{ $alumni->pekerjaan ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500">Tanggal Keluar dari Panti</p>
                        <p class="font-medium text-gray-900 mt-0.5">
                            {{ $alumni->tanggal_keluar ? \Carbon\Carbon::parse($alumni->tanggal_keluar)->format('d F Y') : '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500">Catatan Tambahan</p>
                        <p class="font-medium text-gray-700 mt-0.5">{{ $alumni->catatan ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
