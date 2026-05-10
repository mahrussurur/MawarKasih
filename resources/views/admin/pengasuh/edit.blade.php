@extends('admin.layouts.app')
@section('page-title', 'Data Pengasuh')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen flex justify-center items-start">
    
    <div class="w-full max-w-3xl bg-white rounded-xl shadow-md p-8 border border-gray-200 mt-4">
        <div class="mb-8 border-b border-gray-100 pb-4">
            <h2 class="text-2xl font-bold text-gray-800">Edit Pengasuh</h2>
            <p class="text-gray-500 text-sm mt-1">Ubah detail data pengasuh di bawah ini.</p>
        </div>

        <form action="{{ route('pengasuh.update', $pengasuh->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

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

            <!-- Input Foto -->
            <div class="mb-8">
                <label class="block text-gray-700 font-semibold mb-2">Foto Dokumentasi</label>
                
                <!-- Menampilkan preview foto lama jika ada -->
                @if($pengasuh->foto)
                    <div class="mb-3">
                        <p class="text-sm text-gray-500 mb-1">Foto saat ini:</p>
                        <img src="{{ asset('storage/' . $pengasuh->foto) }}" class="w-32 h-32 object-cover rounded-lg border border-gray-200">
                    </div>
                @endif

                <input type="file" name="foto_dokumentasi" accept="image/*" class="w-full rounded-md file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-[#1a56db] hover:file:bg-blue-100 cursor-pointer">
                <p class="text-xs text-gray-500 mt-2">Biarkan kosong jika tidak ingin mengubah foto. Format: JPG, PNG, JPEG. Maksimal 2MB.</p>
            </div>

            <div class="flex justify-between items-center pt-6 border-t border-gray-200 mt-6 pb-2">
                <a href="{{ route('pengasuh.index') }}" class="bg-gray-200 text-gray-700 border border-gray-300 px-8 py-2 rounded-lg font-medium hover:bg-gray-300 transition">
                    Batal
                </a>
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg font-medium hover:bg-blue-600 transition shadow-sm">
                    Update
                </button>
            </div>

        </form>
    </div>
</div>
@endsection