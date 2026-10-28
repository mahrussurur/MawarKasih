@extends('layouts.app')
@section('title', 'Data Pegawai')
@section('page-title', 'Data Pegawai')

@section('content')
<div>
    <!-- Toolbar -->
    <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
        <a href="{{ route('admin.pegawai.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Pegawai
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6">
        <div class="flex flex-col gap-4 border-b border-gray-200 pb-4 lg:flex-row lg:items-center lg:justify-end">
            <!-- Search -->
            <form method="GET" action="{{ route('admin.pegawai.index') }}" class="flex w-full items-center gap-3 lg:w-auto">
                <label class="relative block w-full lg:w-[260px]">
                    <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-gray-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Pegawai..." class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent text-sm" />
                </label>
            </form>
        </div>

        <!-- Table Data -->
        @if($pegawais->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 font-semibold text-gray-700 w-12 text-center">No</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Foto</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Nama</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Jabatan</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Akun Login</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">No. HP</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-4 font-semibold text-gray-700 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($pegawais as $i => $pegawai)
                    <tr class="hover:bg-gray-50 transition-colors group">
                        <td class="px-6 py-4 text-center text-gray-700">{{ $pegawais->firstItem() + $i }}</td>
                        <td class="px-6 py-4">
                            @if($pegawai->foto)
                                <button type="button" class="inline-flex" onclick="openImagePreview('{{ asset('storage/'.$pegawai->foto) }}')">
                                    <img src="{{ asset('storage/'.$pegawai->foto) }}"
                                         class="h-10 w-10 shrink-0 rounded-full object-cover cursor-pointer"
                                         alt="Foto {{ $pegawai->nama }}"
                                         title="Klik untuk perbesar">
                                </button>
                            @else
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-200 text-sm font-bold text-gray-600">
                                    {{ strtoupper(substr($pegawai->nama, 0, 1)) }}
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-900">{{ $pegawai->nama }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex rounded-md px-2 py-0.5 text-xs font-semibold bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-600/20">
                                {{ $pegawai->jabatan }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-700">
                            @if($pegawai->user)
                                <div class="text-xs">
                                    <span class="font-medium text-gray-900">{{ $pegawai->user->username }}</span>
                                    <span class="text-gray-400 block">{{ $pegawai->user->email }}</span>
                                </div>
                            @else
                                <span class="text-xs text-gray-400 italic">Tanpa Akun Login</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-700">{{ $pegawai->no_hp ?? '-' }}</td>
                        <td class="px-6 py-4">
                            @if($pegawai->user)
                                <span class="inline-flex rounded-md px-2 py-1 text-xs font-semibold ring-1 ring-inset {{ $pegawai->user->status === 'aktif' ? 'bg-green-50 text-green-700 ring-green-600/20' : 'bg-red-50 text-red-700 ring-red-600/10' }}">
                                    {{ ucfirst(str_replace('_', ' ', $pegawai->user->status)) }}
                                </span>
                            @else
                                <span class="inline-flex rounded-md px-2 py-1 text-xs font-semibold bg-gray-50 text-gray-500 ring-1 ring-inset ring-gray-400/20">
                                    Aktif
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center gap-1">
                                <a href="{{ route('admin.pegawai.show', $pegawai->id) }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-blue-600 border border-blue-400 hover:bg-blue-600 hover:text-white transition" title="Detail">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <a href="{{ route('admin.pegawai.edit', $pegawai->id) }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-amber-50 text-amber-600 border border-amber-400 hover:bg-amber-500 hover:text-white transition" title="Edit Profil">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>

                                <button type="button" class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-red-50 text-red-600 border border-red-400 hover:bg-red-600 hover:text-white transition"
                                    title="Hapus"
                                    data-delete-route="{{ route('admin.pegawai.destroy', $pegawai->id) }}"
                                    data-name="Pegawai {{ $pegawai->nama }}"
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

        <!-- Pagination -->
        @include('layouts.partials.admin._pagination', ['paginator' => $pegawais])
        @else
        <div class="flex min-h-[250px] flex-col items-center justify-center gap-2 text-center text-gray-500">
            <p class="font-semibold text-gray-900">Belum ada data Pegawai</p>
            <p class="text-sm">Tambahkan data pegawai melalui formulir yang tersedia.</p>
        </div>
        @endif
    </div>
</div>
@endsection

@push('modals')
    @include('layouts.partials.admin.modals')
@endpush
