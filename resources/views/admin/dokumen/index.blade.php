@extends('layouts.app')
@section('title', 'Data Dokumen Administrasi')
@section('page-title', 'Dokumen Administrasi')

@section('content')
<div>
    <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
        <a href="{{ route('admin.dokumen.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Upload Dokumen
        </a>
        <form method="GET" action="{{ route('admin.dokumen.index') }}" class="flex items-center gap-2">
            <label class="relative block">
                <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-gray-400">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari dokumen..."
                       class="w-64 pl-9 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </label>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6">
        @if(session('success'))
            <div class="mb-4 rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm font-medium text-emerald-700">{{ session('success') }}</div>
        @endif

        @if($dokumen->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-gray-600 w-10 text-center">No</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Judul</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">No. Dokumen</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Jenis</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Tanggal</th>
                        <th class="px-4 py-3 font-semibold text-gray-600 text-center">File</th>
                        <th class="px-4 py-3 font-semibold text-gray-600 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($dokumen as $i => $item)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 text-center text-gray-600">{{ $dokumen->firstItem() + $i }}</td>
                        <td class="px-4 py-3 font-semibold text-gray-900">{{ $item->judul }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $item->nomor_dokumen ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $item->jenis_dokumen ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-600 whitespace-nowrap">{{ $item->tanggal_dokumen ? $item->tanggal_dokumen->format('d M Y') : '-' }}</td>
                        <td class="px-4 py-3 text-center">
                            <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="inline-flex items-center gap-1 rounded-lg bg-gray-100 px-3 py-1.5 text-xs font-semibold text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Unduh
                            </a>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex justify-center gap-1">
                                <a href="{{ route('admin.dokumen.edit', $item->id) }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-amber-50 text-amber-600 border border-amber-400 hover:bg-amber-500 hover:text-white transition" title="Edit">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <button type="button" class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-red-50 text-red-600 border border-red-400 hover:bg-red-600 hover:text-white transition"
                                    title="Hapus"
                                    data-delete-route="{{ route('admin.dokumen.destroy', $item->id) }}"
                                    data-name="dokumen {{ $item->judul }}"
                                    onclick="openDeleteModal(this)">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $dokumen->links() }}</div>
        @else
        <div class="flex min-h-[250px] flex-col items-center justify-center gap-2 text-center text-gray-500">
            <svg class="h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <p class="font-semibold text-gray-900">Belum ada dokumen</p>
            <p class="text-sm">Upload dokumen administrasi untuk mulai mengelola arsip.</p>
        </div>
        @endif
    </div>
</div>
@endsection

@push('modals')
    @include('layouts.partials.admin.modals')
@endpush

