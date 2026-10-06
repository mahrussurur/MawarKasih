@extends('layouts.app')
@section('page-title', 'Edit Alumni')

@section('content')
<div class="max-w-3xl mx-auto overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

    <!-- Header -->
    <div class="border-b border-gray-200 bg-gradient-to-r from-amber-500 to-amber-600 px-6 py-4 flex justify-between items-center gap-4">
        <div class="min-w-0">
            <h2 class="text-lg font-bold text-white truncate">Edit Data Alumni</h2>
            <p class="text-xs md:text-sm text-amber-100">Perbarui informasi pasca LKSA untuk alumni ini.</p>
        </div>
        <a href="{{ route('alumni.index') }}" class="text-xs md:text-sm font-semibold text-white hover:text-amber-100 flex items-center transition-colors whitespace-nowrap">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span class="hidden sm:inline">Kembali</span>
        </a>
    </div>

    <div class="p-4 md:p-6">
        <form action="{{ route('alumni.update', $alumni->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- IDENTITAS ALUMNI (READONLY) -->
            <div class="mb-6 p-4 bg-gray-50 border border-gray-200 rounded-xl flex items-center gap-4">
                <img src="{{ asset('storage/' . $alumni->foto) }}" alt="Foto" class="h-16 w-16 rounded-full object-cover border-2 border-white shadow-sm">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">{{ $alumni->nama }}</h3>
                    <p class="text-sm text-gray-500">Tahun Keluar: {{ \Carbon\Carbon::parse($alumni->tanggal_keluar)->format('Y') }}</p>
                </div>
            </div>

            <!-- DATA KHUSUS ALUMNI (EDITABLE) -->
            <h3 class="text-sm font-bold text-gray-800 mb-4 border-b border-gray-200 pb-2">Informasi Pasca LKSA</h3>

            <div class="mb-5">
                <label class="text-sm font-bold text-gray-800 block mb-2">Tanggal Keluar <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal_keluar" value="{{ old('tanggal_keluar', $alumni->tanggal_keluar) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent text-sm" required>
            </div>

            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 mb-5">
                <div>
                    <label class="text-sm font-bold text-gray-800 block mb-2">Pendidikan Terakhir</label>
                    <input type="text" name="pendidikan_terakhir" value="{{ old('pendidikan_terakhir', $alumni->pendidikan_terakhir) }}" placeholder="Contoh: SMA / S1" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent text-sm placeholder:text-gray-400">
                </div>
                <div>
                    <label class="text-sm font-bold text-gray-800 block mb-2">Nama Sekolah Terakhir</label>
                    <input type="text" name="nama_sekolah_terakhir" value="{{ old('nama_sekolah_terakhir', $alumni->nama_sekolah_terakhir) }}" placeholder="Masukkan Sekolah Terakhir..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent text-sm placeholder:text-gray-400">
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 mb-5">
                <div>
                    <label class="text-sm font-bold text-gray-800 block mb-2">Pekerjaan</label>
                    <input type="text" name="pekerjaan" value="{{ old('pekerjaan', $alumni->pekerjaan) }}" placeholder="Masukkan Pekerjaan saat ini..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent text-sm placeholder:text-gray-400">
                </div>
                <div>
                    <label class="text-sm font-bold text-gray-800 block mb-2">No. HP</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp', $alumni->no_hp) }}" placeholder="Masukkan Nomor HP..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent text-sm placeholder:text-gray-400">
                </div>
            </div>

            <div class="mb-5">
                <label class="text-sm font-bold text-gray-800 block mb-2">Alamat Lengkap</label>
                <textarea name="alamat" rows="3" placeholder="Masukkan Alamat Lengkap..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent text-sm placeholder:text-gray-400">{{ old('alamat', $alumni->alamat) }}</textarea>
            </div>

            <div class="mb-5">
                <label class="text-sm font-bold text-gray-800 block mb-2">Catatan (Opsional)</label>
                <textarea name="catatan" rows="3" placeholder="Tambahkan catatan khusus..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent text-sm placeholder:text-gray-400">{{ old('catatan', $alumni->catatan) }}</textarea>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-center items-center gap-4 pt-6 border-t border-gray-200 mt-6 pb-2">
                <a href="{{ route('alumni.index') }}" class="rounded-xl bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 border border-gray-300 transition hover:bg-gray-300">
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
