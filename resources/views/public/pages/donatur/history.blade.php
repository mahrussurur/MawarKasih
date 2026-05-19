@extends('public.layouts.app')

@section('title', 'Riwayat Donasi')

@section('content')
<div class="min-h-screen bg-gray-50 py-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Riwayat Donasi</h1>
                <p class="mt-2 text-sm text-gray-500">Lihat status dan detail semua donasi Anda.</p>
            </div>
            <a href="{{ route('public.donasi.form') }}" class="inline-flex items-center gap-2 rounded-full bg-brand-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-brand-700">Buat Donasi Baru</a>
        </div>

        <div class="overflow-x-auto rounded-3xl border border-gray-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">No</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Kode Donasi</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Nominal</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Tanggal</th>
                        <th class="px-6 py-4 text-left font-semibold text-gray-700">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($donasis as $donasi)
                        <tr>
                            <td class="px-6 py-4 text-gray-700">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 font-semibold text-gray-900">{{ $donasi->kode_donasi }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $donasi->nominal_rupiah }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $donasi->tanggal?->format('d M Y') ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $donasi->status == 'valid' ? 'bg-green-100 text-green-700' : ($donasi->status == 'ditolak' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">{{ $donasi->status_label }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">Belum ada riwayat donasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
