@extends('layouts.app')
@section('page-title', 'Data Donasi')

@section('content')
<div class="max-w-3xl mx-auto overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
        
        <!-- Header -->
        <div class="border-b border-gray-200 bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex justify-between items-center gap-4">
            <div class="min-w-0">
                <h2 class="text-lg font-bold text-white truncate">Edit Data Donasi</h2>
                <p class="text-xs md:text-sm text-gray-300">Ubah detail data donasi di bawah ini.</p>
            </div>
            <a href="{{ route('bendahara.donasi.index') }}" class="text-xs md:text-sm font-semibold text-white hover:text-gray-400 flex items-center transition-colors whitespace-nowrap">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="hidden sm:inline">Kembali</span>
            </a>
        </div>

        <div class="p-4 md:p-6">
            <form action="{{ route('bendahara.donasi.update', $donasi->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="mb-5">
                    <label class="text-sm font-bold text-gray-800 block mb-2">Nama Donatur</label>
                    <input type="text" name="nama_donatur" value="{{ old('nama_donatur', $donasi->nama_donatur) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm placeholder:text-gray-400" required>
                </div>

                <div class="mb-5">
                    <label class="text-sm font-bold text-gray-800 block mb-2">No. HP</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp', $donasi->no_hp) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm placeholder:text-gray-400">
                </div>
                
                <div class="mb-5">
                    <label class="text-sm font-bold text-gray-800 block mb-2">Tanggal</label>
                    <input 
                    type="date" 
                    name="tanggal" 
                    value="{{ old('tanggal', $donasi->tanggal ? \Carbon\Carbon::parse($donasi->tanggal)->format('Y-m-d') : date('Y-m-d')) }}" 
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm placeholder:text-gray-400" 
                    required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                    <div>
                        <label class="text-sm font-bold text-gray-800 block mb-2">Nominal</label>
                        <input type="number" name="nominal" value="{{ old('nominal', $donasi->nominal) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm placeholder:text-gray-400" min="1000" required>
                    </div>

                    <div>
                        <label class="text-sm font-bold text-gray-800 block mb-2">Metode Pembayaran</label>
                        <select name="metode_pembayaran" id="metode_pembayaran"
                            class="w-full h-[48px] px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm text-gray-500 appearance-none"
                            required> 
                            <option value="" disabled>Pilih Metode Pembayaran</option>
                            <option value="mandiri" {{ old('metode_pembayaran', $donasi->metode_pembayaran) == 'mandiri' ? 'selected' : '' }}>Transfer Mandiri</option>
                            <option value="qris" {{ old('metode_pembayaran', $donasi->metode_pembayaran) == 'qris' ? 'selected' : '' }}>QRIS</option>
                        </select>
                    </div>
                </div>

                <div class="mb-5">
                    <label class="text-sm font-bold text-gray-800 block mb-2">Keterangan</label>
                    <textarea name="keterangan" rows="2" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm placeholder:text-gray-400" placeholder="Tambahkan keterangan donasi...">{{ old('keterangan', $donasi->keterangan) }}</textarea>
                </div>

                <!-- Input Bukti Transfer -->
                <div class="mb-8">
                    <label class="text-sm font-bold text-gray-800 block mb-2">Bukti Transfer</label>

                    <!-- Menampilkan preview bukti lama jika ada -->
                    @if($donasi->bukti_transfer)
                        <div class="mb-3">
                            <p class="text-sm text-gray-500 mb-1">Bukti saat ini:</p>
                            <img src="{{ Storage::url($donasi->bukti_transfer) }}" class="w-32 h-32 object-cover rounded-lg border border-gray-200">
                        </div>
                    @endif

                    <input type="file" name="bukti_transfer" accept="image/*" class="w-full text-sm text-gray-600 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100 cursor-pointer border border-gray-200 rounded-xl bg-gray-50">
                    <p class="text-xs text-gray-500 mt-2">Biarkan kosong jika tidak ingin mengubah bukti. Format: JPG, PNG, JPEG. Maksimal 2MB.</p>
                </div>

                <div class="flex justify-center items-center gap-4 pt-6 border-t border-gray-200 mt-6 pb-2">
                    <a href="{{ route('bendahara.donasi.index') }}" class="rounded-xl bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 border border-gray-300 transition hover:bg-gray-300">
                        Batal
                    </a>
                    <button type="submit" class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700">
                        Update
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection
