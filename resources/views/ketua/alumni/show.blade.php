@extends('layouts.app')
@section('page-title', 'Data Alumni')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Main Content -->
    <div class="overflow-hidden rounded-2xl bg-white shadow-sm border border-gray-200">
        <!-- Cover & Profile Image -->
        <div class="relative h-44 bg-gradient-to-r from-purple-600 to-purple-800">
            <!-- Header: Judul + Tombol di dalam cover -->
            <div class="absolute inset-x-0 top-0 flex flex-row items-start justify-between gap-3 px-6 pt-5">
                <div>
                    <h2 class="text-xl font-bold text-white sm:text-2xl">Detail Profil Alumni</h2>
                    <p class="text-sm text-purple-200">Informasi lengkap data diri alumni (akses baca-saja).</p>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                    <!-- Tombol Kembali -->
                    <a href="{{ route('ketua.alumni.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-white/20 backdrop-blur-sm border border-white/30 p-2.5 text-sm font-semibold text-white shadow-sm hover:bg-white/30 transition sm:px-3 sm:py-2" title="Kembali">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        <span class="hidden sm:inline">Kembali</span>
                    </a>
                </div>
            </div>
            <!-- Foto profil di bawah cover -->
            <div class="absolute -bottom-12 left-6 sm:-bottom-16 sm:left-8">
                <div class="rounded-full bg-white p-1.5 sm:p-2 shadow-lg">
                    @if($alumni->foto)
                        <img src="{{ asset('storage/' . $alumni->foto) }}" alt="Foto {{ $alumni->nama }}" class="h-24 w-24 rounded-full object-cover sm:h-32 sm:w-32 cursor-pointer border-4 border-white shadow-inner" onclick="openImagePreview('{{ asset('storage/' . $alumni->foto) }}')">
                    @else
                        <div class="flex h-24 w-24 sm:h-32 sm:w-32 items-center justify-center rounded-full bg-gradient-to-br from-purple-500 to-indigo-600 text-3xl sm:text-4xl font-bold text-white border-4 border-white shadow-inner">
                            {{ strtoupper(substr($alumni->nama, 0, 1)) }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Basic Info Header -->
        <div class="px-6 pb-6 pt-16 sm:px-8 sm:pt-20">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">{{ $alumni->nama }}</h1>
                    <p class="text-sm font-medium text-gray-500 mt-1">Nama Panggilan: <span class="font-semibold text-gray-800">{{ $alumni->nama_panggilan ?? '-' }}</span></p>
                </div>
                <span class="inline-flex items-center rounded-full bg-purple-50 px-3 py-1 text-sm font-medium text-purple-700 ring-1 ring-inset ring-purple-600/20">
                    Alumni Panti
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 divide-y divide-gray-100 lg:grid-cols-3 lg:divide-x lg:divide-y-0 border-t border-gray-100">
            
            <!-- Left Column: Identitas Utama -->
            <div class="p-6 sm:p-8 lg:col-span-2 space-y-8">
                <!-- Data Pribadi -->
                <section>
                    <h3 class="flex items-center text-base font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">
                        <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Informasi Pribadi
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Tempat, Tanggal Lahir</p>
                            <p class="mt-1 text-sm text-gray-900 font-semibold">
                                {{ $alumni->tempat_lahir ?? '-' }}, {{ $alumni->tanggal_lahir ? \Carbon\Carbon::parse($alumni->tanggal_lahir)->format('d F Y') : '-' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Jenis Kelamin</p>
                            <p class="mt-1 text-sm text-gray-900 font-semibold">
                                {{ $alumni->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Status Sosial Anak</p>
                            <p class="mt-1">
                                <span class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-sm font-medium text-gray-700 ring-1 ring-inset ring-gray-200">
                                    {{ $alumni->status_social_anak ?? '-' }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Tinggal di LKSA Sejak</p>
                            <p class="mt-1 text-sm text-gray-900 font-semibold">{{ $alumni->tinggal_di_lksa_sejak ?? '-' }}</p>
                        </div>
                    </div>
                </section>

                <!-- Data Orang Tua -->
                <section>
                    <h3 class="flex items-center text-base font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">
                        <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Informasi Orang Tua
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Nama Ayah</p>
                            <p class="mt-1 text-sm text-gray-900 font-semibold">{{ $alumni->nama_ayah ?? 'Tidak ada data' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Nama Ibu</p>
                            <p class="mt-1 text-sm text-gray-900 font-semibold">{{ $alumni->nama_ibu ?? 'Tidak ada data' }}</p>
                        </div>
                    </div>
                </section>
                
                <!-- Histori Pendidikan di LKSA -->
                <section>
                    <h3 class="flex items-center text-base font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">
                        <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 14l9-5-9-5-9 5 9 5z" /><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0v6" /></svg>
                        Pendidikan di LKSA
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Sekolah Terakhir (di LKSA)</p>
                            <p class="mt-1 text-sm text-gray-900 font-semibold">{{ $alumni->sekolah ?? 'Tidak ada data' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Kelas</p>
                            <p class="mt-1 text-sm text-gray-900 font-semibold">{{ $alumni->kelas ?? '-' }}</p>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Right Column: Informasi Pasca LKSA -->
            <div class="bg-gray-50/50 p-6 sm:p-8 space-y-8">
                <section>
                    <h3 class="flex items-center text-base font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">
                        <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        Informasi Pasca LKSA
                    </h3>
                    
                    <div class="space-y-5">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Keluar</p>
                            <p class="mt-1 text-sm font-semibold text-gray-900">
                                {{ $alumni->tanggal_keluar ? \Carbon\Carbon::parse($alumni->tanggal_keluar)->format('d F Y') : '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Pendidikan Terakhir</p>
                            <p class="mt-1 text-sm font-semibold text-gray-900">{{ $alumni->pendidikan_terakhir ?? '-' }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Sekolah Terakhir</p>
                            <p class="mt-1 text-sm font-semibold text-gray-900">{{ $alumni->nama_sekolah_terakhir ?? '-' }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Pekerjaan</p>
                            <p class="mt-1 text-sm font-semibold text-gray-900">{{ $alumni->pekerjaan ?? '-' }}</p>
                        </div>
                        
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor HP / WhatsApp</p>
                            <p class="mt-1 text-sm font-semibold text-gray-900">{{ $alumni->no_hp ?? '-' }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat Saat Ini</p>
                            <p class="mt-1 text-sm text-gray-900 leading-relaxed">{{ $alumni->alamat ?? '-' }}</p>
                        </div>
                        
                        @if($alumni->catatan)
                        <div class="pt-4 mt-2 border-t border-gray-200">
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Catatan Tambahan</p>
                            <p class="mt-1 text-sm text-gray-900 leading-relaxed italic bg-yellow-50 p-3 rounded-lg border border-yellow-100">"{{ $alumni->catatan }}"</p>
                        </div>
                        @endif
                    </div>
                </section>
            </div>

        </div>
    </div>
</div>
@endsection