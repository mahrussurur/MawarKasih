@extends('layouts.app')
@section('title', 'Edit Catatan Perkembangan')
@section('page-title', 'Edit Catatan Perkembangan')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('pengasuh.catatan-perkembangan.index') }}"
           class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-500 hover:text-gray-800 transition">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-bold text-gray-900 mb-6">Edit Catatan Perkembangan</h2>

        <form method="POST" action="{{ route('pengasuh.catatan-perkembangan.update', $catatanPerkembangan->id) }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Anak Asuh <span class="text-red-500">*</span></label>
                <select name="anak_asuh_id" required
                        class="w-full rounded-xl border @error('anak_asuh_id') border-red-400 @else border-gray-200 @enderror bg-gray-50 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">— Pilih Anak Asuh —</option>
                    @foreach($anakList as $anak)
                        <option value="{{ $anak->id }}" {{ old('anak_asuh_id', $catatanPerkembangan->anak_asuh_id) == $anak->id ? 'selected' : '' }}>{{ $anak->nama }}</option>
                    @endforeach
                </select>
                @error('anak_asuh_id')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Catatan <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', $catatanPerkembangan->tanggal?->format('Y-m-d')) }}" required
                           class="w-full rounded-xl border @error('tanggal') border-red-400 @else border-gray-200 @enderror bg-gray-50 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('tanggal')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kategori <span class="text-red-500">*</span></label>
                    <select name="kategori" required
                            class="w-full rounded-xl border @error('kategori') border-red-400 @else border-gray-200 @enderror bg-gray-50 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach($kategoriList as $k)
                            <option value="{{ $k }}" {{ old('kategori', $catatanPerkembangan->kategori) == $k ? 'selected' : '' }}>{{ $k }}</option>
                        @endforeach
                    </select>
                    @error('kategori')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Isi Catatan <span class="text-red-500">*</span></label>
                <textarea name="catatan" rows="5" required
                          class="w-full rounded-xl border @error('catatan') border-red-400 @else border-gray-200 @enderror bg-gray-50 px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ old('catatan', $catatanPerkembangan->catatan) }}</textarea>
                @error('catatan')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Foto Dokumentasi</label>
                @if($catatanPerkembangan->foto)
                    <div class="mb-2">
                        <img src="{{ Storage::url($catatanPerkembangan->foto) }}" alt="Foto" class="h-24 w-24 rounded-xl object-cover border border-gray-200">
                        <p class="mt-1 text-xs text-gray-400">Upload baru untuk mengganti foto lama.</p>
                    </div>
                @endif
                <input type="file" name="foto" accept="image/jpeg,image/png,image/jpg"
                       class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3 py-2.5 text-sm file:mr-3 file:rounded-lg file:border-0 file:bg-blue-50 file:px-3 file:py-1 file:text-sm file:font-semibold file:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('foto')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <a href="{{ route('pengasuh.catatan-perkembangan.index') }}"
                   class="rounded-xl border border-gray-300 px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-100">
                    Batal
                </a>
                <button type="submit"
                        class="rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                    Perbarui Catatan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
