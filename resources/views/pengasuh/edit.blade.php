@extends('layouts.app')
@section('page-title', 'Data Pengasuh')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen flex justify-center items-start">
    
    <div class="w-full max-w-3xl bg-white rounded-xl shadow-md p-8 border border-gray-200 mt-4">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Data Pengasuh</h2>

        <form action="{{ route('pengasuh.update', $pengasuh->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <label class="block text-gray-800 font-semibold mb-2">Nama Lengkap</label>
                <input type="text" name="nama" value="{{ $pengasuh->nama }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <div class="mb-5">
                <label class="block text-gray-800 font-semibold mb-2">Jabatan</label>
                <input type="text" name="jabatan" value="{{ $pengasuh->jabatan }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <div class="mb-5">
                <label class="block text-gray-800 font-semibold mb-2">Jenis Kelamin</label>
                <div class="w-full border border-gray-300 rounded-lg px-4 py-2.5 flex items-center gap-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="jenis_kelamin" value="L" class="w-4 h-4 text-blue-600 focus:ring-blue-500" {{ $pengasuh->jenis_kelamin == 'L' ? 'checked' : '' }} required>
                        <span class="text-gray-700">Laki-laki</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="jenis_kelamin" value="P" class="w-4 h-4 text-blue-600 focus:ring-blue-500" {{ $pengasuh->jenis_kelamin == 'P' ? 'checked' : '' }} required>
                        <span class="text-gray-700">Perempuan</span>
                    </label>
                </div>
            </div>

            <div class="mb-5">
                <label class="block text-gray-800 font-semibold mb-2">No. HP</label>
                <input type="text" name="no_hp" value="{{ $pengasuh->no_hp }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <div class="mb-8">
                <label class="block text-gray-800 font-semibold mb-2">Upload Foto</label>
                @if($pengasuh->foto)
                <div class="mb-3">
                    <img src="{{ asset('storage/'.$pengasuh->foto) }}" class="w-24 h-24 rounded object-cover">
                    <p class="text-sm text-gray-500 mt-1">Foto saat ini</p>
                </div>
                @endif
                <input type="file" name="foto" class="w-full text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-200 file:text-gray-700 hover:file:bg-gray-300 cursor-pointer">
                <p class="text-sm text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah foto</p>
            </div>

            <div class="flex justify-between items-center pt-6 border-t border-gray-200 mt-6 pb-2">
                <a href="{{ route('pengasuh.index') }}" class="bg-gray-200 text-gray-700 border border-gray-300 px-8 py-2 rounded-lg font-medium hover:bg-gray-300 transition">
                    Batal
                </a>
                <button type="submit" class="bg-blue-500 text-white px-8 py-2 rounded-lg font-medium hover:bg-blue-600 transition shadow-sm">
                    Update
                </button>
            </div>

        </form>
    </div>
</div>
@endsection