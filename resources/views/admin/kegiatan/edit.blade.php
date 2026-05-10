@extends('admin.layouts.app') 
@section('page-title', 'Data Kegiatan')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md border border-gray-100 p-8">
        
        <div class="mb-8 border-b border-gray-100 pb-4">
            <h2 class="text-2xl font-bold text-gray-800">Edit Kegiatan</h2>
            <p class="text-gray-500 text-sm mt-1">Ubah detail kegiatan panti asuhan di bawah ini.</p>
        </div>

        <!-- Form mengarah ke route update, wajib tambahkan @method('PUT') -->
        <form action="{{ route('kegiatan.update', $kegiatan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Input Nama Kegiatan -->
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Nama Kegiatan</label>
                <!-- Tambahkan value dari database -->
                <input type="text" name="nama_kegiatan" value="{{ old('nama_kegiatan', $kegiatan->nama_kegiatan) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#1a56db] focus:border-[#1a56db]" required>
            </div>

            <!-- Input Tanggal -->
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Tanggal Pelaksanaan</label>
                <input type="date" name="tanggal_pelaksanaan" value="{{ old('tanggal_pelaksanaan', $kegiatan->tanggal_pelaksanaan) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#1a56db] focus:border-[#1a56db]" required>
            </div>

            <!-- Input Deskripsi -->
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Deskripsi Kegiatan</label>
                <!-- Teks area tidak pakai atribut value, tapi diletakkan di antara tag penutup -->
                <textarea name="deskripsi" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#1a56db] focus:border-[#1a56db]" required>{{ old('deskripsi', $kegiatan->deskripsi) }}</textarea>
            </div>

            <!-- Input Foto -->
            <div class="mb-8">
                <label class="block text-gray-700 font-semibold mb-2">Foto Dokumentasi</label>
                
                <!-- Menampilkan preview foto lama jika ada -->
                @if($kegiatan->foto_dokumentasi)
                    <div class="mb-3">
                        <p class="text-sm text-gray-500 mb-1">Foto saat ini:</p>
                        <img src="{{ asset('storage/' . $kegiatan->foto_dokumentasi) }}" class="w-32 h-32 object-cover rounded-lg border border-gray-200">
                    </div>
                @endif

                <input type="file" name="foto_dokumentasi" accept="image/*" class="w-full rounded-md file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-[#1a56db] hover:file:bg-blue-100 cursor-pointer">
                <p class="text-xs text-gray-500 mt-2">Biarkan kosong jika tidak ingin mengubah foto. Format: JPG, PNG, JPEG. Maksimal 2MB.</p>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-between items-center pt-6 border-t border-gray-200 mt-6 pb-1">
                <a href="{{ route('kegiatan.index') }}" class="bg-gray-200 text-gray-700 border border-gray-300 px-8 py-2 rounded-lg font-semibold hover:bg-gray-300 transition">
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