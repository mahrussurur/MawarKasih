@extends('layouts.app')
@section('page-title', 'Data Keuangan')

@section('content')
<div class="max-w-2xl mx-auto overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

    <!-- Header -->
    <div class="border-b border-gray-200 bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex justify-between items-center gap-4">
        <div class="min-w-0">
            <h2 class="text-lg font-bold text-white truncate">Edit Data Keuangan</h2>
            <p class="text-xs md:text-sm text-gray-300">Ubah informasi transaksi keuangan.</p>
        </div>
        <a href="{{ route('admin.keuangan.index') }}" class="text-xs md:text-sm font-semibold text-white hover:text-gray-400 flex items-center transition-colors whitespace-nowrap">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span class="hidden sm:inline">Kembali</span>
        </a>
    </div>

    <div class="p-4 md:p-6">
        <form method="POST" action="{{ route('admin.keuangan.update', ['transaksi' => $transaksi]) }}">
            @csrf @method('PUT')

            <!-- Jenis Transaksi -->
            <div class="mb-5">
                <label class="text-sm font-bold text-gray-800 block mb-2">Jenis Transaksi <span class="text-red-500">*</span></label>
                <select name="jenis" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" required>
                    <option value="pemasukan" {{ old('jenis', $transaksi->jenis) == 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                    <option value="pengeluaran" {{ old('jenis', $transaksi->jenis) == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                </select>
                @error('jenis')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <!-- Nominal & Tanggal -->
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 mb-5">
                <div>
                    <label class="text-sm font-bold text-gray-800 block mb-2">Nominal (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="nominal" value="{{ old('nominal', (int)$transaksi->nominal) }}" placeholder="Contoh: 500000" min="1"
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm placeholder:text-gray-400" required>
                    @error('nominal')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-sm font-bold text-gray-800 block mb-2">Tanggal <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', \Carbon\Carbon::parse($transaksi->tanggal)->format('Y-m-d')) }}"
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm text-gray-500" required>
                    @error('tanggal')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- Keterangan -->
            <div class="mb-5">
                <label class="text-sm font-bold text-gray-800 block mb-2">Keterangan <span class="text-red-500">*</span></label>
                <textarea name="keterangan" rows="3" placeholder="Deskripsi transaksi..."
                          class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm placeholder:text-gray-400" required>{{ old('keterangan', $transaksi->keterangan) }}</textarea>
                @error('keterangan')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-center items-center gap-4 pt-6 border-t border-gray-200 mt-4 pb-2">
                <a href="{{ route('admin.keuangan.index') }}"
                   class="rounded-xl bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 border border-gray-300 transition hover:bg-gray-300">
                    Batal
                </a>
                <button type="submit"
                        class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
