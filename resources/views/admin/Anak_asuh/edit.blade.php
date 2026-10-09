@extends('layouts.app')
@section('page-title', 'Data Anak Asuh')

@section('content')
<div class="max-w-3xl mx-auto overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">      
    <!-- Header -->
    <div class="border-b border-gray-200 bg-gradient-to-r from-amber-500 to-amber-600 px-6 py-4 flex justify-between items-center gap-4">
        <div class="min-w-0">
            <h2 class="text-lg font-bold text-white truncate">Edit Data Anak Asuh</h2>
            <p class="text-xs text-gray-300">Ubah detail data anak asuh di bawah ini.</p>
        </div>
        <a href="{{ route('anak-asuh.index') }}" class="text-xs font-semibold text-white hover:text-gray-400 flex items-center transition-colors whitespace-nowrap">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span class="hidden sm:inline">Kembali</span>
        </a>
    </div>
    
    <div class="p-4 md:p-6">   
        <form action="{{ route('anak-asuh.update', $anakAsuh->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="mb-5">
                <label class="text-sm font-bold text-gray-800 block mb-2">Nama Lengkap<span class="text-red-500">*</span></label>
                <input type="text" name="nama" value="{{ old('nama', $anakAsuh->nama) }}" placeholder="Nama Lengkap..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm placeholder:text-gray-400" required>
            </div>
            <div class="mb-5">
                <label class="text-sm font-bold text-gray-800 block mb-2">Nama Panggilan<span class="text-red-500">*</span></label>
                <input type="text" name="nama_panggilan" value="{{ old('nama_panggilan', $anakAsuh->nama_panggilan) }}" placeholder="Nama Panggilan..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm placeholder:text-gray-400" required>
            </div>
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 mb-5">
                <div>
                    <label class="text-sm font-bold text-gray-800 block mb-2">Tempat Lahir<span class="text-red-500">*</span></label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $anakAsuh->tempat_lahir) }}" placeholder="Tempat Lahir..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm placeholder:text-gray-400" required>
                </div>
                <div>
                    <label class="text-sm font-bold text-gray-800 block mb-2">Tanggal Lahir<span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $anakAsuh->tanggal_lahir) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm text-gray-500" required>
                </div>
            </div>
            <div class="mb-5">
                <label class="text-sm font-bold text-gray-800 block mb-2">Tinggal di LKSA sejak<span class="text-red-500">*</span></label>
                <input type="text" name="tinggal_di_lksa_sejak" value="{{ old('tinggal_di_lksa_sejak', $anakAsuh->tinggal_di_lksa_sejak) }}" placeholder="Cth: Dari kandungan ibu tahun 2023 atau Tahun 2024" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm placeholder:text-gray-400" required>
                <p class="text-xs text-gray-500 mt-1">Isikan apakah sejak dalam kandungan atau tahun masuk LKSA.</p>
            </div>
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 mb-5">
                <div>
                    <label class="text-sm font-bold text-gray-800 block mb-2">Sekolah<span class="text-red-500">*</span></label>
                    <input type="text" name="sekolah" value="{{ old('sekolah', $anakAsuh->sekolah) }}" placeholder="Nama Sekolah..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm placeholder:text-gray-400" required>
                </div>
                <div>
                    <label class="text-sm font-bold text-gray-800 block mb-2">Kelas<span class="text-red-500">*</span></label>
                    <input type="text" name="kelas" value="{{ old('kelas', $anakAsuh->kelas) }}" placeholder="Kelas..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm placeholder:text-gray-400" required>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 mb-5">
                <div>
                    <label class="text-sm font-bold text-gray-800 block mb-2">Jenis Kelamin<span class="text-red-500">*</span></label>
                    <select name="jenis_kelamin" id="jenis_kelamin"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm text-gray-900 appearance-none"
                        required>
                        <option value="" disabled>Pilih Jenis Kelamin...</option>
                        <option value="L" {{ old('jenis_kelamin', $anakAsuh->jenis_kelamin) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $anakAsuh->jenis_kelamin) === 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="text-sm font-bold text-gray-800 block mb-2">Status Sosial Anak<span class="text-red-500">*</span></label>
                    <select name="status_social_anak" id="status-social-anak" 
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm text-gray-900 appearance-none" 
                        required>
                        <option value="" disabled {{ old('status_social_anak', $anakAsuh->status_social_anak) ? '' : 'selected' }}>Pilih Status...</option>
                        <option value="Yatim" {{ old('status_social_anak', $anakAsuh->status_social_anak) === 'Yatim' ? 'selected' : '' }}>Yatim</option>
                        <option value="Piatu" {{ old('status_social_anak', $anakAsuh->status_social_anak) === 'Piatu' ? 'selected' : '' }}>Piatu</option>
                        <option value="Yatim Piatu" {{ old('status_social_anak', $anakAsuh->status_social_anak) === 'Yatim Piatu' ? 'selected' : '' }}>Yatim Piatu</option>
                        <option value="Dhuafa" {{ old('status_social_anak', $anakAsuh->status_social_anak) === 'Dhuafa' ? 'selected' : '' }}>Dhuafa</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 mb-5">
                <div id="field-nama-ayah">
                    <label class="text-sm font-bold text-gray-800 block mb-2">Nama Ayah<span class="text-red-500">*</span></label>
                    <input type="text" name="nama_ayah" value="{{ old('nama_ayah', $anakAsuh->nama_ayah) }}" placeholder="Nama Ayah..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm placeholder:text-gray-400">
                </div>
                <div id="field-nama-ibu">
                    <label class="text-sm font-bold text-gray-800 block mb-2">Nama Ibu<span class="text-red-500">*</span></label>
                    <input type="text" name="nama_ibu" value="{{ old('nama_ibu', $anakAsuh->nama_ibu) }}" placeholder="Nama Ibu..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm placeholder:text-gray-400">
                </div>
            </div>
            <div class="mb-5">
                <label class="text-sm font-bold text-gray-800 block mb-2">Foto Anak</label>
            
                @if($anakAsuh->foto)
                    <div class="mb-3">
                        <p class="text-sm text-gray-500 mb-1">Foto saat ini:</p>
                        <img src="{{ asset('storage/' . $anakAsuh->foto) }}" class="w-32 h-32 object-cover rounded-lg border border-gray-200">
                    </div>
                @endif
                <input type="file" id="foto_input" name="foto" accept="image/*" class="w-full text-sm text-gray-600 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100 cursor-pointer border border-gray-200 rounded-xl bg-gray-50">
                <div id="preview_container" class="mt-3 hidden">
                    <img id="foto_preview" src="#" alt="Preview Foto" class="max-h-48 w-auto rounded-lg object-cover border border-gray-200 shadow-sm">
                    <button type="button" id="remove_preview" class="mt-2 text-sm text-red-600 hover:text-red-700 font-medium focus:outline-none">Hapus Foto</button>
                </div>
                <p class="text-xs text-gray-500 mt-2">Biarkan kosong jika tidak ingin mengubah foto. Format: JPG, PNG, JPEG. Maksimal 2MB.</p>
            </div>
            <div class="flex justify-center items-center gap-4 pt-6 border-t border-gray-200 mt-6 pb-2">
                <a href="{{ route('anak-asuh.index') }}" class="rounded-xl bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 border border-gray-300 transition hover:bg-gray-300">
                    Batal
                </a>
                <button type="submit" class="rounded-xl bg-green-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-green-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('status-social-anak');
    const fieldAyah = document.getElementById('field-nama-ayah');
    const fieldIbu = document.getElementById('field-nama-ibu');
    
    // Safety check: pastikan elemen ada sebelum diakses
    if (!statusSelect || !fieldAyah || !fieldIbu) return;
    
    const inputAyah = fieldAyah.querySelector('input');
    const inputIbu = fieldIbu.querySelector('input');

    function toggleParentFields() {
        const status = statusSelect.value;
        
        // Reset: tampilkan semua field & aktifkan input
        fieldAyah.style.display = 'block';
        fieldIbu.style.display = 'block';
        inputAyah?.removeAttribute('disabled');
        inputIbu?.removeAttribute('disabled');
        
        // Logika sesuai status
        if (status === 'Yatim') {
            fieldAyah.style.display = 'none';
            if (inputAyah) {
                inputAyah.setAttribute('disabled', 'disabled');
                inputAyah.value = '';
            }
        } 
        else if (status === 'Piatu') {
            fieldIbu.style.display = 'none';
            if (inputIbu) {
                inputIbu.setAttribute('disabled', 'disabled');
                inputIbu.value = '';
            }
        } 
        else if (status === 'Yatim Piatu') {
            fieldAyah.style.display = 'none';
            fieldIbu.style.display = 'none';
            if (inputAyah) {
                inputAyah.setAttribute('disabled', 'disabled');
                inputAyah.value = '';
            }
            if (inputIbu) {
                inputIbu.setAttribute('disabled', 'disabled');
                inputIbu.value = '';
            }
        }
    }

    toggleParentFields();
    statusSelect.addEventListener('change', toggleParentFields);

    // Aktifkan preview foto
    if (typeof setupImagePreview === 'function') {
        setupImagePreview('foto_input', 'preview_container', 'foto_preview', 'remove_preview');
    }

});
</script>
@endpush
