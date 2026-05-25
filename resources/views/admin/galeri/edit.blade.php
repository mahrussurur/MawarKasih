@extends('admin.layouts.app')
@section('page-title', 'Edit Galeri')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md border border-gray-100 p-8">

        <div class="mb-8 border-b border-gray-100 pb-4">
            <h2 class="text-2xl font-bold text-gray-800">Edit Foto Galeri</h2>
            <p class="text-gray-500 text-sm mt-1">Ubah informasi foto galeri dan kategori jika diperlukan.</p>
        </div>

        <form action="{{ route('galeri.update', $galeri->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Judul Foto</label>
                <input type="text" name="judul" value="{{ old('judul', $galeri->judul) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Kategori</label>
                <select name="kategori" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="umum" {{ old('kategori', $galeri->kategori) === 'umum' ? 'selected' : '' }}>Umum</option>
                    <option value="fasilitas" {{ old('kategori', $galeri->kategori) === 'fasilitas' ? 'selected' : '' }}>Fasilitas Panti</option>
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Deskripsi Foto</label>
                <textarea name="deskripsi" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>{{ old('deskripsi', $galeri->deskripsi) }}</textarea>
            </div>

            <div class="mb-8">
                <label class="block text-gray-700 font-semibold mb-2">Foto</label>
                @if($galeri->foto)
                    <div class="mb-3">
                        <p class="text-sm text-gray-500 mb-1">Foto saat ini:</p>
                        <img src="{{ asset('storage/' . $galeri->foto) }}" class="w-32 h-32 object-cover rounded-lg border border-gray-200">
                    </div>
                @endif
                <input type="file" name="foto" accept="image/*" class="w-full rounded-md file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-[#1a56db] hover:file:bg-blue-100 cursor-pointer">
                <p class="text-xs text-gray-500 mt-2">Biarkan kosong jika tidak ingin mengubah foto. Format: JPG, PNG, JPEG. Maksimal 2MB.</p>
            </div>

            <div class="flex justify-between items-center pt-6 border-t border-gray-200 mt-6 pb-1">
                <a href="{{ route('galeri.index') }}" class="bg-gray-200 text-gray-700 border border-gray-300 px-8 py-2 rounded-lg font-semibold hover:bg-gray-300 transition">
                    Batal
                </a>
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg font-medium hover:bg-blue-400 transition shadow-sm">
                    Update
                </button>
            </div>
        </form>

    </div>
</div>
@endsection
