@extends('admin.layouts.app')
@section('page-title', 'Detail Donatur')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen flex justify-center items-start">
    
    <div class="w-full max-w-3xl bg-white rounded-xl shadow-md p-8 border border-gray-200 mt-4">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Detail Data Donatur</h2>
            <a href="{{ route('donatur.index') }}" class="text-blue-500 hover:text-blue-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </a>
        </div>

        <div class="space-y-6">
            <div class="border-b border-gray-200 pb-4">
                <p class="text-gray-600 text-sm font-semibold">Nama Lengkap</p>
                <p class="text-gray-800 text-lg font-semibold mt-1">{{ $donatur->nama }}</p>
            </div>

            <div class="border-b border-gray-200 pb-4">
                <p class="text-gray-600 text-sm font-semibold">Email</p>
                <p class="text-gray-800 text-lg font-semibold mt-1">{{ $donatur->email }}</p>
            </div>

            <div class="border-b border-gray-200 pb-4">
                <p class="text-gray-600 text-sm font-semibold">No. HP</p>
                <p class="text-gray-800 text-lg font-semibold mt-1">{{ $donatur->no_hp }}</p>
            </div>

            <div class="border-b border-gray-200 pb-4">
                <p class="text-gray-600 text-sm font-semibold">Alamat</p>
                <p class="text-gray-800 text-lg font-semibold mt-1">{{ $donatur->alamat }}</p>
            </div>

            <div class="border-b border-gray-200 pb-4">
                <p class="text-gray-600 text-sm font-semibold">Status</p>
                <p class="mt-1">
                    <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-medium {{ $donatur->status == 'aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ ucfirst(str_replace('_', ' ', $donatur->status)) }}
                    </span>
                </p>
            </div>

            <div class="border-b border-gray-200 pb-4">
                <p class="text-gray-600 text-sm font-semibold">Tanggal Dibuat</p>
                <p class="text-gray-800 text-lg font-semibold mt-1">{{ $donatur->created_at->format('d M Y H:i') }}</p>
            </div>

            <div class="pb-4">
                <p class="text-gray-600 text-sm font-semibold">Terakhir Diupdate</p>
                <p class="text-gray-800 text-lg font-semibold mt-1">{{ $donatur->updated_at->format('d M Y H:i') }}</p>
            </div>
        </div>

        <div class="flex justify-between items-center pt-6 border-t border-gray-200 mt-6">
            <a href="{{ route('donatur.index') }}" class="bg-gray-200 text-gray-700 border border-gray-300 px-8 py-2 rounded-lg font-medium hover:bg-gray-300 transition">
                Kembali
            </a>
            <div class="flex gap-3">
                <a href="{{ route('donatur.edit', $donatur->id) }}" class="bg-amber-500 text-white px-8 py-2 rounded-lg font-medium hover:bg-amber-600 transition">
                    Edit
                </a>
                <button onclick="openDeleteModal()" class="bg-red-500 text-white px-8 py-2 rounded-lg font-medium hover:bg-red-600 transition">
                    Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-50">
    <div class="rounded-lg bg-white p-6 shadow-lg max-w-sm w-full mx-4">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Konfirmasi Hapus</h2>
        <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus data donatur "{{ $donatur->nama }}"? Tindakan ini tidak dapat dibatalkan.</p>
        <div class="flex justify-end gap-3">
            <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                Batal
            </button>
            <form action="{{ route('donatur.destroy', $donatur->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function openDeleteModal() {
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });
</script>
@endsection
