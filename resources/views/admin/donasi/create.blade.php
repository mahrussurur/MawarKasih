@extends('admin.layouts.app')
@section('page-title', 'Data Donasi')

@section('content')
<div class="p-4 md:p-6 bg-slate-100 h-full">
    
    <div class="max-w-3xl mx-auto overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <!-- Header -->
        <div class="p-2 md:p-4 border-b border-gray-200 flex justify-between items-center gap-4 bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex justify-between items-center">
            <div class="min-w-0">
                <h2 class="text-lg font-bold text-white truncate">Tambah Data Donasi</h2>
                <p class="text-xs md:text-sm text-gray-300">Formulir Penambahan Data Donasi.</p>
            </div>
            <a href="{{ route('donasi.index') }}" class="text-xs md:text-sm font-semibold text-white hover:text-gray-400 flex items-center transition-colors whitespace-nowrap">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="hidden sm:inline">Kembali</span>
            </a>
        </div>

        <div class="p-4 md:p-6">
            <form action="{{ route('donasi.store') }}" method="POST">
                @csrf

                <!-- Nama Donatur -->
                <div class="mb-5">
                    <label class="block text-gray-800 font-semibold mb-2">Nama Donatur</label>
                    <input type="text" name="nama_donatur" value="{{ old('nama_donatur') }}" placeholder="Masukkan Nama Donatur..." class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 placeholder:text-sm placeholder:text-gray-400" required>
                </div>

                <!-- No. HP -->
                <div class="mb-5">
                    <label class="block text-gray-800 font-semibold mb-2">No. HP</label>
                    <input type="number" name="no_hp" value="{{ old('no_hp') }}" placeholder="Contoh: 08xxxxxxxxxx" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 placeholder:text-sm placeholder:text-gray-400" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                    <!-- Nominal -->
                    <div>
                        <label class="block text-gray-800 font-semibold mb-2">Nominal</label>
                        <input type="number" name="nominal" value="{{ old('nominal') }}" placeholder="Masukkan Nominal Donasi..." class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 placeholder:text-sm placeholder:text-gray-400" min="1000" required>
                    </div>

                    <!-- Metode Pembayaran -->
                    <div>
                        <label class="block text-gray-800 font-semibold mb-2">Metode Pembayaran</label>
                        <select name="metode_pembayaran" id="metode_pembayaran"
                            class="w-full h-[46px] appearance-none border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm text-gray-400"
                            required
                            onchange="this.classList.remove('text-gray-400','text-sm'); this.classList.add('text-gray-900')"> 
                            
                            <option value="" disabled selected>Pilih Metode Pembayaran</option>
                            <option class="text-gray-900" value="Tunai" {{ old('metode_pembayaran') == 'Tunai' ? 'selected' : '' }}>Tunai</option>
                            <option class="text-gray-900" value="bca" {{ old('metode_pembayaran') == 'bca' ? 'selected' : '' }}>Transfer BCA</option>
                            <option class="text-gray-900" value="mandiri" {{ old('metode_pembayaran') == 'mandiri' ? 'selected' : '' }}>Transfer Mandiri</option>
                            <option class="text-gray-900" value="bni" {{ old('metode_pembayaran') == 'bni' ? 'selected' : '' }}>Transfer BNI</option>
                            <option class="text-gray-900" value="bri" {{ old('metode_pembayaran') == 'bri' ? 'selected' : '' }}>Transfer BRI</option>
                            <option class="text-gray-900" value="qris" {{ old('metode_pembayaran') == 'qris' ? 'selected' : '' }}>QRIS</option>
                        </select>
                    </div>
                </div>

                <!-- Keterangan -->
                <div class="mb-5">
                    <label class="block text-gray-800 font-semibold mb-2">Keterangan</label>
                    <textarea name="keterangan" value="{{ old('keterangan') }}" rows="2" placeholder="Masukkan Keterangan..." class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 placeholder:text-sm placeholder:text-gray-400" required>{{ old('keterangan') }}</textarea>
                </div>

                <!-- Upload Bukti Transfer -->
                <div class="mb-8">
                    <label class="block text-gray-800 font-semibold mb-2">Upload Bukti Transfer</label>
                    <input type="file" name="bukti_transfer" value="{{ old('bukti_transfer') }}" accept="image/*" class="w-full rounded-2xl file:mr-4 file:py-2 file:px-4 file:rounded-2xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-[#1a56db] hover:file:bg-blue-100 cursor-pointer">
                    <p class="text-xs text-gray-500 mt-2">Biarkan kosong jika tidak memerlukan bukti. Format: JPG, PNG, JPEG. Maksimal 2MB.</p>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex justify-center items-center gap-4 pt-6 border-t border-gray-200 mt-6 pb-2">
                    <a href="{{ route('donasi.index') }}" class="rounded-2xl bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 border border-gray-300  transition hover:bg-gray-300">
                        Batal
                    </a>
                    <button type="submit" class="rounded-2xl bg-blue-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-600">
                        Simpan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
