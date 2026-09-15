@extends('layouts.app')
@section('title', 'Detail Catatan Perkembangan')
@section('page-title', 'Detail Catatan Perkembangan')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('pengasuh.catatan-perkembangan.index') }}"
           class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-500 hover:text-gray-800 transition">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Daftar Catatan
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 space-y-5">
        {{-- Header --}}
        <div class="flex items-center justify-between border-b border-gray-100 pb-4">
            <div>
                <h2 class="text-xl font-bold text-gray-900">{{ $catatanPerkembangan->anakAsuh->nama ?? '—' }}</h2>
                <p class="text-sm text-gray-500 mt-0.5">{{ \Carbon\Carbon::parse($catatanPerkembangan->tanggal)->format('d MMMM Y') }}</p>
            </div>
            @php
                $badgeColor = [
                    'Pendidikan' => 'bg-blue-100 text-blue-800',
                    'Kesehatan'  => 'bg-emerald-100 text-emerald-800',
                    'Sosial'     => 'bg-purple-100 text-purple-800',
                    'Lainnya'    => 'bg-gray-100 text-gray-700',
                ][$catatanPerkembangan->kategori] ?? 'bg-gray-100 text-gray-700';
            @endphp
            <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $badgeColor }}">{{ $catatanPerkembangan->kategori }}</span>
        </div>

        {{-- Isi Catatan --}}
        <div>
            <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">Isi Catatan</p>
            <p class="text-sm text-gray-800 leading-relaxed whitespace-pre-wrap">{{ $catatanPerkembangan->catatan }}</p>
        </div>

        {{-- Foto --}}
        @if($catatanPerkembangan->foto)
        <div>
            <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-2">Dokumentasi Foto</p>
            <img src="{{ Storage::url($catatanPerkembangan->foto) }}" alt="Dokumentasi"
                 class="rounded-xl border border-gray-200 max-h-64 object-cover">
        </div>
        @endif

        {{-- Meta --}}
        <div class="grid grid-cols-2 gap-4 bg-gray-50 rounded-xl p-4 text-sm">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Dicatat oleh</p>
                <p class="mt-0.5 font-medium text-gray-800">{{ $catatanPerkembangan->pengasuh->name ?? '—' }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Dibuat pada</p>
                <p class="mt-0.5 font-medium text-gray-800">{{ $catatanPerkembangan->created_at->format('d M Y, H:i') }}</p>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex gap-3 pt-2">
            <a href="{{ route('pengasuh.catatan-perkembangan.edit', $catatanPerkembangan->id) }}"
               class="inline-flex items-center gap-2 rounded-xl border border-amber-400 bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-700 transition hover:bg-amber-500 hover:text-white hover:border-amber-500">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit
            </a>
            <button type="button"
                    class="inline-flex items-center gap-2 rounded-xl border border-red-400 bg-red-50 px-4 py-2 text-sm font-semibold text-red-700 transition hover:bg-red-600 hover:text-white hover:border-red-600"
                    data-delete-route="{{ route('pengasuh.catatan-perkembangan.destroy', $catatanPerkembangan->id) }}"
                    data-name="catatan ini"
                    onclick="openDeleteModal(this)">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Hapus
            </button>
        </div>
    </div>
</div>
@endsection

@push('modals')
    @include('layouts.partials.admin._delete_modal')
@endpush
