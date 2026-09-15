@extends('layouts.app')
@section('title', 'Catatan Perkembangan Anak')
@section('page-title', 'Catatan Perkembangan Anak')

@section('content')
<div>
    {{-- Toolbar --}}
    <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
        <a href="{{ route('pengasuh.catatan-perkembangan.create') }}"
           class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Catatan
        </a>

        {{-- Filter --}}
        <form method="GET" action="{{ route('pengasuh.catatan-perkembangan.index') }}" class="flex flex-wrap items-center gap-2">
            <select name="anak_asuh_id" onchange="this.form.submit()"
                    class="rounded-xl border border-gray-200 bg-gray-50 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">— Semua Anak —</option>
                @foreach($anakList as $anak)
                    <option value="{{ $anak->id }}" {{ request('anak_asuh_id') == $anak->id ? 'selected' : '' }}>{{ $anak->nama }}</option>
                @endforeach
            </select>
            <select name="kategori" onchange="this.form.submit()"
                    class="rounded-xl border border-gray-200 bg-gray-50 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">— Semua Kategori —</option>
                @foreach($kategoriList as $k)
                    <option value="{{ $k }}" {{ request('kategori') == $k ? 'selected' : '' }}>{{ $k }}</option>
                @endforeach
            </select>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6">
        @if($catatans->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left divide-y divide-gray-200 text-sm whitespace-nowrap">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-gray-600 text-center w-10">No</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Nama Anak</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Tanggal</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Kategori</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Catatan</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Dicatat oleh</th>
                        <th class="px-4 py-3 font-semibold text-gray-600 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($catatans as $i => $catatan)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 text-center text-gray-600">{{ $catatans->firstItem() + $i }}</td>
                        <td class="px-4 py-3 font-semibold text-gray-900">{{ $catatan->anakAsuh->nama ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ \Carbon\Carbon::parse($catatan->tanggal)->format('d M Y') }}</td>
                        <td class="px-4 py-3">
                            @php
                                $badgeColor = [
                                    'Pendidikan' => 'bg-blue-100 text-blue-800',
                                    'Kesehatan'  => 'bg-emerald-100 text-emerald-800',
                                    'Sosial'     => 'bg-purple-100 text-purple-800',
                                    'Lainnya'    => 'bg-gray-100 text-gray-700',
                                ][$catatan->kategori] ?? 'bg-gray-100 text-gray-700';
                            @endphp
                            <span class="inline-flex rounded-full px-2.5 py-0.5 text-[11px] font-semibold {{ $badgeColor }}">{{ $catatan->kategori }}</span>
                        </td>
                        <td class="px-4 py-3 text-gray-600 max-w-xs truncate">{{ \Illuminate\Support\Str::limit($catatan->catatan, 60) }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $catatan->pengasuh->name ?? '—' }}</td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex justify-center gap-1">
                                <a href="{{ route('pengasuh.catatan-perkembangan.show', $catatan->id) }}"
                                   class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-blue-400 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition"
                                   title="Lihat Detail">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <a href="{{ route('pengasuh.catatan-perkembangan.edit', $catatan->id) }}"
                                   class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-amber-400 bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white transition"
                                   title="Edit">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <button type="button"
                                        class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-red-400 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition"
                                        title="Hapus"
                                        data-delete-route="{{ route('pengasuh.catatan-perkembangan.destroy', $catatan->id) }}"
                                        data-name="catatan {{ $catatan->anakAsuh->nama ?? '' }}"
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
        @include('layouts.partials.admin._pagination', ['paginator' => $catatans])
        @else
        <div class="flex min-h-[250px] flex-col items-center justify-center gap-2 text-center text-gray-500">
            <svg class="h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <p class="font-semibold text-gray-900">Belum ada catatan perkembangan</p>
            <p class="text-sm">Klik "Tambah Catatan" untuk mulai mencatat.</p>
        </div>
        @endif
    </div>
</div>
@endsection

@push('modals')
    @include('layouts.partials.admin.modals')
@endpush
