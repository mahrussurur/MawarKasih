@extends('admin.layouts.app')
@section('page-title', 'Data Donasi')

@section('content')
<div class="p-4 md:p-6 bg-gray-100 min-h-screen">

    <!-- Container lebih sempit: max-w-3xl (768px) -->
    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow overflow-hidden">
        
        <!-- Header -->
        <div class="p-2 md:p-4 border-b border-gray-200 flex justify-between items-center gap-4 bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex justify-between items-center">
            <div class="min-w-0">
                <h2 class="text-lg font-bold text-white truncate">Edit Data Donasi</h2>
                <p class="text-xs md:text-sm text-gray-300">Ubah detail data donasi di bawah ini.</p>
            </div>
            <a href="{{ route('donasi.index') }}" class="text-xs md:text-sm font-semibold text-white hover:text-gray-400 flex items-center transition-colors whitespace-nowrap">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="hidden sm:inline">Kembali</span>
            </a>
        </div>

        <div class="p-4 md:p-6">
            <form action="{{ route('donasi.update', $donasi->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="mb-5">
                    <label class="block text-gray-800 font-semibold mb-2">Nama Donatur</label>
                    <input type="text" name="nama_donatur" value="{{ old('nama_donatur', $donasi->nama_donatur) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>

                <div class="mb-5">
                    <label class="block text-gray-800 font-semibold mb-2">No. HP</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp', $donasi->no_hp) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div class="mb-5">
                    <label class="block text-gray-800 font-semibold mb-2">Nominal</label>
                    <input type="number" name="nominal" value="{{ old('nominal', $donasi->nominal) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400" min="1000" required>
                </div>

                <div class="mb-5">
                    <label class="block text-gray-800 font-semibold mb-2">Tanggal</label>
                    <input 
                        type="date" 
                        name="tanggal" 
                        value="{{ old('tanggal', $donasi->tanggal ? \Carbon\Carbon::parse($donasi->tanggal)->format('Y-m-d') : date('Y-m-d')) }}" 
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400" 
                        required>
                </div>

                <div class="mb-5">
                    <label class="block text-gray-800 font-semibold mb-2">Keterangan</label>
                    <textarea name="keterangan" rows="2" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Tambahkan keterangan donasi...">{{ old('keterangan', $donasi->keterangan) }}</textarea>
                </div>

                <!-- Input Bukti Transfer -->
                <div class="mb-8">
                    <label class="block text-gray-800 font-semibold mb-2">Bukti Transfer</label>

                    <!-- Menampilkan preview bukti lama jika ada -->
                    @if($donasi->bukti_transfer)
                        <div class="mb-3">
                            <p class="text-sm text-gray-500 mb-1">Bukti saat ini:</p>
                            <img src="{{ Storage::url($donasi->bukti_transfer) }}" class="w-32 h-32 object-cover rounded-lg border border-gray-200">
                        </div>
                    @endif

                    <input type="file" name="bukti_transfer" accept="image/*" class="w-full rounded-2xl file:mr-4 file:py-2 file:px-4 file:rounded-2xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-[#1a56db] hover:file:bg-blue-100 cursor-pointer">
                    <p class="text-xs text-gray-500 mt-2">Biarkan kosong jika tidak ingin mengubah bukti. Format: JPG, PNG, JPEG. Maksimal 2MB.</p>
                </div>

                <div class="flex justify-center items-center gap-4 pt-6 border-t border-gray-200 mt-6 pb-2">
                    <a href="{{ route('donasi.index') }}" class="rounded-2xl bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 border border-gray-300  transition hover:bg-gray-300">
                        Batal
                    </a>
                    <button type="submit" class="rounded-2xl bg-blue-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-600">
                        Update
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection