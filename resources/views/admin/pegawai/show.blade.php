@extends('layouts.app')
@section('page-title', 'Data Pegawai')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Main Content -->
    <div class="overflow-hidden rounded-2xl bg-white shadow-sm border border-gray-200">
        <!-- Cover & Profile Image -->
        <div class="relative h-44 bg-gradient-to-r from-emerald-600 to-teal-700">
            <!-- Header: Judul + Tombol di dalam cover -->
            <div class="absolute inset-x-0 top-0 flex flex-row items-start justify-between gap-3 px-6 pt-5">
                <div>
                    <h2 class="text-xl font-bold text-white sm:text-2xl">Detail Profil Pegawai</h2>
                    <p class="text-sm text-emerald-200">Informasi lengkap data diri dan akun pegawai yayasan.</p>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                    <!-- Tombol Kembali -->
                    <a href="{{ route('admin.pegawai.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-white/20 backdrop-blur-sm border border-white/30 p-2.5 text-sm font-semibold text-white shadow-sm hover:bg-white/30 transition sm:px-3 sm:py-2" title="Kembali">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        <span class="hidden sm:inline">Kembali</span>
                    </a>
                </div>
            </div>
            <!-- Foto profil di bawah cover -->
            <div class="absolute -bottom-12 left-6 sm:-bottom-16 sm:left-8">
                <div class="rounded-full bg-white p-1.5 sm:p-2 shadow-lg">
                    @if($pegawai->foto)
                        <img src="{{ asset('storage/' . $pegawai->foto) }}" alt="Foto {{ $pegawai->nama }}" class="h-24 w-24 rounded-full object-cover sm:h-32 sm:w-32 cursor-pointer border-4 border-white" onclick="openImagePreview('{{ asset('storage/' . $pegawai->foto) }}')">
                    @else
                        <div class="flex h-24 w-24 sm:h-32 sm:w-32 items-center justify-center rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 text-3xl sm:text-4xl font-bold text-white border-4 border-white shadow-inner">
                            {{ strtoupper(substr($pegawai->nama, 0, 1)) }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Basic Info Header -->
        <div class="px-6 pb-6 pt-16 sm:px-8 sm:pt-20">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">{{ $pegawai->nama }}</h1>
                    <p class="text-sm font-medium text-gray-500 mt-1">Jabatan: <span class="font-semibold text-gray-800">{{ $pegawai->jabatan ?? '-' }}</span></p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 divide-y divide-gray-100 lg:grid-cols-3 lg:divide-x lg:divide-y-0 border-t border-gray-100">
            
            <!-- Left Column: Identitas Utama -->
            <div class="p-6 sm:p-8 lg:col-span-2 space-y-8">
                <!-- Data Pribadi -->
                <section>
                    <h3 class="flex items-center text-base font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Informasi Pribadi
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Nama Lengkap</p>
                            <p class="mt-1 text-sm text-gray-900 font-semibold">{{ $pegawai->nama }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Jenis Kelamin</p>
                            <p class="mt-1 text-sm text-gray-900 font-semibold">
                                {{ $pegawai->jenis_kelamin === 'L' ? 'Laki-laki' : ($pegawai->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Tempat Lahir</p>
                            <p class="mt-1 text-sm text-gray-900 font-semibold">{{ $pegawai->tempat_lahir ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Tanggal Lahir</p>
                            <p class="mt-1 text-sm text-gray-900 font-semibold">
                                {{ $pegawai->tanggal_lahir ? $pegawai->tanggal_lahir->format('d F Y') : '-' }}
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Kontak & Alamat -->
                <section>
                    <h3 class="flex items-center text-base font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        Kontak &amp; Alamat
                    </h3>
                    <div class="space-y-4 bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Nomor Telepon / WhatsApp</p>
                            <p class="mt-1 text-sm text-gray-900 font-semibold">{{ $pegawai->no_hp ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Alamat Tempat Tinggal</p>
                            <p class="mt-1 text-sm text-gray-900 leading-relaxed">{{ $pegawai->alamat ?? '-' }}</p>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Right Column: Informasi Akun & Aksi -->
            <div class="bg-gray-50/50 p-6 sm:p-8 space-y-8">
                <section>
                    <h3 class="flex items-center text-base font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                        Akun Login Sistem
                    </h3>
                    
                    <div class="space-y-5">
                        @if($pegawai->user)
                            <div>
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Status Akun</p>
                                <p class="mt-1">
                                    <span class="inline-flex items-center rounded-md px-2.5 py-0.5 text-xs font-semibold {{ $pegawai->user->status === 'aktif' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst(str_replace('_', ' ', $pegawai->user->status)) }}
                                    </span>
                                </p>
                            </div>

                            <div>
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Role Sistem</p>
                                <p class="mt-1 text-sm font-semibold text-gray-900">{{ ucfirst($pegawai->user->role) }}</p>
                            </div>

                            <div>
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Username</p>
                                <p class="mt-1 text-sm font-semibold text-gray-900 font-mono">{{ $pegawai->user->username }}</p>
                            </div>

                            <div>
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Email</p>
                                <p class="mt-1 text-sm font-semibold text-gray-900 break-all">{{ $pegawai->user->email }}</p>
                            </div>
                        @else
                            <div class="rounded-xl bg-amber-50 p-4 border border-amber-200">
                                <p class="text-xs font-bold text-amber-800 uppercase tracking-wider">Tidak Memiliki Akun</p>
                                <p class="text-xs text-amber-700 mt-1">Pegawai ini tidak memiliki akun login ke sistem. Anda dapat menambahkan akun login dengan mengedit data pegawai (kecuali pengasuh).</p>
                            </div>
                        @endif

                        <div class="pt-6 border-t border-gray-200 space-y-3">
                            <a href="{{ route('admin.pegawai.edit', $pegawai->id) }}" class="w-full inline-flex items-center justify-center gap-2 rounded-xl border border-amber-200 bg-amber-50 px-4 py-2.5 text-sm font-semibold text-amber-500 shadow-sm transition hover:bg-amber-400 hover:text-white">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit Pegawai
                            </a>
                            <button type="button"
                                    onclick="openDeleteModal(this)"
                                    data-delete-route="{{ route('admin.pegawai.destroy', $pegawai->id) }}"
                                    data-name="{{ $pegawai->nama }}"
                                    class="w-full inline-flex items-center justify-center gap-2 rounded-xl border border-red-200 bg-red-50 px-4 py-2.5 text-sm font-semibold text-red-600 shadow-sm transition hover:bg-red-600 hover:text-white">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Hapus Pegawai
                            </button>
                        </div>
                    </div>
                </section>
            </div>

        </div>
    </div>
</div>
@endsection

@push('modals')
    @include('layouts.partials.admin.modals')
@endpush
