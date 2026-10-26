@extends('layouts.app')

@section('title', 'Detail Donatur')
@section('page-title', 'Detail Donatur')

@section('content')
@php
    $nama = $user->profilDonatur?->nama ?? $user->username;
    $noHp = $user->profilDonatur?->no_hp ?? '-';
    $alamat = $user->profilDonatur?->alamat ?? '-';
@endphp
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Card Info Donatur -->
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
        <!-- Header -->
        <div class="border-b border-gray-200 bg-gradient-to-r from-amber-500 to-amber-600 px-6 py-4 flex justify-between items-center gap-4">
            <div>
                <h2 class="text-lg font-bold text-white">Profil Donatur</h2>
                <p class="text-xs text-amber-100">Informasi identitas dan kontak donatur panti.</p>
            </div>
            <a href="{{ route('ketua.donatur.index') }}" class="text-xs font-semibold text-white hover:text-amber-200 flex items-center transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
        </div>

        <div class="p-6">
            <div class="flex flex-col sm:flex-row gap-6 items-start">
                <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-amber-100 text-3xl font-extrabold text-amber-600 shrink-0">
                    {{ strtoupper(substr($nama, 0, 1)) }}
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 flex-1 w-full text-sm">
                    <div>
                        <p class="text-xs font-semibold text-gray-500">Nama Lengkap</p>
                        <p class="font-bold text-gray-900 mt-0.5">{{ $nama }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500">Username</p>
                        <p class="font-bold text-gray-900 mt-0.5">{{ $user->username }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500">Email</p>
                        <p class="font-bold text-gray-900 mt-0.5">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500">No. WhatsApp / HP</p>
                        <p class="font-bold text-gray-900 mt-0.5">{{ $noHp }}</p>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-xs font-semibold text-gray-500">Alamat</p>
                        <p class="font-medium text-gray-700 mt-0.5">{{ $alamat }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500">Status Akun</p>
                        <span class="inline-flex mt-1 rounded-md px-2 py-0.5 text-xs font-semibold {{ $user->status === 'aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $user->status === 'aktif' ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500">Terdaftar Sejak</p>
                        <p class="font-medium text-gray-700 mt-0.5">{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat Donasi Donatur -->
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
        <h3 class="text-base font-bold text-gray-900 mb-4 pb-3 border-b border-gray-100">
            Riwayat Donasi Terbaru
        </h3>

        @if($donasi && $donasi->isNotEmpty())
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-2.5 font-semibold text-gray-700">Kode Donasi</th>
                            <th class="px-4 py-2.5 font-semibold text-gray-700">Tanggal</th>
                            <th class="px-4 py-2.5 font-semibold text-gray-700">Nominal</th>
                            <th class="px-4 py-2.5 font-semibold text-gray-700">Metode</th>
                            <th class="px-4 py-2.5 font-semibold text-gray-700 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($donasi as $d)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-mono font-bold text-gray-900">{{ $d->kode_donasi }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $d->tanggal ? \Carbon\Carbon::parse($d->tanggal)->format('d M Y') : '-' }}</td>
                                <td class="px-4 py-3 font-bold text-emerald-600">Rp {{ number_format($d->nominal, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-gray-600 uppercase text-xs">{{ $d->metode_pembayaran }}</td>
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex rounded-md px-2 py-0.5 text-xs font-semibold
                                        @if($d->status === 'diterima') bg-green-100 text-green-700
                                        @elseif($d->status === 'pending') bg-amber-100 text-amber-700
                                        @else bg-red-100 text-red-700 @endif">
                                        {{ ucfirst($d->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-sm text-gray-500 py-4 text-center">Belum ada riwayat donasi yang tercatat untuk donatur ini.</p>
        @endif
    </div>

</div>
@endsection
