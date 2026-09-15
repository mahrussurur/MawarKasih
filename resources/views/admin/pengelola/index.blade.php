@extends('layouts.app')
@section('title', 'Data ' . ucfirst($roleLabel))
@section('page-title', 'Data ' . ucfirst($roleLabel))

@section('content')
<div>
    @if(session('success'))
        <div class="mb-4 rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm font-medium text-emerald-700">{{ session('success') }}</div>
    @endif

    <!-- Toolbar -->
    <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
        {{-- Tombol Tambah User dengan filter role yang sudah tersisian --}}
        <a href="{{ route('users.create') }}?default_role={{ $roleFilter }}" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah {{ ucfirst($roleLabel) }}
        </a>
        <form method="GET" action="{{ route('admin.pengelola.index', $roleFilter) }}" class="flex items-center gap-2">
            <label class="relative block">
                <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-gray-400">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari {{ $roleLabel }}..."
                       class="w-64 pl-9 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </label>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6">
        @if($users->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-gray-600 w-10 text-center">No</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Foto</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Nama</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Email</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">No. HP</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Status</th>
                        <th class="px-4 py-3 font-semibold text-gray-600 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($users as $i => $user)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 text-center text-gray-600">{{ $users->firstItem() + $i }}</td>
                        <td class="px-4 py-3">
                            @if($user->foto)
                                <img src="{{ asset('storage/' . $user->foto) }}" alt="{{ $user->name }}" class="h-9 w-9 rounded-full object-cover" />
                            @else
                                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-gray-200 text-sm font-bold text-gray-600">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-3 font-semibold text-gray-900">{{ $user->name }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $user->email }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $user->no_hp ?? '-' }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex rounded-full px-2.5 py-0.5 text-[11px] font-semibold {{ $user->status === 'aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                {{ ucfirst(str_replace('_', ' ', $user->status)) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex justify-center gap-1">
                                <a href="{{ route('admin.pengelola.show', [$roleFilter, $user->id]) }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-blue-600 border border-blue-400 hover:bg-blue-600 hover:text-white transition" title="Detail">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <a href="{{ route('admin.pengelola.edit', [$roleFilter, $user->id]) }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-amber-50 text-amber-600 border border-amber-400 hover:bg-amber-500 hover:text-white transition" title="Edit Profil">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('admin.pengelola.toggle-status', [$roleFilter, $user->id]) }}" class="inline">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="inline-flex h-8 w-8 items-center justify-center rounded-lg {{ $user->status === 'aktif' ? 'bg-orange-50 text-orange-600 border border-orange-400 hover:bg-orange-500' : 'bg-emerald-50 text-emerald-600 border border-emerald-400 hover:bg-emerald-500' }} hover:text-white transition" title="{{ $user->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                    </button>
                                </form>
                                <button type="button" class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-red-50 text-red-600 border border-red-400 hover:bg-red-600 hover:text-white transition"
                                    title="Hapus"
                                    data-delete-route="{{ route('admin.pengelola.destroy', [$roleFilter, $user->id]) }}"
                                    data-name="{{ $roleLabel }} {{ $user->name }}"
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
        <div class="mt-4">{{ $users->links() }}</div>
        @else
        <div class="flex min-h-[250px] flex-col items-center justify-center gap-2 text-center text-gray-500">
            <svg class="h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/></svg>
            <p class="font-semibold text-gray-900">Belum ada data {{ $roleLabel }}</p>
            <p class="text-sm">Tambahkan akun {{ $roleLabel }} lewat menu Tambah User atau Data User.</p>
        </div>
        @endif
    </div>
</div>
@endsection

@push('modals')
    @include('layouts.partials.admin.modals')
@endpush
