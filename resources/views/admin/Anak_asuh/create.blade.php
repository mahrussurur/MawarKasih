@extends('layouts.app')
@section('page-title', 'Data Anak Asuh')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Main Content Card -->
    <div class="overflow-hidden rounded-2xl bg-white shadow-sm border border-gray-200">
        
        <!-- Header / Banner Cover -->
        <div class="relative bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-6 sm:px-8 sm:py-7">
            <div class="flex flex-row items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-white sm:text-2xl">Tambah Data Anak Asuh</h2>
                    <p class="text-sm text-blue-100 mt-0.5">Formulir Penambahan Data Anak Asuh.</p>
                </div>
                <!-- Tombol Kembali -->
                <a href="{{ route('anak-asuh.index') }}" 
                   class="inline-flex items-center gap-2 rounded-xl bg-white/20 backdrop-blur-sm border border-white/30 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-white/30 transition flex-shrink-0" 
                   title="Kembali">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span class="hidden sm:inline">Kembali</span>
                </a>
            </div>
        </div>

        <form action="{{ route('anak-asuh.store') }}" method="POST" enctype="multipart/form-data" class="p-4 md:p-6">
            @csrf
            <!-- Nama Lengkap -->
            <div class="mb-5">
                <label class="mb-1.5 block text-sm font-semibold text-gray-800">Nama Lengkap<span class="text-red-500">*</span></label>
                <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Nama Lengkap..." class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <!-- Nama Panggilan -->
            <div class="mb-5">
                <label class="mb-1.5 block text-sm font-semibold text-gray-800">Nama Panggilan<span class="text-red-500">*</span></label>
                <input type="text" name="nama_panggilan" value="{{ old('nama_panggilan') }}" placeholder="Nama Panggilan..." class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <!-- Tempat Lahir dan Tanggal Lahir -->
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 mb-5">
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-800">Tempat Lahir<span class="text-red-500">*</span></label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" placeholder="Tempat Lahir..." class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-800">Tanggal Lahir<span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
            </div>
            <!-- Tinggal di LKSA sejak -->
            <div class="mb-5">
                <label class="mb-1.5 block text-sm font-semibold text-gray-800">Tinggal di LKSA sejak<span class="text-red-500">*</span></label>
                <input type="text" name="tinggal_di_lksa_sejak" value="{{ old('tinggal_di_lksa_sejak') }}" placeholder="Cth: Dari kandungan ibu tahun 2023 atau Tahun 2024" class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                <p class="text-xs text-gray-500 mt-1">Isikan apakah sejak dalam kandungan atau tahun masuk LKSA.</p>
            </div>
            <!-- Sekolah dan Kelas -->
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 mb-5">
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-800">Sekolah<span class="text-red-500">*</span></label>
                    <input type="text" name="sekolah" value="{{ old('sekolah') }}" placeholder="Nama Sekolah..." class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-800">Kelas<span class="text-red-500">*</span></label>
                    <input type="text" name="kelas" value="{{ old('kelas') }}" placeholder="Kelas..." class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 mb-5">
                <!-- Jenis Kelamin -->
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-800">Jenis Kelamin<span class="text-red-500">*</span></label>
                    <select name="jenis_kelamin" id="jenis_kelamin"
                        class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none"
                        required
                        onchange="this.classList.remove('text-gray-400','text-sm'); this.classList.add('text-gray-900')">
                        <option value="" disabled selected>Pilih Jenis Kelamin...</option>
                        <option class="text-gray-900" value="L">Laki-laki</option>
                        <option class="text-gray-900" value="P">Perempuan</option>
                    </select>
                </div>
                <!-- Status Sosial Anak -->
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-800">Status Sosial Anak<span class="text-red-500">*</span></label>
                    <select name="status_social_anak" id="status-social-anak" 
                        class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none" 
                        required
                        onchange="this.classList.remove('text-gray-400','text-sm'); this.classList.add('text-gray-900')">
                            
                        <option value="" disabled selected>Pilih Status...</option>
                        <option class="text-gray-900" value="Yatim">Yatim</option>
                        <option class="text-gray-900" value="Piatu">Piatu</option>
                        <option class="text-gray-900" value="Yatim Piatu">Yatim Piatu</option>
                        <option class="text-gray-900" value="Dhuafa">Dhuafa</option>
                    </select>
                </div>
            </div>
            <!-- Nama Ayah dan Nama Ibu -->
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 mb-5">
                <div id="field-nama-ayah">
                    <label class="mb-1.5 block text-sm font-semibold text-gray-800">Nama Ayah<span class="text-red-500">*</span></label>
                    <input type="text" name="nama_ayah" value="{{ old('nama_ayah') }}"
                        placeholder="Nama Ayah..."
                        class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div id="field-nama-ibu">
                    <label class="mb-1.5 block text-sm font-semibold text-gray-800">Nama Ibu<span class="text-red-500">*</span></label>
                    <input type="text" name="nama_ibu" value="{{ old('nama_ibu') }}"
                        placeholder="Nama Ibu..."
                        class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            <!-- Foto Anak -->
            <div class="mb-5">
                <label class="mb-1.5 block text-sm font-semibold text-gray-800">Foto Anak</label>
                <input type="file" id="foto_input" name="foto" accept="image/*" class="w-full text-sm text-gray-600 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100 cursor-pointer border border-gray-200 rounded-xl bg-gray-50">
                <div id="preview_container" class="mt-3 hidden">
                    <img id="foto_preview" src="#" alt="Preview Foto" class="max-h-48 w-auto rounded-lg object-cover border border-gray-200 shadow-sm">
                    <button type="button" id="remove_preview" class="mt-2 text-sm text-red-600 hover:text-red-700 font-medium focus:outline-none">Hapus Foto</button>
                </div>
                <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG, JPEG. Maksimal 2MB.</p>
            </div>
            <!-- Tombol Aksi -->
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
    const inputAyah = fieldAyah?.querySelector('input');
    const inputIbu = fieldIbu?.querySelector('input');

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
            inputAyah?.setAttribute('disabled', 'disabled');
            inputAyah && (inputAyah.value = ''); // Clear value
        } 
        else if (status === 'Piatu') {
            fieldIbu.style.display = 'none';
            inputIbu?.setAttribute('disabled', 'disabled');
            inputIbu && (inputIbu.value = '');
        } 
        else if (status === 'Yatim Piatu') {
            fieldAyah.style.display = 'none';
            fieldIbu.style.display = 'none';
            inputAyah?.setAttribute('disabled', 'disabled');
            inputIbu?.setAttribute('disabled', 'disabled');
            inputAyah && (inputAyah.value = '');
            inputIbu && (inputIbu.value = '');
        }
        // 'Dhuafa' atau default: tampilkan semua
    }

    // Jalankan saat halaman load (untuk edit form / old value)
    toggleParentFields();
    
    // Jalankan saat user ganti pilihan
    statusSelect.addEventListener('change', toggleParentFields);

    // Aktifkan preview foto
    setupImagePreview('foto_input', 'preview_container', 'foto_preview', 'remove_preview');
});
</script>
@endpush
