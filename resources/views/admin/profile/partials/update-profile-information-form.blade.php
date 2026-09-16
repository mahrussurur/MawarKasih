<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">Informasi Profil</h2>
        <p class="mt-1 text-sm text-gray-600">
            Perbarui data {{ $isDonatur ? 'donatur' : 'profil' }} dan informasi akun Anda.
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="border-b border-gray-100 pb-2 text-sm font-bold uppercase tracking-wide text-gray-500">Data Profil</div>

        @if($isDonatur)
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <x-input-label for="nama" value="Nama Lengkap" />
                    <x-text-input id="nama" name="nama" type="text" class="mt-1 block w-full" :value="old('nama', $profile?->nama)" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('nama')" />
                </div>
                <div>
                    <x-input-label for="no_hp" value="No. HP" />
                    <x-text-input id="no_hp" name="no_hp" type="text" class="mt-1 block w-full" :value="old('no_hp', $profile?->no_hp)" autocomplete="tel" />
                    <x-input-error class="mt-2" :messages="$errors->get('no_hp')" />
                </div>
            </div>
        @else
            <div>
                <x-input-label for="foto" value="Foto Profil" />
                @if($profile?->foto)
                    <img src="{{ asset('storage/' . $profile->foto) }}" alt="Foto profil" class="mb-2 mt-2 h-16 w-16 rounded-xl object-cover" />
                @endif
                <input type="file" id="foto" name="foto" accept="image/jpeg,image/png" class="mt-1 block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                <x-input-error class="mt-2" :messages="$errors->get('foto')" />
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <x-input-label for="nama" value="Nama Lengkap" />
                    <x-text-input id="nama" name="nama" type="text" class="mt-1 block w-full" :value="old('nama', $profile?->nama)" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('nama')" />
                </div>
                <div>
                    <x-input-label for="jabatan" value="Jabatan" />
                    <x-text-input id="jabatan" name="jabatan" type="text" class="mt-1 block w-full" :value="old('jabatan', $profile?->jabatan)" />
                    <x-input-error class="mt-2" :messages="$errors->get('jabatan')" />
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <x-input-label for="tempat_lahir" value="Tempat Lahir" />
                    <x-text-input id="tempat_lahir" name="tempat_lahir" type="text" class="mt-1 block w-full" :value="old('tempat_lahir', $profile?->tempat_lahir)" />
                    <x-input-error class="mt-2" :messages="$errors->get('tempat_lahir')" />
                </div>
                <div>
                    <x-input-label for="tanggal_lahir" value="Tanggal Lahir" />
                    <x-text-input id="tanggal_lahir" name="tanggal_lahir" type="date" class="mt-1 block w-full" :value="old('tanggal_lahir', $profile?->tanggal_lahir?->format('Y-m-d'))" />
                    <x-input-error class="mt-2" :messages="$errors->get('tanggal_lahir')" />
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <x-input-label for="jenis_kelamin" value="Jenis Kelamin" />
                    <select id="jenis_kelamin" name="jenis_kelamin" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Pilih</option>
                        <option value="L" @selected(old('jenis_kelamin', $profile?->jenis_kelamin) === 'L')>Laki-laki</option>
                        <option value="P" @selected(old('jenis_kelamin', $profile?->jenis_kelamin) === 'P')>Perempuan</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('jenis_kelamin')" />
                </div>
                <div>
                    <x-input-label for="no_hp" value="No. HP" />
                    <x-text-input id="no_hp" name="no_hp" type="text" class="mt-1 block w-full" :value="old('no_hp', $profile?->no_hp)" autocomplete="tel" />
                    <x-input-error class="mt-2" :messages="$errors->get('no_hp')" />
                </div>
            </div>
        @endif

        <div>
            <x-input-label for="alamat" value="Alamat" />
            <textarea id="alamat" name="alamat" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('alamat', $profile?->alamat) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('alamat')" />
        </div>

        <div class="border-b border-gray-100 pb-2 pt-2 text-sm font-bold uppercase tracking-wide text-gray-500">Akun Login</div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <x-input-label for="username" value="Username" />
                <x-text-input id="username" name="username" type="text" class="mt-1 block w-full" :value="old('username', $user->username)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('username')" />
            </div>
            <div>
                <x-input-label for="email" value="Email" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="email" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>
        </div>

        <div>
            <x-input-label value="Status Akun" />
            <p class="mt-1 inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $user->status === 'aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                {{ ucfirst(str_replace('_', ' ', $user->status)) }}
            </p>
            <p class="mt-1 text-xs text-gray-500">Status akun dikelola oleh admin.</p>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>

            @if(session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>
