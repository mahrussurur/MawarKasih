@extends('layouts.app')

@section('title', 'Detail ' . $roleLabel)
@section('page-title', 'Detail ' . $roleLabel)

@section('content')
@php
    $profile = $usesPengelolaProfile ? $user->profilPengelola : $user->profilDonatur;
    $nama = $profile?->nama ?? $user->username;
    $foto = $usesPengelolaProfile ? $profile?->foto : null;
@endphp
<div class="max-w-3xl mx-auto overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

    <!-- Header -->
    <div class="border-b border-gray-200 bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex justify-between items-center gap-4">
        <div class="min-w-0">
            <h2 class="text-lg font-bold text-white truncate">Detail {{ $roleLabel }}</h2>
            <p class="text-xs md:text-sm text-gray-200">Informasi lengkap data {{ $roleLabel }}.</p>
        </div>
        <a href="{{ route('sekretaris.pengelola.index', $roleFilter) }}" class="text-xs md:text-sm font-semibold text-white hover:text-gray-200 flex items-center transition-colors whitespace-nowrap">
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
                @if($foto)
                    <button type="button"
                            onclick="openImagePreview('{{ asset('storage/' . $foto) }}')"
                            aria-label="Perbesar foto {{ $nama }}">
                        <img src="{{ asset('storage/' . $foto) }}"
                             class="w-32 h-32 md:w-40 md:h-40 rounded-lg object-cover border-2 border-gray-200 cursor-pointer transition duration-200 hover:scale-105"
                             alt="Foto {{ $nama }}"
                             title="Klik untuk perbesar">
                    </button>
                @else
                    <div class="flex w-32 h-32 md:w-40 md:h-40 items-center justify-center rounded-lg bg-gradient-to-br from-blue-500 to-indigo-600 text-4xl font-bold text-white border-2 border-gray-200">
                        {{ strtoupper(substr($nama, 0, 1)) }}
                    </div>
                @endif
                <div class="text-center">
                    <span class="text-base md:text-lg font-bold text-gray-900 block truncate max-w-[180px] md:max-w-none">
                        {{ $nama }}
                    </span>
                    <span class="inline-block mt-1 px-3 py-0.5 rounded-full text-xs font-semibold {{ $user->status === 'aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                        {{ ucfirst(str_replace('_', ' ', $user->status)) }}
                    </span>
                </div>
            </div>

            <!-- Divider horizontal (mobile only) -->
            <div class="md:hidden w-full h-px bg-gray-200"></div>

            <!-- Detail Section -->
            <div class="w-full space-y-2.5">

                @if($usesPengelolaProfile)
                    <!-- Jabatan -->
                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-32 flex-shrink-0">Jabatan</span>
                            <span class="text-gray-400">:</span>
                            <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">{{ $profile?->jabatan ?? '-' }}</span>
                        </div>
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-32 flex-shrink-0">Jenis Kelamin</span>
                            <span class="text-gray-400">:</span>
                            <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">
                                {{ $profile?->jenis_kelamin === 'L' ? 'Laki-laki' : ($profile?->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}
                            </span>
                        </div>
                    </div>

                    <!-- Tempat Lahir -->
                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-32 flex-shrink-0">Tempat Lahir</span>
                            <span class="text-gray-400">:</span>
                            <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">{{ $profile?->tempat_lahir ?? '-' }}</span>
                        </div>
                    </div>

                    <!-- Tanggal Lahir -->
                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-32 flex-shrink-0">Tanggal Lahir</span>
                            <span class="text-gray-400">:</span>
                            <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">
                                {{ $profile?->tanggal_lahir?->format('d M Y') ?? '-' }}
                            </span>
                        </div>
                    </div>

                    <!-- No. HP -->
                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-32 flex-shrink-0">No. HP</span>
                            <span class="text-gray-400">:</span>
                            <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">{{ $profile?->no_hp ?? '-' }}</span>
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-32 flex-shrink-0">Alamat</span>
                            <span class="text-gray-400">:</span>
                            <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">{{ $profile?->alamat ?? '-' }}</span>
                        </div>
                    </div>

                @else
                    <!-- Username -->
                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-32 flex-shrink-0">Username</span>
                            <span class="text-gray-400">:</span>
                            <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">{{ $user->username }}</span>
                        </div>
                    </div>

                    <!-- No. HP -->
                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-32 flex-shrink-0">No. HP</span>
                            <span class="text-gray-400">:</span>
                            <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">{{ $profile?->no_hp ?? '-' }}</span>
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-32 flex-shrink-0">Alamat</span>
                            <span class="text-gray-400">:</span>
                            <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">{{ $profile?->alamat ?? '-' }}</span>
                        </div>
                    </div>
                @endif

                <!-- Divider Akun Login -->
                <p class="pt-1 text-xs font-bold uppercase tracking-wide text-gray-500 border-b border-gray-200 pb-1">Akun Login</p>

                <!-- Email -->
                <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-semibold text-gray-600 w-32 flex-shrink-0">Email</span>
                        <span class="text-gray-400">:</span>
                        <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">{{ $user->email }}</span>
                    </div>
                </div>

                <!-- Username (hanya untuk pengelola profile) -->
                @if($usesPengelolaProfile)
                <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-semibold text-gray-600 w-32 flex-shrink-0">Username</span>
                        <span class="text-gray-400">:</span>
                        <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">{{ $user->username }}</span>
                    </div>
                </div>
                @endif

            </div>
        </div>

        @if($usesDonaturProfile)
            <!-- Riwayat Donasi -->
            <div class="mt-6 pt-4 border-t border-gray-200">
                <p class="mb-3 text-xs font-bold uppercase tracking-wide text-gray-500">Riwayat Donasi Terbaru</p>
                @if($donasi->isNotEmpty())
                    <div class="overflow-x-auto rounded-xl border border-gray-200">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-3 py-2 font-semibold text-gray-600">Kode</th>
                                    <th class="px-3 py-2 font-semibold text-gray-600">Nominal</th>
                                    <th class="px-3 py-2 font-semibold text-gray-600">Status</th>
                                    <th class="px-3 py-2 font-semibold text-gray-600">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($donasi as $item)
                                    <tr>
                                        <td class="px-3 py-2 font-mono text-xs text-gray-700">{{ $item->kode_donasi }}</td>
                                        <td class="px-3 py-2 font-semibold text-gray-900">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                                        <td class="px-3 py-2"><span class="inline-flex rounded-full px-2 py-0.5 text-[10px] font-semibold {{ ['diterima' => 'bg-emerald-100 text-emerald-700', 'pending' => 'bg-amber-100 text-amber-700', 'ditolak' => 'bg-red-100 text-red-700'][$item->status] ?? '' }}">{{ $item->status_label }}</span></td>
                                        <td class="px-3 py-2 text-gray-600">{{ $item->tanggal?->format('d M Y') ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="rounded-xl bg-gray-50 px-4 py-3 text-sm text-gray-500">Belum ada riwayat donasi.</p>
                @endif
            </div>
        @endif

    </div>
</div>
@endsection
