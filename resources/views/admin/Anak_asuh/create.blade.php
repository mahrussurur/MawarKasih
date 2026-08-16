@extends('admin.layouts.app')
@section('page-title', 'Data Anak Asuh')

@section('content')
<div class="p-4 md:p-6 bg-slate-100 h-full">
    
    <div class="max-w-3xl mx-auto overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <!-- Header -->
        <div class="p-2 md:p-4 border-b border-gray-200 flex justify-between items-center gap-4 bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex justify-between items-center">
            <div class="min-w-0">
                <h2 class="text-lg font-bold text-white truncate">Tambah Data Anak Asuh</h2>
                <p class="text-xs md:text-sm text-gray-300">Formulir Penambahan Data Anak Asuh.</p>
            </div>
            <a href="{{ route('anak-asuh.index') }}" class="text-xs md:text-sm font-semibold text-white hover:text-gray-400 flex items-center transition-colors whitespace-nowrap">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="hidden sm:inline">Kembali</span>
            </a>
        </div>

        <div class="p-4 md:p-6">
            <form action="{{ route('anak-asuh.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Nama Lengkap -->
                <div class="mb-5">
                    <label class="block text-gray-800 font-semibold mb-2">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Masukkan Nama Lengkap..." class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 placeholder:text-sm placeholder:text-gray-400" required>
                </div>

                <!-- Nama Panggilan -->
                <div class="mb-5">
                    <label class="block text-gray-800 font-semibold mb-2">Nama Panggilan</label>
                    <input type="text" name="nama_panggilan" value="{{ old('nama_panggilan') }}" placeholder="Masukkan Nama Panggilan..." class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 placeholder:text-sm placeholder:text-gray-400" required>
                </div>

                <!-- Tempat Lahir dan Tanggal Lahir -->
                <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 mb-5">
                    <div>
                        <label class="block text-gray-800 font-semibold mb-2">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" placeholder="Masukkan Tempat Lahir..." class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 placeholder:text-sm placeholder:text-gray-400" required>
                    </div>
                    <div>
                        <label class="block text-gray-800 font-semibold mb-2">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 text-gray-400 text-sm" required>
                    </div>
                </div>

                <!-- Tinggal di LKSA sejak -->
                <div class="mb-5">
                    <label class="block text-gray-800 font-semibold mb-2">Tinggal di LKSA sejak</label>
                    <input type="text" name="tinggal_di_lksa_sejak" value="{{ old('tinggal_di_lksa_sejak') }}" placeholder="Contoh: Dari kandungan ibu tahun 2023 atau Tahun 2024" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 placeholder:text-sm placeholder:text-gray-400" required>
                    <p class="text-xs text-gray-500 mt-1">Isikan apakah sejak dalam kandungan atau tahun masuk LKSA.</p>
                </div>

                <!-- Sekolah dan Kelas -->
                <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 mb-5">
                    <div>
                        <label class="block text-gray-800 font-semibold mb-2">Sekolah</label>
                        <input type="text" name="sekolah" value="{{ old('sekolah') }}" placeholder="Masukkan Nama Sekolah..." class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 placeholder:text-sm placeholder:text-gray-400" required>
                    </div>
                    <div>
                        <label class="block text-gray-800 font-semibold mb-2">Kelas</label>
                        <input type="text" name="kelas" value="{{ old('kelas') }}" placeholder="Masukkan Kelas..." class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 placeholder:text-sm placeholder:text-gray-400" required>
                    </div>
                </div>

                <!-- Jenis Kelamin -->
                <div class="mb-5">
                    <label class="block text-gray-800 font-semibold mb-2">Jenis Kelamin</label>
                    <div class="flex gap-6 items-center">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="jenis_kelamin" value="L" class="w-4 h-4 text-blue-600 focus:ring-blue-500" required>
                            <span class="text-gray-700 font-medium">Laki-laki</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="jenis_kelamin" value="P" class="w-4 h-4 text-blue-600 focus:ring-blue-500" required>
                            <span class="text-gray-700 font-medium">Perempuan</span>
                        </label>
                    </div>
                </div>

                <!-- Status Sosial Anak -->
                <div class="mb-5">
                    <label class="block text-gray-800 font-semibold mb-2">Status Sosial Anak</label>
                    <select name="status_social_anak" id="status-social-anak" 
                        class="w-full h-[46px] appearance-none border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm text-gray-400" 
                        required
                        onchange="this.classList.remove('text-gray-400','text-sm'); this.classList.add('text-gray-900')">
                            
                        <option value="" disabled selected>Pilih Status...</option>
                        <option class="text-gray-900" value="Yatim">Yatim</option>
                        <option class="text-gray-900" value="Piatu">Piatu</option>
                        <option class="text-gray-900" value="Yatim Piatu">Yatim Piatu</option>
                        <option class="text-gray-900" value="Dhuafa">Dhuafa</option>
                    </select>
                </div>

                <!-- Nama Ayah dan Nama Ibu -->
                <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 mb-5">
                    <div id="field-nama-ayah">
                        <label class="block text-gray-800 font-semibold mb-2">Nama Ayah</label>
                        <input type="text" name="nama_ayah" value="{{ old('nama_ayah') }}"
                            placeholder="Masukkan Nama Ayah..."
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 placeholder:text-sm placeholder:text-gray-400">
                    </div>
                    <div id="field-nama-ibu">
                        <label class="block text-gray-800 font-semibold mb-2">Nama Ibu</label>
                        <input type="text" name="nama_ibu" value="{{ old('nama_ibu') }}"
                            placeholder="Masukkan Nama Ibu..."
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 placeholder:text-sm placeholder:text-gray-400">
                    </div>
                </div>

                <!-- Upload Foto Anak -->
                <div class="mb-8">
                    <label class="block text-gray-800 font-semibold mb-2">Upload Foto Anak</label>
                    <input type="file" name="foto" accept="image/*" class="w-full rounded-2xl file:mr-4 file:py-2 file:px-4 file:rounded-2xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-[#1a56db] hover:file:bg-blue-100 cursor-pointer">
                    <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG, JPEG. Maksimal 2MB.</p>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex justify-center items-center gap-4 pt-6 border-t border-gray-200 mt-6 pb-2">
                    <a href="{{ route('anak-asuh.index') }}" class="rounded-2xl bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 border border-gray-300  transition hover:bg-gray-300">
                        Batal
                    </a>
                    <button type="submit" class="rounded-2xl bg-blue-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-600">
                        Simpan
                    </button>
                </div>
                
            </form>
        </div>
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
});
</script>
@endpush
