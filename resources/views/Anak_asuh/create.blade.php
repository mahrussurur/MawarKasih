@extends('layouts.app')
@section('page-title', 'Data Anak Asuh')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen flex justify-center items-start">
    
    <div class="w-full max-w-3xl bg-white rounded-xl shadow-md p-8 border border-gray-200 mt-4">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Tambah Data Anak Asuh</h2>

        <form action="{{ route('anak-asuh.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-5">
                <label class="block text-gray-800 font-semibold mb-2">Nama Lengkap</label>
                <input type="text" name="nama" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <div class="flex gap-4 mb-5">
                <div class="w-1/2">
                    <label class="block text-gray-800 font-semibold mb-2">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>
                <div class="w-1/2">
                    <label class="block text-gray-800 font-semibold mb-2">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 text-gray-600" required>
                </div>
            </div>

            <div class="mb-5">
                <label class="block text-gray-800 font-semibold mb-2">Jenis Kelamin</label>
                <div class="w-full border border-gray-300 rounded-lg px-4 py-2.5 flex items-center gap-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="jenis_kelamin" value="L" class="w-4 h-4 text-blue-600 focus:ring-blue-500" required>
                        <span class="text-gray-700">Laki-laki</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="jenis_kelamin" value="P" class="w-4 h-4 text-blue-600 focus:ring-blue-500" required>
                        <span class="text-gray-700">Perempuan</span>
                    </label>
                </div>
            </div>

            <div class="mb-5">
                <label class="block text-gray-800 font-semibold mb-2">Status Sosial Anak</label>
                <select name="status_social_anak" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="" disabled selected>Pilih Status...</option>
                    <option value="Yatim">Yatim</option>
                    <option value="Piatu">Piatu</option>
                    <option value="Yatim Piatu">Yatim Piatu</option>
                    <option value="Dhuafa">Dhuafa</option>
                </select>
            </div>

            <div class="flex gap-4 mb-5">
                <div class="w-1/2">
                    <label class="block text-gray-800 font-semibold mb-2">Nama Ayah</label>
                    <input type="text" name="nama_ayah" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div class="w-1/2">
                    <label class="block text-gray-800 font-semibold mb-2">Nama Ibu</label>
                    <input type="text" name="nama_ibu" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
            </div>

            <div class="mb-8">
                <label class="block text-gray-800 font-semibold mb-2">Upload Foto</label>
                <input type="file" name="foto" class="w-full text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-200 file:text-gray-700 hover:file:bg-gray-300 cursor-pointer">
            </div>

            <div class="flex justify-between items-center pt-6 border-t border-gray-200 mt-6 pb-2">
                <a href="{{ route('anak-asuh.index') }}" class="bg-gray-200 text-gray-700 border border-gray-300 px-8 py-2 rounded-lg font-medium hover:bg-gray-300 transition">
                    Batal
                </a>
                <button type="submit" class="bg-[#4CAF50] text-white px-8 py-2 rounded-lg font-medium hover:bg-green-600 transition shadow-sm">
                    Simpan
                </button>
            </div>

        </form>
    </div>
</div>
@endsection