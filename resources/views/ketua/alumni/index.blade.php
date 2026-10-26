@extends('layouts.app')
@section('title', 'Data Alumni')
@section('page-title', 'Data Alumni')

@section('content')
<div>
    <!-- Toolbar -->
    <div class="flex justify-between items-center mb-4">
        <div>
            <p class="text-xs text-gray-500">Akses baca-saja data alumni Panti Asuhan Mawar Kasih.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('ketua.alumni.cetak') }}" target="_blank" class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm transition hover:border-gray-300 hover:bg-gray-100">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak Laporan
            </a>
        </div>
    </div>

    <!-- Kotak Utama Konten -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6">
        
        <div class="flex flex-col gap-4 border-b border-gray-200 pb-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h3 class="text-lg font-bold text-gray-900">Daftar Alumni</h3>
            </div>
            <!-- Search -->
            <form method="GET" action="{{ route('ketua.alumni.index') }}" class="flex w-full items-center gap-3 lg:w-auto">
                <label class="relative block w-full lg:w-[280px]">
                    <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-gray-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / pendidikan..."
                           class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" />
                </label>
            </form>
        </div>

        <!-- Table Data -->
        @if($data->count() > 0)
        <div class="overflow-x-auto custom-scrollbar mt-4">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 font-semibold text-gray-700 text-center w-12">No</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Foto</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Nama Lengkap</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Tahun Keluar</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Jenis Kelamin</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Pendidikan Terakhir</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Pekerjaan</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">No. HP</th>
                        <th class="px-6 py-4 font-semibold text-gray-700 text-center sticky right-0 bg-gray-50 z-10 shadow-[inset_1px_0_0_#e5e7eb]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($data as $index => $item)
                    <tr class="hover:bg-gray-50 transition-colors group">
                        <td class="px-6 py-4 text-center text-gray-700">{{ $data->firstItem() + $index }}</td>
                        <td class="px-6 py-4">
                            @if($item->foto)
                                <img src="{{ asset('storage/'.$item->foto) }}" class="h-10 w-10 shrink-0 rounded-full object-cover border border-gray-200" alt="Foto {{ $item->nama }}">
                            @else
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-violet-100 text-sm font-bold text-violet-600">
                                    {{ strtoupper(substr($item->nama, 0, 1)) }}
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-bold text-gray-900">{{ $item->nama }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $item->tanggal_keluar ? \Carbon\Carbon::parse($item->tanggal_keluar)->format('Y') : '-' }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $item->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $item->pendidikan_terakhir ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $item->pekerjaan ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $item->no_hp ?? '-' }}</td>
                        <td class="px-6 py-4 text-center sticky right-0 bg-white group-hover:bg-gray-50 z-10 shadow-[inset_1px_0_0_#e5e7eb]">
                            <a href="{{ route('ketua.alumni.show', $item) }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-violet-50 text-violet-600 border border-violet-200 hover:bg-violet-600 hover:text-white transition" title="Lihat Detail">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $data->links() }}
        </div>
        @else
        <div class="py-12 text-center text-gray-500">
            <p class="text-sm font-semibold text-gray-700">Tidak ada data alumni ditemukan.</p>
        </div>
        @endif
    </div>
</div>
@endsection
