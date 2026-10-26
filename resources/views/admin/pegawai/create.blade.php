@extends('layouts.app')

@section('page-title', 'Data Pegawai')

@section('content')
<div class="max-w-3xl mx-auto overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

    <!-- Header -->
    <div class="border-b border-gray-200 bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex justify-between items-center gap-4">
        <div class="min-w-0">
            <h2 class="text-lg font-bold text-white truncate">Tambah Data Pegawai</h2>
            <p class="text-xs md:text-sm text-gray-300">Formulir Penambahan Data Pegawai.</p>
        </div>
        <a href="{{ route('admin.pegawai.index') }}" class="text-xs md:text-sm font-semibold text-white hover:text-gray-400 flex items-center transition-colors whitespace-nowrap">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span class="hidden sm:inline">Kembali</span>
        </a>
    </div>

    <div class="p-4 md:p-6">
        <form method="POST" action="{{ route('admin.pegawai.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- Nama & Jabatan -->
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 mb-5">
                <div>
                    <label class="text-sm font-bold text-gray-800 block mb-2">Nama <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Masukkan Nama Lengkap..."
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm placeholder:text-gray-400" required>
                </div>
                <div>
                    <label class="text-sm font-bold text-gray-800 block mb-2">Jabatan <span class="text-red-500">*</span></label>
                    <select id="jabatan_select" name="jabatan" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                        <option value="">Pilih Jabatan</option>
                        <option value="Admin" @selected(old('jabatan') === 'Admin')>Admin</option>
                        <option value="Ketua" @selected(old('jabatan') === 'Ketua')>Ketua</option>
                        <option value="Bendahara" @selected(old('jabatan') === 'Bendahara')>Bendahara</option>
                        <option value="Pengasuh" @selected(old('jabatan') === 'Pengasuh')>Pengasuh</option>
                    </select>
                </div>
            </div>

            <!-- Tempat & Tanggal Lahir -->
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 mb-5">
                <div>
                    <label class="text-sm font-bold text-gray-800 block mb-2">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" placeholder="Masukkan Tempat Lahir..."
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm placeholder:text-gray-400">
                </div>
                <div>
                    <label class="text-sm font-bold text-gray-800 block mb-2">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm text-gray-500">
                </div>
            </div>

            <!-- Jenis Kelamin & No. HP -->
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 mb-5">
                <div>
                    <label class="text-sm font-bold text-gray-800 block mb-2">Jenis Kelamin<span class="text-red-500">*</span></label>
                    <select name="jenis_kelamin" id="jenis_kelamin"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm {{ old('jenis_kelamin') ? 'text-gray-900' : 'text-gray-500' }} appearance-none"
                        required
                        onchange="this.classList.remove('text-gray-400','text-sm','text-gray-500'); this.classList.add('text-gray-900')">
                        <option value="" disabled {{ old('jenis_kelamin') ? '' : 'selected' }}>Pilih Jenis Kelamin...</option>
                        <option class="text-gray-900" value="L" @selected(old('jenis_kelamin') === 'L')>Laki-laki</option>
                        <option class="text-gray-900" value="P" @selected(old('jenis_kelamin') === 'P')>Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="text-sm font-bold text-gray-800 block mb-2">No. HP</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="Contoh: 08123456789"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm placeholder:text-gray-400">
                </div>
            </div>

            <!-- Alamat -->
            <div class="mb-5">
                <label class="text-sm font-bold text-gray-800 block mb-2">Alamat</label>
                <textarea name="alamat" rows="3" placeholder="Masukkan Alamat Lengkap..."
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm placeholder:text-gray-400">{{ old('alamat') }}</textarea>
            </div>

            <!-- Foto -->
            <div class="mb-5">
                <label class="text-sm font-bold text-gray-800 block mb-2">Upload Foto</label>
                <input type="file" id="foto_input" name="foto" accept="image/jpeg,image/png,image/jpg"
                    class="w-full text-sm text-gray-600 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100 cursor-pointer border border-gray-200 rounded-xl bg-gray-50">
                <div id="preview_container" class="mt-3 hidden">
                    <img id="foto_preview" src="#" alt="Preview Foto" class="max-h-48 w-auto rounded-lg object-cover border border-gray-200 shadow-sm">
                    <button type="button" id="remove_preview" class="mt-2 text-sm text-red-600 hover:text-red-700 font-medium focus:outline-none">Hapus Foto</button>
                </div>
                <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG. Maksimal 2MB.</p>
            </div>

            <!-- Info Pengasuh -->
            <div id="pengasuh_info" class="hidden mb-5 p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-sm">
                Pegawai dengan jabatan <strong>Pengasuh</strong> hanya dikelola sebagai data pegawai (tanpa akun login & tanpa role sistem).
            </div>

            <!-- Akun Login -->
            <div id="akun_section">
                <div class="flex items-center justify-between mb-4 mt-2">
                    <p class="text-xs font-bold uppercase tracking-wide text-gray-500">Akun Login</p>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" id="buat_akun_login" name="buat_akun_login" value="1" class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500" @checked(old('buat_akun_login', true))>
                        <span class="text-xs font-semibold text-gray-700">Aktifkan Akun Login</span>
                    </label>
                </div>

                <div id="akun_fields">
                    <!-- Username & Email -->
                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 mb-5">
                        <div>
                            <label class="text-sm font-bold text-gray-800 block mb-2">Username <span class="text-red-500">*</span></label>
                            <input type="text" id="username" name="username" value="{{ old('username') }}" placeholder="Masukkan Username..." autocomplete="username"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm placeholder:text-gray-400">
                        </div>
                        <div>
                            <label class="text-sm font-bold text-gray-800 block mb-2">Email <span class="text-red-500">*</span></label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan Email..." autocomplete="email"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm placeholder:text-gray-400">
                        </div>
                    </div>

                    <!-- Role -->
                    <div class="mb-5">
                        <label class="text-sm font-bold text-gray-800 block mb-2">Role Akses <span class="text-red-500">*</span></label>
                        <select id="role_select" name="role"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                            <option value="admin" @selected(old('role') === 'admin')>Admin</option>
                            <option value="ketua" @selected(old('role') === 'ketua')>Ketua</option>
                            <option value="bendahara" @selected(old('role') === 'bendahara')>Bendahara</option>
                        </select>
                    </div>

                    <!-- Password & Konfirmasi Password -->
                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 mb-5">
                        <div>
                            <label for="password" class="text-sm font-bold text-gray-800 block mb-2">Password <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input id="password" type="password" name="password" placeholder="Masukkan Password..." autocomplete="new-password"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm placeholder:text-gray-400 pr-12 @error('password') border-red-400 ring-1 ring-red-400 @enderror">
                                <button type="button" onclick="togglePassword('password', 'icon-eye-pw', 'icon-eye-off-pw')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors" aria-label="Tampilkan password">
                                    <svg id="icon-eye-pw" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <circle cx="12" cy="12" r="3" stroke-width="2.5"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg id="icon-eye-off-pw" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.477 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                    </svg>
                                </button>
                            </div>
                            @error('password')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="text-sm font-bold text-gray-800 block mb-2">Konfirmasi Password <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Ulangi Password..." autocomplete="new-password"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm placeholder:text-gray-400 pr-12">
                                <button type="button" onclick="togglePassword('password_confirmation', 'icon-eye-conf', 'icon-eye-off-conf')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors" aria-label="Tampilkan konfirmasi password">
                                    <svg id="icon-eye-conf" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <circle cx="12" cy="12" r="3" stroke-width="2.5"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg id="icon-eye-off-conf" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.477 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-center items-center gap-4 pt-6 border-t border-gray-200 mt-4 pb-2">
                <a href="{{ route('admin.pegawai.index') }}"
                    class="rounded-xl bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 border border-gray-300 transition hover:bg-gray-300">
                    Batal
                </a>
                <button type="submit"
                    class="rounded-xl bg-green-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-green-700">
                    Simpan
                </button>
            </div>

        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function togglePassword(inputId, iconOnId, iconOffId) {
        const input = document.getElementById(inputId);
        const iconOn = document.getElementById(iconOnId);
        const iconOff = document.getElementById(iconOffId);

        if (input.type === 'password') {
            input.type = 'text';
            iconOn.classList.add('hidden');
            iconOff.classList.remove('hidden');
        } else {
            input.type = 'password';
            iconOn.classList.remove('hidden');
            iconOff.classList.add('hidden');
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const jabatanSelect = document.getElementById('jabatan_select');
        const pengasuhInfo = document.getElementById('pengasuh_info');
        const akunSection = document.getElementById('akun_section');
        const buatAkunCheckbox = document.getElementById('buat_akun_login');
        const akunFields = document.getElementById('akun_fields');
        const roleSelect = document.getElementById('role_select');

        function updateFormState() {
            const jabatan = (jabatanSelect.value || '').toLowerCase();
            const isPengasuh = jabatan === 'pengasuh';

            if (isPengasuh) {
                pengasuhInfo.classList.remove('hidden');
                akunSection.classList.add('hidden');
                buatAkunCheckbox.checked = false;
                akunFields.classList.add('hidden');
            } else {
                pengasuhInfo.classList.add('hidden');
                akunSection.classList.remove('hidden');

                if (['admin', 'ketua', 'bendahara'].includes(jabatan)) {
                    roleSelect.value = jabatan;
                }

                if (buatAkunCheckbox.checked) {
                    akunFields.classList.remove('hidden');
                } else {
                    akunFields.classList.add('hidden');
                }
            }
        }

        jabatanSelect.addEventListener('change', updateFormState);
        buatAkunCheckbox.addEventListener('change', function () {
            if (this.checked) {
                akunFields.classList.remove('hidden');
            } else {
                akunFields.classList.add('hidden');
            }
        });

        updateFormState();

        if (typeof setupImagePreview === 'function') {
            setupImagePreview('foto_input', 'preview_container', 'foto_preview', 'remove_preview');
        } else {
            const input = document.getElementById('foto_input');
            const container = document.getElementById('preview_container');
            const preview = document.getElementById('foto_preview');
            const removeBtn = document.getElementById('remove_preview');

            if (input && container && preview) {
                input.addEventListener('change', function () {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            preview.src = e.target.result;
                            container.classList.remove('hidden');
                        }
                        reader.readAsDataURL(file);
                    }
                });
                if (removeBtn) {
                    removeBtn.addEventListener('click', function () {
                        input.value = '';
                        preview.src = '#';
                        container.classList.add('hidden');
                    });
                }
            }
        }
    });
</script>
@endpush
