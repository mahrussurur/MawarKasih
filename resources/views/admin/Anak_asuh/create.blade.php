@extends('admin.layouts.app')
@section('page-title', 'Data Anak Asuh')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen flex justify-center items-start">
    
    <div class="w-full max-w-3xl bg-white rounded-xl shadow-md p-8 border border-gray-200 mt-4">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Tambah Data Anak Asuh</h2>

        <form action="{{ route('anak-asuh.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-5">
                <label class="block text-gray-800 font-semibold mb-2">Nama Lengkap</label>
                <input type="text" name="nama" value="{{ old('nama') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <div class="mb-5">
                <label class="block text-gray-800 font-semibold mb-2">Nama Panggilan</label>
                <input type="text" name="nama_panggilan" value="{{ old('nama_panggilan') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 mb-5">
                <div>
                    <label class="block text-gray-800 font-semibold mb-2">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>
                <div>
                    <label class="block text-gray-800 font-semibold mb-2">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 text-gray-600" required>
                </div>
            </div>

            <div class="mb-5">
                <label class="block text-gray-800 font-semibold mb-2">Tinggal di LKSA sejak</label>
                <input type="text" name="tinggal_di_lksa_sejak" value="{{ old('tinggal_di_lksa_sejak') }}" placeholder="Contoh: Dari kandungan ibu tahun 2023 atau Tahun 2024" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                <p class="text-xs text-gray-500 mt-1">Isikan apakah sejak dalam kandungan atau tahun masuk LKSA.</p>
            </div>

            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 mb-5">
                <div>
                    <label class="block text-gray-800 font-semibold mb-2">Sekolah</label>
                    <input type="text" name="sekolah" value="{{ old('sekolah') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>
                <div>
                    <label class="block text-gray-800 font-semibold mb-2">Kelas</label>
                    <input type="text" name="kelas" value="{{ old('kelas') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>
            </div>

            <div class="mb-5">
                <label class="block text-gray-800 font-semibold mb-2">Jenis Kelamin</label>
                <div class="w-full border border-gray-300 rounded-lg px-4 py-2.5 flex items-center gap-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="jenis_kelamin" value="L" {{ old('jenis_kelamin') === 'L' ? 'checked' : '' }} class="w-4 h-4 text-blue-600 focus:ring-blue-500" required>
                        <span class="text-gray-700">Laki-laki</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="jenis_kelamin" value="P" {{ old('jenis_kelamin') === 'P' ? 'checked' : '' }} class="w-4 h-4 text-blue-600 focus:ring-blue-500" required>
                        <span class="text-gray-700">Perempuan</span>
                    </label>
                </div>
            </div>

            <div class="mb-5">
                <label class="block text-gray-800 font-semibold mb-2">Status Sosial Anak</label>
                <select name="status_social_anak" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                    <option value="" disabled {{ old('status_social_anak') ? '' : 'selected' }}>Pilih Status...</option>
                    <option value="Yatim" {{ old('status_social_anak') === 'Yatim' ? 'selected' : '' }}>Yatim</option>
                    <option value="Piatu" {{ old('status_social_anak') === 'Piatu' ? 'selected' : '' }}>Piatu</option>
                    <option value="Yatim Piatu" {{ old('status_social_anak') === 'Yatim Piatu' ? 'selected' : '' }}>Yatim Piatu</option>
                    <option value="Dhuafa" {{ old('status_social_anak') === 'Dhuafa' ? 'selected' : '' }}>Dhuafa</option>
                </select>
            </div>

            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 mb-5">
                <div>
                    <label class="block text-gray-800 font-semibold mb-2">Nama Ayah</label>
                    <input type="text" name="nama_ayah" value="{{ old('nama_ayah') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div>
                    <label class="block text-gray-800 font-semibold mb-2">Nama Ibu</label>
                    <input type="text" name="nama_ibu" value="{{ old('nama_ibu') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
            </div>

            <div class="mb-8">
                <label class="block text-gray-800 font-semibold mb-2">Upload Foto</label>
                <input type="file" name="foto" accept="image/*" class="w-full text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-200 file:text-gray-700 hover:file:bg-gray-300 cursor-pointer" required>
            </div>

            <div class="flex justify-between items-center pt-6 border-t border-gray-200 mt-6 pb-2">
                <a href="{{ route('anak-asuh.index') }}" class="bg-gray-200 text-gray-700 border border-gray-300 px-8 py-2 rounded-lg font-medium hover:bg-gray-300 transition">
                    Batal
                </a>
                <button type="submit" class="bg-blue-500 text-white px-8 py-2 rounded-lg font-medium hover:bg-blue-600 transition shadow-sm">
                    Simpan
                </button>
            </div>

        </form>
    </div>
</div>
@endsection