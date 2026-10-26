@extends('layouts.app')
@section('page-title', 'Data Pegawai')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Main Content Card -->
    <div class="overflow-hidden rounded-2xl bg-white shadow-sm border border-gray-200">
        
        <!-- Header / Banner Cover -->
        <div class="relative bg-gradient-to-r from-amber-500 to-amber-600 px-6 py-6 sm:px-8 sm:py-7">
            <div class="flex flex-row items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-white sm:text-2xl">Edit Profil Pegawai</h2>
                    <p class="text-sm text-amber-100 mt-0.5">Perbarui informasi profil pegawai.</p>
                </div>
                <!-- Tombol Kembali -->
                <a href="{{ route('admin.pegawai.index') }}" 
                   class="inline-flex items-center gap-2 rounded-xl bg-white/20 backdrop-blur-sm border border-white/30 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-white/30 transition flex-shrink-0" 
                   title="Kembali">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span class="hidden sm:inline">Kembali</span>
                </a>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.pegawai.update', $pegawai->id) }}" enctype="multipart/form-data" class="p-4 md:p-6">
            @csrf
            @method('PUT')

            <div class="space-y-5">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-sm font-semibold text-gray-800">Nama <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama', $pegawai->nama) }}" required class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-semibold text-gray-800">Jabatan <span class="text-red-500">*</span></label>
                        <select id="jabatan_select" name="jabatan" required class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="Admin" @selected(old('jabatan', $pegawai->jabatan) === 'Admin')>Admin</option>
                            <option value="Ketua" @selected(old('jabatan', $pegawai->jabatan) === 'Ketua')>Ketua</option>
                            <option value="Bendahara" @selected(old('jabatan', $pegawai->jabatan) === 'Bendahara')>Bendahara</option>
                            <option value="Pengasuh" @selected(old('jabatan', $pegawai->jabatan) === 'Pengasuh')>Pengasuh</option>
                            @if(!in_array($pegawai->jabatan, ['Admin', 'Ketua', 'Bendahara', 'Pengasuh']) && $pegawai->jabatan)
                                <option value="{{ $pegawai->jabatan }}" selected>{{ $pegawai->jabatan }}</option>
                            @endif
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-sm font-semibold text-gray-800">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $pegawai->tempat_lahir) }}" class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-semibold text-gray-800">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $pegawai->tanggal_lahir?->format('Y-m-d')) }}" class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-sm font-semibold text-gray-800">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih</option>
                            <option value="L" @selected(old('jenis_kelamin', $pegawai->jenis_kelamin) === 'L')>Laki-laki</option>
                            <option value="P" @selected(old('jenis_kelamin', $pegawai->jenis_kelamin) === 'P')>Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-semibold text-gray-800">No. HP</label>
                        <input type="tel" name="no_hp" value="{{ old('no_hp', $pegawai->no_hp) }}" minlength="10" maxlength="15" placeholder="cth. 081234567890" pattern="[0-9]{10,15}" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        @error('no_hp')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-800">Alamat</label>
                    <textarea name="alamat" rows="3" class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('alamat', $pegawai->alamat) }}</textarea>
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-800">Foto Pegawai</label>
                    @if($pegawai->foto)
                        <div class="mb-3">
                            <p class="text-sm text-gray-500 mb-1">Foto saat ini:</p>
                            <img src="{{ asset('storage/' . $pegawai->foto) }}" class="w-32 h-32 object-cover rounded-lg border border-gray-200">
                        </div>
                    @endif
                    <input type="file" name="foto" accept="image/*" class="w-full text-sm text-gray-600 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100 cursor-pointer border border-gray-200 rounded-xl bg-gray-50">
                    <p class="text-xs text-gray-500 mt-2">Biarkan kosong jika tidak ingin mengubah foto. Format: JPG, PNG, JPEG. Maksimal 2MB.</p>
                </div>

                @if($pegawai->user)
                    <!-- Bagian Akun Login Yang Sudah Ada -->
                    <div class="border-t border-gray-200 pt-4">
                        <p class="text-xs font-bold uppercase tracking-wide text-gray-500 mb-4">Pengaturan Akun Login</p>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label class="mb-1.5 block text-sm font-semibold text-gray-800">Username <span class="text-red-500">*</span></label>
                                <input type="text" name="username" value="{{ old('username', $pegawai->user->username) }}" required class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-semibold text-gray-800">Email <span class="text-red-500">*</span></label>
                                <input type="email" name="email" value="{{ old('email', $pegawai->user->email) }}" required class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 mt-4">
                            <div>
                                <label class="mb-1.5 block text-sm font-semibold text-gray-800">Role Akses</label>
                                <select name="role" class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="admin" @selected(old('role', $pegawai->user->role) === 'admin')>Admin</option>
                                    <option value="ketua" @selected(old('role', $pegawai->user->role) === 'ketua')>Ketua</option>
                                    <option value="bendahara" @selected(old('role', $pegawai->user->role) === 'bendahara')>Bendahara</option>
                                </select>
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-semibold text-gray-800">Status Akun</label>
                                <select name="status" class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="aktif" @selected(old('status', $pegawai->user->status) === 'aktif')>Aktif</option>
                                    <option value="nonaktif" @selected(old('status', $pegawai->user->status) === 'nonaktif')>Nonaktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 mt-4">
                            <div>
                                <label class="mb-1.5 block text-sm font-semibold text-gray-800">Password Baru</label>
                                <input type="password" name="password" placeholder="Kosongkan jika tidak diubah" class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-semibold text-gray-800">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" placeholder="Ulangi password baru" class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Info khusus Pengasuh -->
                    <div id="pengasuh_info" class="{{ strtolower(old('jabatan', $pegawai->jabatan)) === 'pengasuh' ? '' : 'hidden' }} p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-sm">
                        Pegawai dengan jabatan <strong>Pengasuh</strong> hanya dikelola sebagai data pegawai (tanpa akun login &amp; tanpa role sistem).
                    </div>

                    <!-- Bagian Tambah Akun Login Untuk Pegawai Yang Belum Memiliki Akun -->
                    <div id="akun_section" class="{{ strtolower(old('jabatan', $pegawai->jabatan)) === 'pengasuh' ? 'hidden' : '' }} border-t border-gray-200 pt-4">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wide text-gray-500">Tambahkan Akun Login</p>
                                <p class="text-xs text-gray-400 mt-0.5">Pegawai ini belum memiliki akun login. Aktifkan opsi di samping untuk membuatkan akun.</p>
                            </div>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" id="buat_akun_login" name="buat_akun_login" value="1" class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500" @checked(old('buat_akun_login'))>
                                <span class="text-xs font-bold text-gray-800">Buat Akun Login</span>
                            </label>
                        </div>

                        <div id="akun_fields" class="{{ old('buat_akun_login') ? '' : 'hidden' }} space-y-4 rounded-2xl bg-gray-50/80 border border-gray-200 p-4 sm:p-5">
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="mb-1.5 block text-sm font-semibold text-gray-800">Username <span class="text-red-500">*</span></label>
                                    <input type="text" id="username" name="username" value="{{ old('username') }}" placeholder="Masukkan username..." autocomplete="username"
                                        class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500" />
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-sm font-semibold text-gray-800">Email <span class="text-red-500">*</span></label>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email..." autocomplete="email"
                                        class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="mb-1.5 block text-sm font-semibold text-gray-800">Role Akses <span class="text-red-500">*</span></label>
                                    <select id="role_select" name="role" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                                        <option value="admin" @selected(old('role', strtolower($pegawai->jabatan)) === 'admin')>Admin</option>
                                        <option value="ketua" @selected(old('role', strtolower($pegawai->jabatan)) === 'ketua')>Ketua</option>
                                        <option value="bendahara" @selected(old('role', strtolower($pegawai->jabatan)) === 'bendahara')>Bendahara</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-sm font-semibold text-gray-800">Status Akun</label>
                                    <select name="status" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                                        <option value="aktif" @selected(old('status', 'aktif') === 'aktif')>Aktif</option>
                                        <option value="nonaktif" @selected(old('status') === 'nonaktif')>Nonaktif</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label for="password" class="mb-1.5 block text-sm font-semibold text-gray-800">Password <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <input id="password" type="password" name="password" placeholder="Minimal 8 karakter..." autocomplete="new-password"
                                            class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 pr-10" />
                                        <button type="button" onclick="togglePassword('password', 'icon-eye-pw', 'icon-eye-off-pw')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                                            <svg id="icon-eye-pw" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="3" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            <svg id="icon-eye-off-pw" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.477 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                        </button>
                                    </div>
                                </div>
                                <div>
                                    <label for="password_confirmation" class="mb-1.5 block text-sm font-semibold text-gray-800">Konfirmasi Password <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Ulangi password..." autocomplete="new-password"
                                            class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 pr-10" />
                                        <button type="button" onclick="togglePassword('password_confirmation', 'icon-eye-conf', 'icon-eye-off-conf')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                                            <svg id="icon-eye-conf" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="3" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            <svg id="icon-eye-off-conf" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.477 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="flex justify-center items-center gap-4 pt-6 border-t border-gray-200 mt-6 pb-2">
                <a href="{{ route('admin.pegawai.index') }}" class="rounded-xl bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 border border-gray-300 transition hover:bg-gray-300">
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
    function togglePassword(inputId, iconOnId, iconOffId) {
        const input = document.getElementById(inputId);
        const iconOn = document.getElementById(iconOnId);
        const iconOff = document.getElementById(iconOffId);

        if (!input) return;

        if (input.type === 'password') {
            input.type = 'text';
            if (iconOn) iconOn.classList.add('hidden');
            if (iconOff) iconOff.classList.remove('hidden');
        } else {
            input.type = 'password';
            if (iconOn) iconOn.classList.remove('hidden');
            if (iconOff) iconOff.classList.add('hidden');
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
            if (!jabatanSelect) return;

            const jabatan = (jabatanSelect.value || '').toLowerCase();
            const isPengasuh = jabatan === 'pengasuh';

            if (pengasuhInfo && akunSection) {
                if (isPengasuh) {
                    pengasuhInfo.classList.remove('hidden');
                    akunSection.classList.add('hidden');
                    if (buatAkunCheckbox) {
                        buatAkunCheckbox.checked = false;
                    }
                    if (akunFields) {
                        akunFields.classList.add('hidden');
                    }
                } else {
                    pengasuhInfo.classList.add('hidden');
                    akunSection.classList.remove('hidden');

                    if (roleSelect && ['admin', 'ketua', 'bendahara'].includes(jabatan)) {
                        roleSelect.value = jabatan;
                    }

                    if (buatAkunCheckbox && akunFields) {
                        if (buatAkunCheckbox.checked) {
                            akunFields.classList.remove('hidden');
                        } else {
                            akunFields.classList.add('hidden');
                        }
                    }
                }
            }
        }

        if (jabatanSelect) {
            jabatanSelect.addEventListener('change', updateFormState);
        }

        if (buatAkunCheckbox && akunFields) {
            buatAkunCheckbox.addEventListener('change', function () {
                if (this.checked) {
                    akunFields.classList.remove('hidden');
                } else {
                    akunFields.classList.add('hidden');
                }
            });
        }

        updateFormState();
    });
</script>
@endpush
