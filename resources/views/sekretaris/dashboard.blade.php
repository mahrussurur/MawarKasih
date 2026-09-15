@extends('layouts.app')

@section('title', 'Dashboard Sekretaris')
@section('page-title', 'Dashboard')

@section('content')
<div>
    <div class="mb-6">
        <h2 class="text-2xl font-extrabold text-gray-900">Selamat Datang, {{ Auth::user()->name }}!</h2>
        <p class="mt-1 text-sm font-medium text-gray-500">Berikut adalah ringkasan informasi dan dokumentasi yayasan.</p>
    </div>
    
    <div class="grid gap-4 grid-cols-1 md:grid-cols-2 mb-6">
        <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-blue-100 text-blue-600">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Total Kegiatan</p>
                <p class="text-xl font-bold text-gray-900">{{ $totalKegiatan }}</p>
            </div>
        </div>

        <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-600">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Total Foto Galeri</p>
                <p class="text-xl font-bold text-gray-900">{{ $totalGaleri }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4 border-b border-gray-100 pb-4">
            <h3 class="text-lg font-bold text-gray-900">Kegiatan Terbaru</h3>
            <a href="{{ route('sekretaris.kegiatan.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700">Lihat Semua →</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-4 py-3 font-semibold text-gray-600">Nama Kegiatan</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($kegiatanTerbaru as $kegiatan)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $kegiatan->nama_kegiatan }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ \Carbon\Carbon::parse($kegiatan->tanggal_pelaksanaan)->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-4 py-8 text-center text-gray-500">Belum ada kegiatan terdaftar</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
