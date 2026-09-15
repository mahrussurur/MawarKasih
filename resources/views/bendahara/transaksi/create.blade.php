@extends('layouts.app')
@section('title', 'Tambah Transaksi Manual')
@section('page-title', 'Catat Transaksi')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('bendahara.transaksi.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-500 hover:text-gray-800 transition">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
    </div>

    <form method="POST" action="{{ route('bendahara.transaksi.store') }}" class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8">
        @csrf
        
        <h3 class="text-lg font-bold text-gray-900 mb-6">Informasi Transaksi</h3>

        <div class="grid gap-5">
            <div>
                <label class="mb-1.5 block text-sm font-semibold text-gray-700">Jenis Transaksi</label>
                <select name="jenis" class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500" required>
                    <option value="pemasukan" {{ old('jenis') == 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                    <option value="pengeluaran" {{ old('jenis') == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                </select>
                @error('jenis') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-semibold text-gray-700">Nominal (Rp)</label>
                <input type="number" name="nominal" value="{{ old('nominal') }}" placeholder="Contoh: 500000" min="1"
                       class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500" required />
                @error('nominal') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-semibold text-gray-700">Tanggal</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}"
                       class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500" required />
                @error('tanggal') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-semibold text-gray-700">Keterangan</label>
                <textarea name="keterangan" rows="3" placeholder="Deskripsi transaksi..."
                          class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500" required>{{ old('keterangan') }}</textarea>
                @error('keterangan') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mt-8 flex justify-end gap-3 pt-6 border-t border-gray-100">
            <button type="submit" class="rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Simpan Transaksi
            </button>
        </div>
    </form>
</div>
@endsection
