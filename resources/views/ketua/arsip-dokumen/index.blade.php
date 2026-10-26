@extends('layouts.app')

@section('title', 'Arsip Dokumen Administrasi')
@section('page-title', 'Arsip Dokumen Administrasi')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-gray-900">Arsip Dokumen Administrasi Panti</h2>
            <p class="text-xs text-gray-500 mt-0.5">Peninjauan dan pengunduhan arsip digital legalitas, surat resmi, dan administrasi LKSA Mawar Kasih.</p>
        </div>
        <div>
            <span class="inline-flex items-center gap-1.5 rounded-xl bg-teal-50 px-3.5 py-2 text-xs font-bold text-teal-700 ring-1 ring-inset ring-teal-600/20">
                <svg class="h-4 w-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                Akses Ketua: Lihat &amp; Unduh
            </span>
        </div>
    </div>

    <!-- Alert Sukses / Error -->
    @if(session('success'))
        <div class="rounded-xl border border-green-200 bg-green-50 p-4 text-sm font-semibold text-green-800 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm font-semibold text-red-800 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                <span>{{ session('error') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">&times;</button>
        </div>
    @endif

    <!-- Container Table & Filter -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 border-b border-gray-100 pb-4">
            <!-- Filter Kategori -->
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('ketua.arsip-dokumen.index') }}" class="rounded-xl px-3 py-1.5 text-xs font-semibold {{ !request('kategori') ? 'bg-teal-600 text-white shadow-sm' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    Semua ({{ \App\Models\ArsipDokumen::count() }})
                </a>
                @foreach(['Legalitas', 'Surat Masuk', 'Surat Keluar', 'Notula Rapat', 'Lainnya'] as $kat)
                    <a href="{{ route('ketua.arsip-dokumen.index', ['kategori' => $kat, 'search' => request('search')]) }}" class="rounded-xl px-3 py-1.5 text-xs font-semibold {{ request('kategori') === $kat ? 'bg-teal-600 text-white shadow-sm' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        {{ $kat }}
                    </a>
                @endforeach
            </div>

            <!-- Search -->
            <form method="GET" action="{{ route('ketua.arsip-dokumen.index') }}" class="flex items-center gap-2">
                @if(request('kategori'))
                    <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                @endif
                <label class="relative block w-full sm:w-[260px]">
                    <span class="pointer-events-none absolute inset-y-0 left-3.5 flex items-center text-gray-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul / nomor / berkas..."
                           class="w-full pl-9 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent text-xs" />
                </label>
                @if(request('search'))
                    <a href="{{ route('ketua.arsip-dokumen.index', ['kategori' => request('kategori')]) }}" class="text-xs text-gray-500 hover:text-gray-700 font-semibold">Reset</a>
                @endif
            </form>
        </div>

        @if($arsips->count() > 0)
            <div class="overflow-x-auto mt-4 custom-scrollbar">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-5 py-3 font-semibold text-gray-700 text-center w-12">No</th>
                            <th class="px-5 py-3 font-semibold text-gray-700">Dokumen</th>
                            <th class="px-5 py-3 font-semibold text-gray-700">Kategori</th>
                            <th class="px-5 py-3 font-semibold text-gray-700">Tgl Dokumen</th>
                            <th class="px-5 py-3 font-semibold text-gray-700">Nama File Asli</th>
                            <th class="px-5 py-3 font-semibold text-gray-700">Ukuran</th>
                            <th class="px-5 py-3 font-semibold text-gray-700">Pengunggah</th>
                            <th class="px-5 py-3 font-semibold text-gray-700 text-center sticky right-0 bg-gray-50 z-10 shadow-[inset_1px_0_0_#e5e7eb]">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($arsips as $i => $item)
                        <tr class="hover:bg-gray-50 transition-colors group">
                            <td class="px-5 py-3 text-center text-gray-500 text-xs">{{ $arsips->firstItem() + $i }}</td>
                            <td class="px-5 py-3">
                                <a href="{{ route('ketua.arsip-dokumen.show', $item) }}" class="font-bold text-gray-900 hover:text-teal-600 transition block">
                                    {{ $item->judul }}
                                </a>
                                @if($item->nomor_dokumen)
                                    <div class="text-xs text-gray-500 font-mono mt-0.5">No: {{ $item->nomor_dokumen }}</div>
                                @endif
                            </td>
                            <td class="px-5 py-3">
                                <span class="inline-flex rounded-md bg-teal-50 px-2 py-0.5 text-xs font-semibold text-teal-700 ring-1 ring-inset ring-teal-600/20">
                                    {{ $item->kategori }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-xs text-gray-600">
                                {{ $item->tanggal_dokumen ? $item->tanggal_dokumen->format('d M Y') : '-' }}
                            </td>
                            <td class="px-5 py-3 text-xs text-gray-500 max-w-[200px] truncate" title="{{ $item->file_name_asli }}">
                                {{ $item->file_name_asli }}
                            </td>
                            <td class="px-5 py-3 text-xs text-gray-500">{{ $item->formatted_file_size }}</td>
                            <td class="px-5 py-3 text-xs text-gray-600">
                                {{ $item->uploader?->nama ?? 'Admin' }}
                            </td>
                            <td class="px-5 py-3 text-center sticky right-0 bg-white group-hover:bg-gray-50 z-10 shadow-[inset_1px_0_0_#e5e7eb]">
                                <div class="flex items-center justify-center gap-1.5">
                                    <!-- Unduh -->
                                    <a href="{{ route('ketua.arsip-dokumen.download', $item) }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-teal-50 text-teal-700 hover:bg-teal-600 hover:text-white transition" title="Unduh Berkas">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                    </a>
                                    <!-- Detail -->
                                    <a href="{{ route('ketua.arsip-dokumen.show', $item) }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 transition" title="Lihat Rincian">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $arsips->links() }}
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-12 text-center text-gray-500">
                <svg class="h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                <p class="text-base font-bold text-gray-800">Tidak ada arsip dokumen ditemukan.</p>
                <p class="text-xs text-gray-400 mt-1 max-w-sm">Dokumen administrasi yayasan LKSA Mawar Kasih dikelola oleh Admin.</p>
            </div>
        @endif
    </div>

</div>
@endsection
