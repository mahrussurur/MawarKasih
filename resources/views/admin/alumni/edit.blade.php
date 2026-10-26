@extends('layouts.app')
@section('page-title', 'Data Alumni')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Main Content Card -->
    <div class="overflow-hidden rounded-2xl bg-white shadow-sm border border-gray-200">
        
        <!-- Header / Banner Cover -->
        <div class="relative bg-gradient-to-r from-amber-500 to-amber-600 px-6 py-6 sm:px-8 sm:py-7">
            <div class="flex flex-row items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-white sm:text-2xl">Edit Profil Alumni</h2>
                    <p class="text-sm text-amber-100 mt-0.5">Perbarui informasi profil alumni.</p>
                </div>
                <!-- Tombol Kembali -->
                <a href="{{ route('alumni.index') }}" 
                   class="inline-flex items-center gap-2 rounded-xl bg-white/20 backdrop-blur-sm border border-white/30 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-white/30 transition flex-shrink-0" 
                   title="Kembali">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span class="hidden sm:inline">Kembali</span>
                </a>
            </div>
        </div>

        <form action="{{ route('alumni.update', $alumni->id) }}" method="POST" enctype="multipart/form-data" class="p-4 md:p-6">
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
                <label class="mb-1.5 block text-sm font-semibold text-gray-800">Tanggal Keluar <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal_keluar" value="{{ old('tanggal_keluar', $alumni->tanggal_keluar) }}" required class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 mb-5">
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-800">Pendidikan Terakhir</label>
                    <input type="text" name="pendidikan_terakhir" value="{{ old('pendidikan_terakhir', $alumni->pendidikan_terakhir) }}" placeholder="Cth: SMA / S1" class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-800">Nama Sekolah Terakhir</label>
                    <input type="text" name="nama_sekolah_terakhir" value="{{ old('nama_sekolah_terakhir', $alumni->nama_sekolah_terakhir) }}" placeholder="Sekolah Terakhir..." class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 mb-5">
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-800">Pekerjaan</label>
                    <input type="text" name="pekerjaan" value="{{ old('pekerjaan', $alumni->pekerjaan) }}" placeholder="Pekerjaan saat ini..." class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-800">No. HP</label>
                    <input type="tel" name="no_hp" value="{{ old('no_hp', $alumni->no_hp) }}" placeholder="cth. 081234567890" minlength="10" maxlength="15" pattern="[0-9]{10,15}" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>
            </div>

            <div class="mb-5">
                <label class="mb-1.5 block text-sm font-semibold text-gray-800">Alamat Lengkap</label>
                <textarea name="alamat" rows="3" placeholder="Alamat Lengkap..." class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('alamat', $alumni->alamat) }}</textarea>
            </div>

            <div class="mb-5">
                <label class="mb-1.5 block text-sm font-semibold text-gray-800">Catatan</label>
                <textarea name="catatan" rows="3" placeholder="Catatan Khusus..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm placeholder:text-gray-400">{{ old('catatan', $alumni->catatan) }}</textarea>
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
