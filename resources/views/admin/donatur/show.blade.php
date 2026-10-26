@extends('layouts.app')
@section('page-title', 'Data Donatur')

@section('content')
@php
    $profile = $donatur->profilDonatur;
    $nama = $profile?->nama ?? $donatur->username;
@endphp

<div class="max-w-4xl mx-auto">
    <!-- Main Content -->
    <div class="overflow-hidden rounded-2xl bg-white shadow-sm border border-gray-200">
        <!-- Cover & Profile Image -->
        <div class="relative h-44 bg-gradient-to-r from-amber-500 to-orange-500">
            <!-- Header: Judul + Tombol di dalam cover -->
            <div class="absolute inset-x-0 top-0 flex flex-row items-start justify-between gap-3 px-6 pt-5">
                <div>
                    <h2 class="text-xl font-bold text-white sm:text-2xl">Detail Profil Donatur</h2>
                    <p class="text-sm text-amber-200">Informasi lengkap data diri, akun, dan riwayat donasi.</p>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                    <!-- Tombol Kembali -->
                    <a href="{{ route('admin.donatur.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-white/20 backdrop-blur-sm border border-white/30 p-2.5 text-sm font-semibold text-white shadow-sm hover:bg-white/30 transition sm:px-3 sm:py-2" title="Kembali">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        <span class="hidden sm:inline">Kembali</span>
                    </a>
                </div>
            </div>
            <!-- Foto profil di bawah cover -->
            <div class="absolute -bottom-12 left-6 sm:-bottom-16 sm:left-8">
                <div class="rounded-full bg-white p-1.5 sm:p-2 shadow-lg">
                    <div class="flex h-24 w-24 sm:h-32 sm:w-32 items-center justify-center rounded-full bg-gradient-to-br from-amber-500 to-orange-500 text-3xl sm:text-4xl font-bold text-white border-4 border-white shadow-inner">
                        {{ strtoupper(substr($nama, 0, 1)) }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Basic Info Header -->
        <div class="px-6 pb-6 pt-16 sm:px-8 sm:pt-20">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">{{ $nama }}</h1>
                    <p class="text-sm font-medium text-gray-500 mt-1">Username: <span class="font-mono text-gray-700 font-semibold">{{ $donatur->username }}</span></p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 divide-y divide-gray-100 lg:grid-cols-3 lg:divide-x lg:divide-y-0 border-t border-gray-100">
            
            <!-- Left Column: Identitas & Riwayat Donasi -->
            <div class="p-6 sm:p-8 lg:col-span-2 space-y-8">
                <!-- Data Pribadi -->
                <section>
                    <h3 class="flex items-center text-base font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">
                        <svg class="w-5 h-5 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Informasi Pribadi &amp; Kontak
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Nama Lengkap</p>
                            <p class="mt-1 text-sm text-gray-900 font-semibold">{{ $nama }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Email</p>
                            <p class="mt-1 text-sm text-gray-900 font-semibold break-all">{{ $donatur->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Nomor Telepon / WhatsApp</p>
                            <p class="mt-1 text-sm text-gray-900 font-semibold">{{ $profile?->no_hp ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Alamat</p>
                            <p class="mt-1 text-sm text-gray-900 leading-relaxed">{{ $profile?->alamat ?? '-' }}</p>
                        </div>
                    </div>
                </section>

                <!-- Riwayat Donasi Terbaru -->
                <section>
                    <h3 class="flex items-center text-base font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">
                        <svg class="w-5 h-5 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Riwayat Donasi Terbaru
                    </h3>
                    
                    @if($donasi->isNotEmpty())
                        <div class="overflow-x-auto rounded-xl border border-gray-200 custom-scrollbar">
                            <table class="w-full text-left text-sm whitespace-nowrap">
                                <thead class="bg-gray-50 border-b border-gray-200">
                                    <tr>
                                        <th class="px-4 py-3 font-semibold text-gray-700">Kode</th>
                                        <th class="px-4 py-3 font-semibold text-gray-700">Nominal</th>
                                        <th class="px-4 py-3 font-semibold text-gray-700">Status</th>
                                        <th class="px-4 py-3 font-semibold text-gray-700">Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($donasi as $item)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-4 py-3 font-mono text-xs font-semibold text-gray-800">{{ $item->kode_donasi }}</td>
                                            <td class="px-4 py-3 font-bold text-gray-900">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                                            <td class="px-4 py-3">
                                                <span class="inline-flex rounded-md px-2 py-0.5 text-xs font-semibold ring-1 ring-inset {{ ['diterima' => 'bg-green-50 text-green-700 ring-green-600/20', 'pending' => 'bg-amber-50 text-amber-700 ring-amber-600/20', 'ditolak' => 'bg-red-50 text-red-700 ring-red-600/10'][$item->status] ?? 'bg-gray-50 text-gray-700 ring-gray-600/10' }}">
                                                    {{ $item->status_label }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-xs text-gray-600">{{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d M Y') : '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="rounded-xl bg-gray-50 p-4 border border-gray-200 text-center text-sm text-gray-500">
                            Belum ada riwayat transaksi donasi dari donatur ini.
                        </div>
                    @endif
                </section>
            </div>

            <!-- Right Column: Informasi Akun & Aksi -->
            <div class="bg-gray-50/50 p-6 sm:p-8 space-y-8">
                <section>
                    <h3 class="flex items-center text-base font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">
                        <svg class="w-5 h-5 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        Ringkasan Akun
                    </h3>
                    
                    <div class="space-y-5">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Status Akun</p>
                            <p class="mt-1">
                                <span class="inline-flex items-center rounded-md px-2.5 py-0.5 text-xs font-semibold {{ $donatur->status === 'aktif' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst(str_replace('_', ' ', $donatur->status)) }}
                                </span>
                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Username</p>
                            <p class="mt-1 text-sm font-semibold text-gray-900 font-mono">{{ $donatur->username }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Terdaftar Sejak</p>
                            <p class="mt-1 text-sm font-semibold text-gray-900">{{ $donatur->created_at ? $donatur->created_at->format('d F Y') : '-' }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Donasi Diterima</p>
                            <p class="mt-1 text-base font-bold text-emerald-600">
                                Rp {{ number_format($donasi->where('status', 'diterima')->sum('nominal'), 0, ',', '.') }}
                            </p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $donasi->where('status', 'diterima')->count() }} transaksi berhasil</p>
                        </div>

                        <div class="pt-6 border-t border-gray-200 space-y-3">
                            <a href="{{ route('admin.donatur.edit', $donatur->id) }}" class="w-full inline-flex items-center justify-center gap-2 rounded-xl border border-amber-200 bg-amber-50 px-4 py-2.5 text-sm font-semibold text-amber-500 shadow-sm transition hover:bg-amber-400 hover:text-white">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit Donatur
                            </a>
                            <button type="button"
                                    onclick="openDeleteModal(this)"
                                    data-delete-route="{{ route('admin.donatur.destroy', $donatur->id) }}"
                                    data-name="{{ $nama }}"
                                    class="w-full inline-flex items-center justify-center gap-2 rounded-xl border border-red-200 bg-red-50 px-4 py-2.5 text-sm font-semibold text-red-600 shadow-sm transition hover:bg-red-600 hover:text-white">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Hapus Donatur
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
