@extends('layouts.app')
@section('title', 'Edit Data Keuangan Manual')
@section('page-title', 'Edit Data Keuangan')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('bendahara.keuangan.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-500 hover:text-gray-800 transition">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
    </div>

    <form method="POST" action="{{ route('bendahara.keuangan.update', ['keuangan' => $keuangan]) }}" class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8" enctype="multipart/form-data">
        @csrf @method('PUT')
        
        <h3 class="text-lg font-bold text-gray-900 mb-6">Ubah Informasi Keuangan</h3>

        <div class="grid gap-5">
            <div>
                <label class="mb-1.5 block text-sm font-semibold text-gray-700">Jenis Keuangan</label>
                <select name="jenis" class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500" required>
                    <option value="pemasukan" {{ old('jenis', $keuangan->jenis) == 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                    <option value="pengeluaran" {{ old('jenis', $keuangan->jenis) == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                </select>
                @error('jenis') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-semibold text-gray-700">Kategori</label>
                <select name="kategori" class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500" required>
                    <option value="LAINNYA" {{ old('kategori', $keuangan->kategori) == 'LAINNYA' ? 'selected' : '' }}>Lainnya</option>
                    <option value="DONASI" {{ old('kategori', $keuangan->kategori) == 'DONASI' ? 'selected' : '' }}>Donasi</option>
                    <option value="PENDIDIKAN" {{ old('kategori', $keuangan->kategori) == 'PENDIDIKAN' ? 'selected' : '' }}>Pendidikan</option>
                    <option value="KONSUMSI" {{ old('kategori', $keuangan->kategori) == 'KONSUMSI' ? 'selected' : '' }}>Konsumsi</option>
                    <option value="KESEHATAN" {{ old('kategori', $keuangan->kategori) == 'KESEHATAN' ? 'selected' : '' }}>Kesehatan</option>
                    <option value="OPERASIONAL" {{ old('kategori', $keuangan->kategori) == 'OPERASIONAL' ? 'selected' : '' }}>Operasional</option>
                    <option value="TRANSPORTASI" {{ old('kategori', $keuangan->kategori) == 'TRANSPORTASI' ? 'selected' : '' }}>Transportasi</option>
                    <option value="GAJI" {{ old('kategori', $keuangan->kategori) == 'GAJI' ? 'selected' : '' }}>Gaji</option>
                </select>
                @error('kategori') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-semibold text-gray-700">Nominal (Rp)</label>
                <input type="number" name="nominal" value="{{ old('nominal', (int)$keuangan->nominal) }}" placeholder="Contoh: 500000" min="1"
                       class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500" required />
                @error('nominal') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-semibold text-gray-700">Tanggal</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', \Carbon\Carbon::parse($keuangan->tanggal)->format('Y-m-d')) }}"
                       class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500" required />
                @error('tanggal') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-semibold text-gray-700">Keterangan</label>
                <textarea name="keterangan" rows="3" placeholder="Deskripsi data keuangan..."
                          class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500" required>{{ old('keterangan', $keuangan->keterangan) }}</textarea>
                @error('keterangan') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-semibold text-gray-700">Bukti Transaksi (Opsional)</label>
                @if($keuangan->bukti_transaksi)
                    <div class="mb-2">
                        <p class="text-xs text-gray-500 mb-1">Bukti Saat Ini:</p>
                        <a href="{{ asset('storage/' . $keuangan->bukti_transaksi) }}" target="_blank" class="text-sm text-blue-600 hover:underline">Lihat Bukti</a>
                    </div>
                @endif
                <input type="file" name="bukti_transaksi" accept="image/png, image/jpeg, image/jpg"
                       class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                <p class="mt-1 text-xs text-gray-500">Maks. 2MB (JPG/PNG). Kosongkan jika tidak ingin mengubah.</p>
                @error('bukti_transaksi') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mt-8 flex justify-end gap-3 pt-6 border-t border-gray-100">
            <button type="submit" class="rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection

