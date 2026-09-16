@extends('layouts.app')

@section('title', 'Detail ' . $roleLabel)
@section('page-title', 'Detail ' . $roleLabel)

@section('content')
@php
    $profile = $usesPengelolaProfile ? $user->profilPengelola : $user->profilDonatur;
    $nama = $profile?->nama ?? $user->username;
    $foto = $usesPengelolaProfile ? $profile?->foto : null;
@endphp
<div class="mx-auto max-w-3xl">
    <div class="mb-4">
        <a href="{{ route('admin.pengelola.index', $roleFilter) }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-500 transition hover:text-gray-800">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Data {{ $roleLabel }}
        </a>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
        <div class="flex flex-col items-start gap-6 sm:flex-row">
            <div class="shrink-0">
                @if($foto)
                    <img src="{{ asset('storage/' . $foto) }}" alt="{{ $nama }}" class="h-24 w-24 rounded-2xl object-cover ring-4 ring-gray-100" />
                @else
                    <div class="flex h-24 w-24 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 text-2xl font-bold text-white">
                        {{ strtoupper(substr($nama, 0, 1)) }}
                    </div>
                @endif
            </div>
            <div class="min-w-0 flex-1">
                <h2 class="text-xl font-bold text-gray-900">{{ $nama }}</h2>
                <p class="text-sm text-gray-500">{{ $roleLabel }} &bull; {{ $user->email }}</p>
                <span class="mt-2 inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $user->status === 'aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                    {{ ucfirst(str_replace('_', ' ', $user->status)) }}
                </span>
            </div>
            <a href="{{ route('admin.pengelola.edit', [$roleFilter, $user->id]) }}" class="inline-flex items-center gap-1.5 rounded-xl border border-amber-300 bg-amber-50 px-3 py-2 text-xs font-semibold text-amber-700 transition hover:bg-amber-100">
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit Profil
            </a>
        </div>

        <div class="mt-6 grid grid-cols-1 gap-4 border-t border-gray-100 pt-6 sm:grid-cols-2">
            @if($usesPengelolaProfile)
                @foreach(['jabatan' => 'Jabatan', 'jenis_kelamin' => 'Jenis Kelamin', 'tempat_lahir' => 'Tempat Lahir', 'tanggal_lahir' => 'Tanggal Lahir', 'no_hp' => 'No. HP', 'alamat' => 'Alamat'] as $field => $label)
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">{{ $label }}</p>
                        <p class="mt-0.5 text-sm text-gray-900">
                            @if($field === 'jenis_kelamin')
                                {{ $profile?->jenis_kelamin === 'L' ? 'Laki-laki' : ($profile?->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}
                            @elseif($field === 'tanggal_lahir')
                                {{ $profile?->tanggal_lahir?->format('d M Y') ?? '-' }}
                            @else
                                {{ $profile?->$field ?? '-' }}
                            @endif
                        </p>
                    </div>
                @endforeach
            @else
                @foreach(['username' => 'Username', 'no_hp' => 'No. HP', 'alamat' => 'Alamat'] as $field => $label)
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">{{ $label }}</p>
                        <p class="mt-0.5 text-sm text-gray-900">{{ $field === 'username' ? $user->username : ($profile?->$field ?? '-') }}</p>
                    </div>
                @endforeach
            @endif
        </div>

        @if($usesDonaturProfile)
            <div class="mt-6 border-t border-gray-100 pt-6">
                <h3 class="mb-3 text-sm font-bold text-gray-900">Riwayat Donasi Terbaru</h3>
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
