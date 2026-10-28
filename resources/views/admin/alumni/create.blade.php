@extends('layouts.app')
@section('page-title', 'Jadikan Alumni')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Main Content Card -->
    <div class="overflow-hidden rounded-2xl bg-white shadow-sm border border-gray-200">
        
        <!-- Header / Banner Cover -->
        <div class="relative bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-6 sm:px-8 sm:py-7">
            <div class="flex flex-row items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-white sm:text-2xl">Form Alumni</h2>
                    <p class="text-sm text-purple-100 mt-0.5">Data dasar diambil dari Anak Asuh: {{ $anakAsuh->nama }}</p>
                </div>
                <!-- Tombol Kembali -->
                <a href="{{ route('anak-asuh.index') }}" 
                   class="inline-flex items-center gap-2 rounded-xl bg-white/20 backdrop-blur-sm border border-white/30 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-white/30 transition flex-shrink-0" 
                   title="Kembali">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span class="hidden sm:inline">Kembali</span>
                </a>
            </div>
        </div>

        <form action="{{ route('alumni.store', $anakAsuh->id) }}" method="POST" class="p-4 md:p-6">
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
                <label class="mb-1.5 block text-sm font-semibold text-gray-800">Tanggal Keluar <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal_keluar" value="{{ old('tanggal_keluar') }}" class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 mb-5">
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-800">Pendidikan Terakhir</label>
                    <input type="text" name="pendidikan_terakhir" value="{{ old('pendidikan_terakhir') }}" placeholder="Cth: SMA / S1" class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-800">Nama Sekolah Terakhir</label>
                    <input type="text" name="nama_sekolah_terakhir" value="{{ old('nama_sekolah_terakhir', $anakAsuh->sekolah) }}" placeholder="Sekolah Terakhir..." class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 mb-5">
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-800">Pekerjaan</label>
                    <input type="text" name="pekerjaan" value="{{ old('pekerjaan') }}" placeholder="Pekerjaan saat ini..." class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-800">No. HP</label>
                    <input type="tel" name="no_hp" value="{{ old('no_hp') }}" placeholder="cth. 081234567890" minlength="10" maxlength="15" pattern="[0-9]{10,15}" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="mb-5">
                <label class="mb-1.5 block text-sm font-semibold text-gray-800">Alamat Lengkap</label>
                <textarea name="alamat" rows="3" placeholder="Alamat Lengkap..." class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('alamat') }}</textarea>
            </div>

            <div class="mb-5">
                <label class="mb-1.5 block text-sm font-semibold text-gray-800">Catatan</label>
                <textarea name="catatan" rows="3" placeholder="Catatan Khusus..." class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('catatan') }}</textarea>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-center items-center gap-4 pt-6 border-t border-gray-200 mt-6 pb-2">
                <a href="{{ route('anak-asuh.index') }}" class="rounded-xl bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 border border-gray-300 transition hover:bg-gray-300">
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
