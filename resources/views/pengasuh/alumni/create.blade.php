@extends('layouts.app')
@section('page-title', 'Jadikan Alumni')

@section('content')
<div class="max-w-3xl mx-auto overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

    <!-- Header -->
    <div class="border-b border-gray-200 bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4 flex justify-between items-center gap-4">
        <div class="min-w-0">
            <h2 class="text-lg font-bold text-white truncate">Form Jadikan Alumni</h2>
            <p class="text-xs md:text-sm text-purple-200">Data dasar diambil dari Anak Asuh: {{ $anakAsuh->nama }}</p>
        </div>
        <a href="{{ route('pengasuh.anak-asuh.index') }}" class="text-xs md:text-sm font-semibold text-white hover:text-purple-200 flex items-center transition-colors whitespace-nowrap">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span class="hidden sm:inline">Kembali</span>
        </a>
    </div>

    <div class="p-4 md:p-6">
        <form action="{{ route('pengasuh.alumni.store', $anakAsuh->id) }}" method="POST">
            @csrf

            <!-- IDENTITAS ANAK ASUH (READONLY) -->
            <div class="mb-6 p-4 bg-gray-50 border border-gray-200 rounded-xl">
                <h3 class="text-sm font-bold text-gray-800 mb-4 border-b border-gray-200 pb-2">Identitas Anak Asuh (Otomatis Tersimpan)</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <span class="block text-xs text-gray-500 mb-1">Nama Lengkap</span>
                        <p class="text-sm font-semibold text-gray-900">{{ $anakAsuh->nama }}</p>
                    </div>
                    <div>
                        <span class="block text-xs text-gray-500 mb-1">Nama Panggilan</span>
                        <p class="text-sm font-semibold text-gray-900">{{ $anakAsuh->nama_panggilan ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="block text-xs text-gray-500 mb-1">TTL</span>
                        <p class="text-sm font-semibold text-gray-900">{{ $anakAsuh->tempat_lahir }}, {{ \Carbon\Carbon::parse($anakAsuh->tanggal_lahir)->format('d-m-Y') }}</p>
                    </div>
                    <div>
                        <span class="block text-xs text-gray-500 mb-1">Jenis Kelamin</span>
                        <p class="text-sm font-semibold text-gray-900">{{ $anakAsuh->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                    </div>
                    <div>
                        <span class="block text-xs text-gray-500 mb-1">Tinggal Sejak</span>
                        <p class="text-sm font-semibold text-gray-900">{{ $anakAsuh->tinggal_di_lksa_sejak ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- DATA KHUSUS ALUMNI -->
            <h3 class="text-sm font-bold text-gray-800 mb-4">Lengkapi Data Khusus Alumni</h3>

            <div class="mb-5">
                <label class="text-sm font-bold text-gray-800 block mb-2">Tanggal Keluar <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal_keluar" value="{{ old('tanggal_keluar') }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent text-sm" required>
            </div>

            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 mb-5">
                <div>
                    <label class="text-sm font-bold text-gray-800 block mb-2">Pendidikan Terakhir</label>
                    <input type="text" name="pendidikan_terakhir" value="{{ old('pendidikan_terakhir') }}" placeholder="Contoh: SMA / S1" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent text-sm placeholder:text-gray-400">
                </div>
                <div>
                    <label class="text-sm font-bold text-gray-800 block mb-2">Nama Sekolah Terakhir</label>
                    <input type="text" name="nama_sekolah_terakhir" value="{{ old('nama_sekolah_terakhir', $anakAsuh->sekolah) }}" placeholder="Masukkan Sekolah Terakhir..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent text-sm placeholder:text-gray-400">
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 mb-5">
                <div>
                    <label class="text-sm font-bold text-gray-800 block mb-2">Pekerjaan</label>
                    <input type="text" name="pekerjaan" value="{{ old('pekerjaan') }}" placeholder="Masukkan Pekerjaan saat ini..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent text-sm placeholder:text-gray-400">
                </div>
                <div>
                    <label class="text-sm font-bold text-gray-800 block mb-2">No. HP</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="Masukkan Nomor HP..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent text-sm placeholder:text-gray-400">
                </div>
            </div>

            <div class="mb-5">
                <label class="text-sm font-bold text-gray-800 block mb-2">Alamat Lengkap</label>
                <textarea name="alamat" rows="3" placeholder="Masukkan Alamat Lengkap..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent text-sm placeholder:text-gray-400">{{ old('alamat') }}</textarea>
            </div>

            <div class="mb-5">
                <label class="text-sm font-bold text-gray-800 block mb-2">Catatan (Opsional)</label>
                <textarea name="catatan" rows="3" placeholder="Tambahkan catatan khusus..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent text-sm placeholder:text-gray-400">{{ old('catatan') }}</textarea>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-center items-center gap-4 pt-6 border-t border-gray-200 mt-6 pb-2">
                <a href="{{ route('pengasuh.anak-asuh.index') }}" class="rounded-xl bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 border border-gray-300 transition hover:bg-gray-300">
                    Batal
                </a>
                <button type="submit" class="rounded-xl bg-purple-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-purple-700">
                    Simpan Alumni
                </button>
            </div>
            
        </form>
    </div>
</div>
@endsection
