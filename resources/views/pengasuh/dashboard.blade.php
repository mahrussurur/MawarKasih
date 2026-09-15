@extends('layouts.app')

@section('title', 'Dashboard Pengasuh')
@section('page-title', 'Dashboard')

@section('content')
<div>
    <div class="mb-6">
        <h2 class="text-2xl font-extrabold text-gray-900">Selamat Datang, {{ Auth::user()->name }}!</h2>
        <p class="mt-1 text-sm font-medium text-gray-500">Berikut adalah ringkasan data anak asuh panti.</p>
    </div>
    
    <div class="grid gap-4 grid-cols-1 md:grid-cols-2 mb-6">
        <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-indigo-100 text-indigo-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Total Anak Asuh</p>
                <p class="text-xl font-bold text-gray-900">{{ $totalAnak }} Orang</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4 border-b border-gray-100 pb-4">
            <h3 class="text-lg font-bold text-gray-900">Anak Asuh Terbaru Terdaftar</h3>
            <a href="{{ route('pengasuh.anak-asuh.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700">Lihat Semua →</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-4 py-3 font-semibold text-gray-600">Nama Lengkap</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Umur / Tgl Lahir</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Pendidikan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($anakTerbaru as $anak)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-900">
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-full overflow-hidden bg-gray-100">
                                        @if($anak->foto)
                                            <img src="{{ Storage::url($anak->foto) }}" alt="Foto" class="h-full w-full object-cover">
                                        @else
                                            <div class="flex h-full w-full items-center justify-center text-xs text-gray-400">?</div>
                                        @endif
                                    </div>
                                    {{ $anak->nama }}
                                </div>
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ \Carbon\Carbon::parse($anak->tanggal_lahir)->age }} Tahun ({{ \Carbon\Carbon::parse($anak->tanggal_lahir)->format('d M Y') }})</td>
                            <td class="px-4 py-3 text-gray-600">{{ $anak->sekolah }} - {{ $anak->kelas }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-8 text-center text-gray-500">Belum ada data anak asuh</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
