@extends('layouts.app')
@section('page-title', 'Data Donasi')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Main Content Card -->
    <div class="overflow-hidden rounded-2xl bg-white shadow-sm border border-gray-200">
        
        <!-- Header / Banner Cover -->
        <div class="relative bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-6 sm:px-8 sm:py-7">
            <div class="flex flex-row items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-white sm:text-2xl">Tambah Data Donasi</h2>
                    <p class="text-sm text-blue-100 mt-0.5">Formulir Penambahan Data Donasi.</p>
                </div>
                <!-- Tombol Kembali -->
                <a href="{{ route('donasi.index') }}" 
                   class="inline-flex items-center gap-2 rounded-xl bg-white/20 backdrop-blur-sm border border-white/30 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-white/30 transition flex-shrink-0" 
                   title="Kembali">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span class="hidden sm:inline">Kembali</span>
                </a>
            </div>
        </div>

        <form action="{{ route('donasi.store') }}" method="POST" enctype="multipart/form-data" class="p-4 md:p-6">
            @csrf
            <!-- Nama Donatur -->
            <div class="mb-5">
                <label class="mb-1.5 block text-sm font-semibold text-gray-800">Nama Donatur <span class="text-red-500">*</span></label>
                <input type="text" name="nama_donatur" value="{{ old('nama_donatur') }}" placeholder="Nama Donatur..." class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <!-- Email -->
            <div class="mb-5">
                <label class="mb-1.5 block text-sm font-semibold text-gray-800">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="cth. contoh@gmail.com" maxlength="255" class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <!-- No. HP -->
            <div class="mb-5">
                <label class="mb-1.5 block text-sm font-semibold text-gray-800">No. HP <span class="text-red-500">*</span></label>
                <input type="tel" name="no_hp" value="{{ old('no_hp') }}" placeholder="cth. 081234567890" minlength="10" maxlength="15" pattern="[0-9]{10,15}" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                <!-- Nominal -->
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-800">Nominal <span class="text-red-500">*</span></label>
                    <div class="flex bg-gray-50 border border-gray-200 rounded-xl overflow-hidden focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-transparent">
                        <span class="inline-flex items-center px-4 border-r border-gray-200 text-sm font-medium text-gray-600 select-none">Rp</span>
                        <input type="text" id="nominal_display" class="w-full bg-transparent px-4 py-3 text-sm text-gray-900 placeholder-gray-400 border-none outline-none focus:outline-none focus:ring-0" placeholder="Nominal donasi...">
                    </div>
                    <input type="hidden" name="nominal" id="nominal_hidden" value="{{ old('nominal') }}" required>
                </div>
                <!-- Metode Pembayaran -->
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-800">Metode Pembayaran <span class="text-red-500">*</span></label>
                    <select name="metode_pembayaran" id="metode_pembayaran"
                        class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                        onchange="this.classList.remove('text-gray-400','text-sm'); this.classList.add('text-gray-900')"> 
                        
                        <option value="" disabled selected>Pilih Metode Pembayaran</option>
                        <option class="text-gray-900" value="mandiri" {{ old('metode_pembayaran') == 'mandiri' ? 'selected' : '' }}>Transfer Mandiri</option>
                        <option class="text-gray-900" value="qris" {{ old('metode_pembayaran') == 'qris' ? 'selected' : '' }}>QRIS</option>
                    </select>
                </div>
            </div>
            <!-- Keterangan -->
            <div class="mb-5">
                <label class="mb-1.5 block text-sm font-semibold text-gray-800">Keterangan</label>
                <textarea name="keterangan" rows="2" placeholder="Masukkan Keterangan..." class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500" >{{ old('keterangan') }}</textarea>
            </div>
            <!-- Upload Bukti Transfer -->
            <div class="mb-8">
                <label class="mb-1.5 block text-sm font-semibold text-gray-800">Upload Bukti Transfer</label>
                <input type="file" id="bukti_transfer_input" name="bukti_transfer" accept="image/*" class="w-full text-sm text-gray-600 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100 cursor-pointer border border-gray-200 rounded-xl bg-gray-50">
                <div id="preview_container" class="mt-3 hidden">
                    <img id="bukti_transfer_preview" src="#" alt="Preview Foto" class="max-h-48 w-auto rounded-lg object-cover border border-gray-200 shadow-sm">
                    <button type="button" id="remove_preview" class="mt-2 text-sm text-red-600 hover:text-red-700 font-medium focus:outline-none">Hapus Foto</button>
                </div>
                <p class="text-xs text-gray-500 mt-2">Biarkan kosong jika tidak memerlukan bukti. Format: JPG, PNG, JPEG. Maksimal 2MB.</p>
            </div>
            <!-- Tombol Aksi -->
            <div class="flex justify-center items-center gap-4 pt-6 border-t border-gray-200 mt-6 pb-2">
                <a href="{{ route('donasi.index') }}" class="rounded-xl bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 border border-gray-300 transition hover:bg-gray-300">
                    Batal
                </a>
                <button type="submit" class="rounded-xl bg-green-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-green-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    setupImagePreview('bukti_transfer_input', 'preview_container', 'bukti_transfer_preview', 'remove_preview');

    const display = document.getElementById('nominal_display');
    const hidden  = document.getElementById('nominal_hidden');

    function formatRupiah(value) {
        return value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    display.addEventListener('input', function () {
        let raw = this.value.replace(/[^0-9]/g, '');
        this.value = formatRupiah(raw);
        hidden.value = raw;
    });

    // Load old value on page load
    if (hidden.value) {
        display.value = formatRupiah(hidden.value);
    }
});
</script>
@endpush
