@extends('layouts.app')
@section('title', 'Edit ' . ucfirst($roleFilter))
@section('page-title', 'Edit ' . ucfirst($roleFilter))

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('admin.pengelola.index', $roleFilter) }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-500 hover:text-gray-800 transition">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Data {{ ucfirst($roleFilter) }}
        </a>
    </div>
    <form method="POST" action="{{ route('admin.pengelola.update', [$roleFilter, $user->id]) }}" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8">
        @csrf @method('PUT')
        <h3 class="text-lg font-bold text-gray-900 mb-6">Edit Profil {{ ucfirst($roleFilter) }}</h3>

        <div class="grid gap-5">
            @if($errors->any())
                <div class="rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                    <ul class="list-disc ml-4 space-y-1">
                        @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                    </ul>
                </div>
            @endif

            {{-- Foto --}}
            <div>
                <label class="mb-1.5 block text-sm font-semibold text-gray-700">Foto</label>
                @if($user->foto)
                    <img src="{{ asset('storage/' . $user->foto) }}" class="h-16 w-16 rounded-xl object-cover mb-2" />
                @endif
                <input type="file" name="foto" accept="image/*" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500" />
            </div>

            {{-- Nama & Email --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-700">Nama <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                           class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500" />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-700">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                           class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500" />
                </div>
            </div>

            {{-- Jabatan & Jenis Kelamin --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-700">Jabatan</label>
                    <input type="text" name="jabatan" value="{{ old('jabatan', $user->jabatan) }}"
                           class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500" />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-700">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih</option>
                        <option value="L" {{ old('jenis_kelamin', $user->jenis_kelamin) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $user->jenis_kelamin) === 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
            </div>

            {{-- Tempat & Tanggal Lahir --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-700">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $user->tempat_lahir) }}"
                           class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500" />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-700">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $user->tanggal_lahir ? \Carbon\Carbon::parse($user->tanggal_lahir)->format('Y-m-d') : '') }}"
                           class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500" />
                </div>
            </div>

            {{-- No HP & Status --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-700">No. HP</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
                           class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500" />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-gray-700">Status <span class="text-red-500">*</span></label>
                    <select name="status" required class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                        <option value="aktif" {{ old('status', $user->status) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="tidak_aktif" {{ old('status', $user->status) === 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-semibold text-gray-700">Alamat</label>
                <textarea name="alamat" rows="3" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500">{{ old('alamat', $user->alamat) }}</textarea>
            </div>
        </div>

        <div class="mt-8 flex justify-end gap-3 border-t border-gray-100 pt-6">
            <a href="{{ route('admin.pengelola.index', $roleFilter) }}" class="rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">Batal</a>
            <button type="submit" class="rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 transition">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
