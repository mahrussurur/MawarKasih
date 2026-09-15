@extends('layouts.app')
@section('page-title', 'Edit Galeri')

@section('content')
<div class="max-w-3xl mx-auto overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

        <!-- Header -->
        <div class="border-b border-gray-200 bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex justify-between items-center gap-4">
            <div class="min-w-0">
                <h2 class="text-lg font-bold text-white truncate">Edit Data Galeri</h2>
                <p class="text-xs md:text-sm text-gray-300">Ubah detail data galeri di bawah ini dan kategori jika diperlukan.</p>
            </div>
            <a href="{{ route('sekretaris.galeri.index') }}" class="text-xs md:text-sm font-semibold text-white hover:text-gray-400 flex items-center transition-colors whitespace-nowrap">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="hidden sm:inline">Kembali</span>
            </a>
        </div>

        <div class="p-4 md:p-6">
            <form action="{{ route('sekretaris.galeri.update', $galeri->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="mb-5">
                    <label class="text-sm font-bold text-gray-800 block mb-2">Judul Foto</label>
                    <input type="text" name="judul" value="{{ old('judul', $galeri->judul) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 placeholder:text-sm placeholder:text-gray-400" required>
                </div>

                <div class="mb-5">
                    <label class="text-sm font-bold text-gray-800 block mb-2">Kategori</label>
                    <select name="kategori" id="kategori"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm placeholder:text-gray-400" required>
                        <option value="" disabled {{old('kategori', $galeri->kategori) === '' ? 'selected' : ''}}>Pilih Kategori</option>
                        <option value="Umum" {{old('kategori', $galeri->kategori) === 'Umum' ? 'selected' : ''}}>Umum</option>
                        <option value="Fasilitas Panti" {{old('kategori', $galeri->kategori) === 'Fasilitas Panti' ? 'selected' : ''}}>Fasilitas Panti</option>
                    </select>
                </div>

                <div class="mb-5">
                    <label class="text-sm font-bold text-gray-800 block mb-2">Deskripsi Foto</label>
                    <textarea name="deskripsi" rows="2" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm placeholder:text-gray-400" required>{{ old('deskripsi', $galeri->deskripsi) }}</textarea>
                </div>

                <!-- Input Foto -->
                <div class="mb-8">
                    <label class="text-sm font-bold text-gray-800 block mb-2">Foto Dokumentasi</label>
                    
                    <!-- Menampilkan preview foto lama jika ada -->
                    @if($galeri->foto)
                        <div class="mb-3">
                            <p class="text-sm text-gray-500 mb-1">Foto saat ini:</p>
                            <img src="{{ asset('storage/' . $galeri->foto) }}" class="w-32 h-32 object-cover rounded-lg border border-gray-200">
                        </div>
                    @endif

                    <input type="file" name="foto" accept="image/*" class="w-full text-sm text-gray-600 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100 cursor-pointer border border-gray-200 rounded-xl bg-gray-50">
                    <p class="text-xs text-gray-500 mt-2">Biarkan kosong jika tidak ingin mengubah foto. Format: JPG, PNG, JPEG. Maksimal 2MB.</p>
                </div>

                <div class="flex justify-center items-center gap-4 pt-6 border-t border-gray-200 mt-6 pb-2">
                    <a href="{{ route('sekretaris.galeri.index') }}" class="rounded-xl bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 border border-gray-300 transition hover:bg-gray-300">
                        Batal
                    </a>
                    <button type="submit" class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700">
                        Update
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection
