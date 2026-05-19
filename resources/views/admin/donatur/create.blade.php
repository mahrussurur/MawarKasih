@extends('admin.layouts.app')
@section('page-title', 'Tambah Donatur')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen flex justify-center items-start">
    
    <div class="w-full max-w-3xl bg-white rounded-xl shadow-md p-8 border border-gray-200 mt-4">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Tambah Data Donatur</h2>

        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                <p class="text-red-800 font-semibold mb-2">Terjadi kesalahan:</p>
                <ul class="list-disc list-inside text-red-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('donatur.store') }}" method="POST">
            @csrf

            <div class="mb-5">
                <label class="block text-gray-800 font-semibold mb-2">Nama Lengkap</label>
                <input type="text" name="nama" value="{{ old('nama') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                @error('nama')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block text-gray-800 font-semibold mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block text-gray-800 font-semibold mb-2">No. HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                @error('no_hp')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block text-gray-800 font-semibold mb-2">Alamat</label>
                <textarea name="alamat" rows="4" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400" required>{{ old('alamat') }}</textarea>
                @error('alamat')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-8">
                <label class="block text-gray-800 font-semibold mb-2">Status</label>
                <div class="w-full border border-gray-300 rounded-lg px-4 py-2.5 flex items-center gap-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="status" value="aktif" class="w-4 h-4 text-blue-600 focus:ring-blue-500" {{ old('status', 'aktif') == 'aktif' ? 'checked' : '' }} required>
                        <span class="text-gray-700">Aktif</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="status" value="tidak_aktif" class="w-4 h-4 text-blue-600 focus:ring-blue-500" {{ old('status') == 'tidak_aktif' ? 'checked' : '' }}>
                        <span class="text-gray-700">Tidak Aktif</span>
                    </label>
                </div>
                @error('status')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between items-center pt-6 border-t border-gray-200 mt-6 pb-2">
                <a href="{{ route('donatur.index') }}" class="bg-gray-200 text-gray-700 border border-gray-300 px-8 py-2 rounded-lg font-medium hover:bg-gray-300 transition">
                    Batal
                </a>
                <button type="submit" class="bg-blue-500 text-white px-8 py-2 rounded-lg font-medium hover:bg-blue-600 transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
