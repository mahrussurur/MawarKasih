@extends('admin.layouts.app')
@section('page-title', 'Data Anak Asuh')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md border border-gray-100 p-8">
        <div class="mb-8 border-b border-gray-100 pb-4">
            <h2 class="text-2xl font-bold text-gray-800">Edit Anak Asuh</h2>
            <p class="text-gray-500 text-sm mt-1">Ubah detail data anak asuh di bawah ini.</p>
        </div>
        
        <form action="{{ route('anak-asuh.update', $anakAsuh->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="mb-5">
                <label class="block text-gray-800 font-semibold mb-2">Nama Lengkap</label>
                <input type="text" name="nama" value="{{ old('nama', $anakAsuh->nama) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <div class="mb-5">
                <label class="block text-gray-800 font-semibold mb-2">Nama Panggilan</label>
                <input type="text" name="nama_panggilan" value="{{ old('nama_panggilan', $anakAsuh->nama_panggilan) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 mb-5">
                <div>
                    <label class="block text-gray-800 font-semibold mb-2">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $anakAsuh->tempat_lahir) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>
                <div>
                    <label class="block text-gray-800 font-semibold mb-2">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $anakAsuh->tanggal_lahir) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 text-gray-600" required>
                </div>
            </div>

            <div class="mb-5">
                <label class="block text-gray-800 font-semibold mb-2">Tinggal di LKSA sejak</label>
                <input type="text" name="tinggal_di_lksa_sejak" value="{{ old('tinggal_di_lksa_sejak', $anakAsuh->tinggal_di_lksa_sejak) }}" placeholder="Contoh: Dari kandungan ibu tahun 2023 atau Tahun 2024" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                <p class="text-xs text-gray-500 mt-1">Isikan apakah sejak dalam kandungan atau tahun masuk LKSA.</p>
            </div>

            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 mb-5">
                <div>
                    <label class="block text-gray-800 font-semibold mb-2">Sekolah</label>
                    <input type="text" name="sekolah" value="{{ old('sekolah', $anakAsuh->sekolah) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>
                <div>
                    <label class="block text-gray-800 font-semibold mb-2">Kelas</label>
                    <input type="text" name="kelas" value="{{ old('kelas', $anakAsuh->kelas) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>
            </div>

            <div class="mb-5">
                <label class="block text-gray-800 font-semibold mb-2">Jenis Kelamin</label>
                <div class="w-full border border-gray-300 rounded-lg px-4 py-2.5 flex items-center gap-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="jenis_kelamin" value="L" {{ old('jenis_kelamin', $anakAsuh->jenis_kelamin) === 'L' ? 'checked' : '' }} class="w-4 h-4 text-blue-600 focus:ring-blue-500" required>
                        <span class="text-gray-700">Laki-laki</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="jenis_kelamin" value="P" {{ old('jenis_kelamin', $anakAsuh->jenis_kelamin) === 'P' ? 'checked' : '' }} class="w-4 h-4 text-blue-600 focus:ring-blue-500" required>
                        <span class="text-gray-700">Perempuan</span>
                    </label>
                </div>
            </div>

            <div class="mb-5">
                <label class="block text-gray-800 font-semibold mb-2">Status Sosial Anak</label>
                <select name="status_social_anak" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="" disabled {{ old('status_social_anak', $anakAsuh->status_social_anak) ? '' : 'selected' }}>Pilih Status...</option>
                    <option value="Yatim" {{ old('status_social_anak', $anakAsuh->status_social_anak) === 'Yatim' ? 'selected' : '' }}>Yatim</option>
                    <option value="Piatu" {{ old('status_social_anak', $anakAsuh->status_social_anak) === 'Piatu' ? 'selected' : '' }}>Piatu</option>
                    <option value="Yatim Piatu" {{ old('status_social_anak', $anakAsuh->status_social_anak) === 'Yatim Piatu' ? 'selected' : '' }}>Yatim Piatu</option>
                    <option value="Dhuafa" {{ old('status_social_anak', $anakAsuh->status_social_anak) === 'Dhuafa' ? 'selected' : '' }}>Dhuafa</option>
                </select>
            </div>

            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 mb-5">
                <div>
                    <label class="block text-gray-800 font-semibold mb-2">Nama Ayah</label>
                    <input type="text" name="nama_ayah" value="{{ old('nama_ayah', $anakAsuh->nama_ayah) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div>
                    <label class="block text-gray-800 font-semibold mb-2">Nama Ibu</label>
                    <input type="text" name="nama_ibu" value="{{ old('nama_ibu', $anakAsuh->nama_ibu) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
            </div>

            <div class="mb-8">
                <label class="block text-gray-700 font-semibold mb-2">Foto Dokumentasi</label>
                
                @if($anakAsuh->foto)
                    <div class="mb-3">
                        <p class="text-sm text-gray-500 mb-1">Foto saat ini:</p>
                        <img src="{{ asset('storage/' . $anakAsuh->foto) }}" class="w-32 h-32 object-cover rounded-lg border border-gray-200">
                    </div>
                @endif

                <input type="file" name="foto" accept="image/*" class="w-full rounded-md file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-[#1a56db] hover:file:bg-blue-100 cursor-pointer">
                <p class="text-xs text-gray-500 mt-2">Biarkan kosong jika tidak ingin mengubah foto. Format: JPG, PNG, JPEG. Maksimal 2MB.</p>
            </div>

            <div class="flex justify-between items-center pt-6 border-t border-gray-200 mt-6 pb-1">
                <a href="{{ route('anak-asuh.index') }}" class="bg-gray-200 text-gray-700 border border-gray-300 px-8 py-2 rounded-lg font-semibold hover:bg-gray-300 transition">
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
