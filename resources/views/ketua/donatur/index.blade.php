@extends('layouts.app')
@section('page-title', 'Data Donatur')

@section('content')
<div>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6">
        <div class="flex flex-col gap-4 border-b border-gray-200 pb-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h3 class="text-lg font-bold text-gray-900">Daftar Donatur Panti</h3>
                <p class="text-xs text-gray-500 mt-0.5">Akses baca-saja data donatur dan riwayat donasi mereka.</p>
            </div>

            <!-- Search -->
            <form method="GET" action="{{ route('ketua.donatur.index') }}" class="flex w-full items-center gap-3 lg:w-auto">
                <label class="relative block w-full lg:w-[280px]">
                    <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-gray-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / email / no hp..."
                           class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" />
                </label>
            </form>
        </div>

        <!-- Table Data -->
        @if($donaturs->count() > 0)
        <div class="overflow-x-auto mt-4">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 font-semibold text-gray-700 w-12 text-center">No</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Nama Donatur</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Email</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">No. HP</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Alamat</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-4 font-semibold text-gray-700 text-center sticky right-0 bg-gray-50 z-10 shadow-[inset_1px_0_0_#e5e7eb]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($donaturs as $i => $donatur)
                    @php
                        $nama = $donatur->profilDonatur?->nama ?? $donatur->username;
                        $noHp = $donatur->profilDonatur?->no_hp ?? '-';
                        $alamat = $donatur->profilDonatur?->alamat ?? '-';
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors group">
                        <td class="px-6 py-4 text-center text-gray-700">{{ $donaturs->firstItem() + $i }}</td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900">{{ $nama }}</div>
                            <div class="text-xs text-gray-400">@ {{ $donatur->username }}</div>
                        </td>
                        <td class="px-6 py-4 text-gray-700">{{ $donatur->email }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $noHp }}</td>
                        <td class="px-6 py-4 text-gray-700 max-w-xs truncate">{{ $alamat }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex rounded-md px-2 py-1 text-xs font-semibold ring-1 ring-inset {{ $donatur->status === 'aktif' ? 'bg-green-50 text-green-700 ring-green-600/20' : 'bg-red-50 text-red-700 ring-red-600/10' }}">
                                {{ $donatur->status === 'aktif' ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center sticky right-0 bg-white group-hover:bg-gray-50 z-10 shadow-[inset_1px_0_0_#e5e7eb]">
                            <a href="{{ route('ketua.donatur.show', $donatur) }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-blue-600 border border-blue-200 hover:bg-blue-600 hover:text-white transition" title="Lihat Detail">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $donaturs->links() }}
        </div>
        @else
        <div class="py-12 text-center text-gray-500">
            <p class="text-sm font-semibold text-gray-700">Tidak ada data donatur ditemukan.</p>
        </div>
        @endif
    </div>
</div>
@endsection
