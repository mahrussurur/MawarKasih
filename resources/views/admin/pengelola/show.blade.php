@extends('layouts.app')
@section('title', 'Detail ' . ucfirst($roleFilter))
@section('page-title', 'Detail ' . ucfirst($roleFilter))

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('admin.pengelola.index', $roleFilter) }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-500 hover:text-gray-800 transition">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Data {{ ucfirst($roleFilter) }}
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8">
        <div class="flex flex-col sm:flex-row items-start gap-6">
            <div class="flex-shrink-0">
                @if($user->foto)
                    <img src="{{ asset('storage/' . $user->foto) }}" alt="{{ $user->name }}" class="h-24 w-24 rounded-2xl object-cover ring-4 ring-gray-100" />
                @else
                    <div class="flex h-24 w-24 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 text-2xl font-bold text-white">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
            </div>
            <div class="flex-1 min-w-0">
                <h2 class="text-xl font-bold text-gray-900">{{ $user->name }}</h2>
                <p class="text-sm text-gray-500">{{ ucfirst($roleFilter) }} &bull; {{ $user->email }}</p>
                <span class="mt-2 inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $user->status === 'aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                    {{ ucfirst(str_replace('_', ' ', $user->status)) }}
                </span>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.pengelola.edit', [$roleFilter, $user->id]) }}" class="inline-flex items-center gap-1.5 rounded-xl bg-amber-50 border border-amber-300 px-3 py-2 text-xs font-semibold text-amber-700 hover:bg-amber-100 transition">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Edit Profil
                </a>
            </div>
        </div>

        <div class="mt-6 border-t border-gray-100 pt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
            @foreach(['jabatan' => 'Jabatan', 'jenis_kelamin' => 'Jenis Kelamin', 'tempat_lahir' => 'Tempat Lahir', 'tanggal_lahir' => 'Tanggal Lahir', 'no_hp' => 'No. HP', 'alamat' => 'Alamat'] as $field => $label)
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">{{ $label }}</p>
                <p class="mt-0.5 text-sm text-gray-900">
                    @if($field === 'jenis_kelamin')
                        {{ $user->jenis_kelamin === 'L' ? 'Laki-laki' : ($user->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}
                    @elseif($field === 'tanggal_lahir')
                        {{ $user->tanggal_lahir ? \Carbon\Carbon::parse($user->tanggal_lahir)->format('d M Y') : '-' }}
                    @else
                        {{ $user->$field ?? '-' }}
                    @endif
                </p>
            </div>
            @endforeach
        </div>

        @if($roleFilter === 'donatur' && $donasi && $donasi->count() > 0)
        <div class="mt-6 border-t border-gray-100 pt-6">
            <h3 class="mb-3 text-sm font-bold text-gray-900">Riwayat Donasi Terbaru</h3>
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
                        @foreach($donasi as $d)
                        <tr>
                            <td class="px-3 py-2 font-mono text-xs text-gray-700">{{ $d->kode_donasi }}</td>
                            <td class="px-3 py-2 text-gray-900 font-semibold">Rp {{ number_format($d->nominal, 0, ',', '.') }}</td>
                            <td class="px-3 py-2">
                                <span class="inline-flex rounded-full px-2 py-0.5 text-[10px] font-semibold {{ ['diterima' => 'bg-emerald-100 text-emerald-700', 'pending' => 'bg-amber-100 text-amber-700', 'ditolak' => 'bg-red-100 text-red-700'][$d->status] ?? '' }}">{{ $d->status }}</span>
                            </td>
                            <td class="px-3 py-2 text-gray-600">{{ \Carbon\Carbon::parse($d->tanggal)->format('d M Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
