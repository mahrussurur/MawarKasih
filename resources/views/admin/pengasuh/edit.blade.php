@extends('admin.layouts.app')
@section('page-title', 'Data Pengasuh')

@section('content')
<div class="p-4 md:p-6 bg-slate-100 h-full">
    
    <div class="max-w-3xl mx-auto overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        
        <!-- Header -->
        <div class="p-2 md:p-4 border-b border-gray-200 flex justify-between items-center gap-4 bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex justify-between items-center">
            <div class="min-w-0">
                <h2 class="text-lg font-bold text-white truncate">Edit Data Pengasuh</h2>
                <p class="text-xs md:text-sm text-gray-300">Ubah detail data pengasuh di bawah ini.</p>
            </div>
            <a href="{{ route('pengasuh.index') }}" class="text-xs md:text-sm font-semibold text-white hover:text-gray-400 flex items-center transition-colors whitespace-nowrap">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="hidden sm:inline">Kembali</span>
            </a>
        </div>

        <div class="p-4 md:p-6">
            <form action="{{ route('pengasuh.update', $pengasuh->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="mb-5">
                    <label class="block text-gray-800 font-semibold mb-2">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama', $pengasuh->nama) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                    <div>
                        <label class="block text-gray-800 font-semibold mb-2">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $pengasuh->tempat_lahir) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                    </div>
                    <div>
                        <label class="block text-gray-800 font-semibold mb-2">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $pengasuh->tanggal_lahir) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                    </div>
                </div>

                <div class="mb-5">
                    <label class="block text-gray-800 font-semibold mb-2">Alamat</label>
                    <textarea name="alamat" rows="2" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400" required>{{ old('alamat', $pengasuh->alamat) }}</textarea>
                </div>

                <div class="mb-5">
                    <label class="block text-gray-800 font-semibold mb-2">Jabatan</label>
                    <select name="jabatan" id="jabatan" 
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                        <option value="" disabled {{ old('jabatan', $pengasuh->jabatan) ? '' : 'selected' }}>Pilih Jabatan...</option>
                        <option value="Pembina" {{ old('jabatan', $pengasuh->jabatan) === 'Pembina' ? 'selected' : '' }}>Pembina</option>
                        <option value="Ketua" {{ old('jabatan', $pengasuh->jabatan) === 'Ketua' ? 'selected' : '' }}>Ketua</option>
                        <option value="Wakil Ketua" {{ old('jabatan', $pengasuh->jabatan) === 'Wakil Ketua' ? 'selected' : '' }}>Wakil Ketua</option>
                        <option value="Sekretaris" {{ old('jabatan', $pengasuh->jabatan) === 'Sekretaris' ? 'selected' : '' }}>Sekretaris</option>
                        <option value="Bendahara" {{ old('jabatan', $pengasuh->jabatan) === 'Bendahara' ? 'selected' : '' }}>Bendahara</option>
                        <option value="Sarana dan Prasarana" {{ old('jabatan', $pengasuh->jabatan) === 'Sarana dan Prasarana' ? 'selected' : '' }}>Sarana dan Prasarana</option>
                        <option value="Pemberdayaan" {{ old('jabatan', $pengasuh->jabatan) === 'Pemberdayaan' ? 'selected' : '' }}>Pemberdayaan</option>
                        <option value="Seksi Pendanaan" {{ old('jabatan', $pengasuh->jabatan) === 'Seksi Pendanaan' ? 'selected' : '' }}>Seksi Pendanaan</option>
                        <option value="Pendamping" {{ old('jabatan', $pengasuh->jabatan) === 'Pendamping' ? 'selected' : '' }}>Pendamping</option>
                    </select>
                </div>

                <div class="mb-5">
                    <label class="block text-gray-800 font-semibold mb-2">Jenis Kelamin</label>
                    <div class="flex gap-6 items-center">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="jenis_kelamin" value="L" {{ old('jenis_kelamin', $pengasuh->jenis_kelamin) === 'L' ? 'checked' : '' }} class="w-4 h-4 text-blue-600 focus:ring-blue-500" required>
                            <span class="text-gray-700 font-medium">Laki-laki</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="jenis_kelamin" value="P" {{ old('jenis_kelamin', $pengasuh->jenis_kelamin) === 'P' ? 'checked' : '' }} class="w-4 h-4 text-blue-600 focus:ring-blue-500" required>
                            <span class="text-gray-700 font-medium">Perempuan</span>
                        </label>
                    </div>
                </div>

                <div class="mb-5">
                    <label class="block text-gray-800 font-semibold mb-2">No. HP</label>
                    <input type="number" name="no_hp" value="{{ old('no_hp', $pengasuh->no_hp) }}" placeholder="Masukkan No. HP..." class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 placeholder:text-sm placeholder:text-gray-400" required>
                </div>

                <!-- Input Foto -->
                <div class="mb-8">
                    <label class="block text-gray-700 font-semibold mb-2">Foto Pengasuh</label>
                
                    <!-- Menampilkan preview foto lama jika ada -->
                    @if($pengasuh->foto)
                        <div class="mb-3">
                            <p class="text-sm text-gray-500 mb-1">Foto saat ini:</p>
                            <img src="{{ asset('storage/' . $pengasuh->foto) }}" class="w-32 h-32 object-cover rounded-lg border border-gray-200">
                        </div>
                    @endif

                    <input type="file" name="foto_dokumentasi" accept="image/*" class="w-full rounded-2xl file:mr-4 file:py-2 file:px-4 file:rounded-2xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-[#1a56db] hover:file:bg-blue-100 cursor-pointer">
                    <p class="text-xs text-gray-500 mt-2">Biarkan kosong jika tidak ingin mengubah foto. Format: JPG, PNG, JPEG. Maksimal 2MB.</p>
                </div>

                <div class="flex justify-center items-center gap-4 pt-6 border-t border-gray-200 mt-6 pb-2">
                    <a href="{{ route('pengasuh.index') }}" class="rounded-2xl bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 border border-gray-300  transition hover:bg-gray-300">
                        Batal
                    </a>
                    <button type="submit" class="rounded-2xl bg-blue-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-600">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
