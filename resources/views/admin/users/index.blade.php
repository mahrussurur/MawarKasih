@extends('layouts.app')
@section('page-title', 'Data User')
@section('title', 'Data User | Panti Asuhan Mawar Kasih')

@section('content')
<div>
    <!-- Toolbar -->
    <div class="flex justify-between mb-4">
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('users.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah User
            </a>
        </div>
    </div>

    @php
        $roles = ['semua' => 'Semua', 'admin' => 'Admin', 'bendahara' => 'Bendahara', 'sekretaris' => 'Sekretaris', 'pengasuh' => 'Pengasuh', 'donatur' => 'Donatur'];
        $currentRole = $activeRole ?? null;
    @endphp

    <!-- Kotak Utama Konten -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6">

        <div class="flex flex-col gap-4 border-b border-gray-200 pb-4 lg:flex-row lg:items-center lg:justify-between">
            <!-- Filter Role -->
            <div class="flex w-full items-center gap-3 lg:w-auto">
                <select
                    onchange="window.location.href = this.value"
                    class="w-full appearance-none rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 pr-10 text-sm font-semibold text-gray-600
                        focus:border-transparent focus:outline-none focus:ring-2 focus:ring-brand-500"
                >
                    @foreach($roles as $key => $label)
                        <option
                            value="{{ $key === 'semua' ? route('users.index') : route('users.index', ['role' => $key]) }}"
                            {{ ($key === 'semua' && !$currentRole) || $currentRole === $key ? 'selected' : '' }}
                        >
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Search -->
            <form method="GET" action="{{ route('users.index') }}" class="flex w-full items-center gap-3 lg:w-auto">
                <input type="hidden" name="role" value="{{ $currentRole }}">
                <label class="relative block w-full lg:w-[260px]">
                    <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-gray-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / email..."
                           class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent text-sm" />
                </label>
            </form>
        </div>

        <!-- Table Data -->
        @if($users->count() > 0)
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left divide-y divide-gray-200 text-sm border-b border-gray-200 whitespace-nowrap">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 font-semibold text-gray-700 text-center w-12">No</th>
                        <th class="px-6 py-4 font-semibold text-gray-700 w-20">Foto</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Nama</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Email</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">No HP</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Jabatan</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Role</th>
                        <th class="px-6 py-4 font-semibold text-gray-700 text-center sticky right-0 bg-gray-50 z-10 shadow-[inset_1px_0_0_#e5e7eb]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($users as $index => $user)
                    <tr class="hover:bg-gray-50 transition-colors group">
                        <td class="px-6 py-4 text-center text-gray-700">{{ $users->firstItem() + $index }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($user->foto)
                                <button type="button"
                                    class="inline-flex"
                                    onclick="openImagePreview('{{ asset('storage/'.$user->foto) }}')"
                                    aria-label="Perbesar foto {{ $user->name }}">
                                    <img src="{{ asset('storage/'.$user->foto) }}"
                                        class="w-12 h-12 rounded object-cover mx-auto cursor-pointer transition duration-200 hover:scale-105"
                                        alt="Foto {{ $user->name }}"
                                        title="Klik untuk perbesar">
                                </button>
                            @else
                                <span class="text-gray-400 font-medium">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-900">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $user->no_hp ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $user->jabatan ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-semibold ring-1 ring-inset
                                {{ $user->status === 'aktif' ? 'bg-green-50 text-green-700 ring-green-600/20' : 'bg-red-50 text-red-700 ring-red-600/10' }}">
                                {{ $user->status === 'aktif' ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $roleColors = ['admin' => 'blue', 'bendahara' => 'emerald', 'sekretaris' => 'purple', 'pengasuh' => 'orange', 'donatur' => 'violet'];
                                $c = $roleColors[$user->role] ?? 'gray';
                            @endphp
                            <span class="inline-flex items-center rounded-md bg-{{ $c }}-50 px-2 py-1 text-xs font-semibold text-{{ $c }}-700 ring-1 ring-inset ring-{{ $c }}-700/10">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center sticky right-0 bg-white group-hover:bg-gray-50 z-10 transition-colors shadow-[inset_1px_0_0_#e5e7eb]">
                            <div class="flex justify-center gap-1">
                                <!-- Tombol Edit -->
                                <a href="{{ route('users.edit', $user) }}"
                                   class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-amber-500 bg-yellow-100 text-amber-700 transition hover:bg-amber-500 hover:text-white"
                                   title="Edit">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <!-- Tombol Hapus -->
                                <button type="button"
                                        class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-red-600 bg-red-100 text-red-700 transition hover:bg-red-600 hover:text-white"
                                        title="Hapus"
                                        data-delete-route="{{ route('users.destroy', $user) }}"
                                        data-name="{{ $user->name }}"
                                        onclick="openDeleteModal(this)">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @include('layouts.partials.admin._pagination', ['paginator' => $users])

        @else
        <div class="flex min-h-[300px] flex-col items-center justify-center gap-3 px-6 py-10 text-center text-gray-500">
            <p class="text-base font-semibold text-gray-900">
                Belum ada data user{{ $currentRole ? ' dengan role ' . ucfirst($currentRole) : '' }}
            </p>
            <span class="text-sm text-gray-500">
                {{ request('search') ? 'Data "'. request('search') . '" tidak ditemukan' : 'Tambahkan data user baru' }}
            </span>
        </div>
        @endif
    </div>
</div>
@endsection