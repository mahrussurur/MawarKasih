@extends('layouts.app')
@section('page-title', 'Data User')

@section('content')
@php
    $roles = ['semua' => 'Semua', 'admin' => 'Admin', 'bendahara' => 'Bendahara', 'sekretaris' => 'Sekretaris', 'pengasuh' => 'Pengasuh', 'donatur' => 'Donatur'];
    $currentRole = $activeRole ?? null;
@endphp
<!-- Kotak Utama Konten -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6">
    
    <div class="flex flex-col gap-4 border-b border-gray-200 pb-4 lg:flex-row lg:items-center lg:justify-between">
        <!-- Filter -->
        <div class="w-full lg:w-auto">
            <select onchange="window.location.href = this.value" class="w-full appearance-none rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm font-semibold text-gray-600 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-brand-500 lg:w-52">
                @foreach($roles as $key => $label)
                    <option value="{{ $key === 'semua' ? route('users.index') : route('users.index', ['role' => $key]) }}" @selected(($key === 'semua' && ! $currentRole) || $currentRole === $key)>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <!-- Search -->
        <form method="GET" action="{{ route('users.index') }}" class="w-full lg:w-auto">
            <input type="hidden" name="role" value="{{ $currentRole }}">
            <label class="relative block lg:w-72">
                <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-gray-400">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari username / email..." class="w-full rounded-xl border border-gray-200 bg-gray-50 py-2.5 pl-10 pr-4 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-brand-500" />
            </label>
        </form>
    </div>

    <!-- table data user -->
    @if($users->isNotEmpty())
        <div class="overflow-x-auto">
            <table class="w-full text-left divide-y divide-gray-200 text-sm border-b border-gray-200 whitespace-nowrap">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="w-12 px-6 py-4 text-center font-semibold text-gray-700">No</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Username</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Email</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Role</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Status Akun</th>
                        <th class="px-6 py-4 text-center font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($users as $index => $user)
                        <tr class="transition-colors hover:bg-gray-50">
                            <td class="px-6 py-4 text-center text-gray-700">{{ $users->firstItem() + $index }}</td>
                            <td class="px-6 py-4 font-semibold text-gray-900">{{ $user->username }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ ucfirst($user->role) }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex rounded-md px-2 py-1 text-xs font-semibold ring-1 ring-inset {{ $user->status === 'aktif' ? 'bg-green-50 text-green-700 ring-green-600/20' : 'bg-red-50 text-red-700 ring-red-600/10' }}">{{ $user->status === 'aktif' ? 'Aktif' : 'Tidak Aktif' }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-1">
                                    <a href="{{ route('users.edit', $user) }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-amber-50 text-amber-600 border border-amber-400 hover:bg-amber-500 hover:text-white transition" title="Edit Profil">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form method="POST" action="{{ route('users.toggle-status', $user->id) }}" class="inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="inline-flex h-8 w-8 items-center justify-center rounded-lg {{ $user->status === 'aktif' ? 'bg-red-50 text-red-600 border border-red-400 hover:bg-red-500' : 'bg-emerald-50 text-emerald-600 border border-emerald-400 hover:bg-emerald-500' }} hover:text-white transition" title="{{ $user->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}">
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @include('layouts.partials.admin._pagination', ['paginator' => $users])
    @else
        <div class="flex min-h-[300px] flex-col items-center justify-center gap-3 px-6 py-10 text-center text-gray-500">
            <p class="text-base font-semibold text-gray-900">Akun tidak ditemukan.</p>
            <span class="text-sm">Ubah kata kunci pencarian atau filter role.</span>
        </div>
    @endif
</div>
@endsection
