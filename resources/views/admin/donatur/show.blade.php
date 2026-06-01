@extends('admin.layouts.app')
@section('page-title', 'Detail Donatur')

@section('content')
<div class="p-4 md:p-6 bg-gray-100 min-h-screen">
    
    <!-- Container lebih sempit: max-w-3xl (768px) -->
    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow overflow-hidden">
        
        <!-- Header -->
        <div class="p-2 md:p-4 border-b border-gray-200 flex justify-between items-center gap-4 bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex justify-between items-center">
            <div class="min-w-0">
                <h2 class="text-lg font-bold text-white truncate">Detail Donatur</h2>
                <p class="text-xs md:text-sm text-gray-300">Informasi lengkap donatur.</p>
            </div>
            <a href="{{ route('donatur.index') }}" class="text-xs md:text-sm font-semibold text-white hover:text-gray-400 flex items-center transition-colors whitespace-nowrap">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="hidden sm:inline">Kembali</span>
            </a>
        </div>

        <div class="p-4 md:p-6">

            <!-- Layout: Foto di atas (mobile) / kiri (desktop) -->
            <div class="flex flex-col md:flex-row gap-6 items-center md:items-start">

                <!-- Foto Section (Icon Placeholder) -->
                <div class="flex flex-col items-center gap-3 flex-shrink-0">
                    <div class="w-32 h-32 md:w-40 md:h-40 rounded-2xl bg-gradient-to-br from-slate-50 to-slate-100 border border-slate-200 shadow-sm flex items-center justify-center">
                        <svg class="w-16 h-16 md:w-20 md:h-20 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                    </div>
                    
                    <div class="text-center">
                        <span class="text-base md:text-lg font-bold text-gray-900 block truncate max-w-[180px] md:max-w-none">
                            {{ $donatur->nama }}
                        </span>
                        <span class="inline-block mt-1 px-3 py-0.5 rounded-full text-xs font-semibold {{ $donatur->status == 'aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ ucfirst(str_replace('_', ' ', $donatur->status)) }}
                        </span>
                    </div>
                </div>

                <!-- Divider vertikal (desktop only) -->
                <div class="hidden md:block w-px h-32 bg-gray-200"></div>
                <!-- Divider horizontal (mobile only) -->
                <div class="md:hidden w-full h-px bg-gray-200"></div>

                <!-- Detail Section -->
                <div class="w-full space-y-2.5">

                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-28 flex-shrink-0">Email</span>
                            <span class="text-gray-400">:</span>
                            <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">{{ $donatur->email }}</span>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-28 flex-shrink-0">No. HP</span>
                            <span class="text-gray-400">:</span>
                            <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">{{ $donatur->no_hp }}</span>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-28 flex-shrink-0">Alamat</span>
                            <span class="text-gray-400">:</span>
                            <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">{{ $donatur->alamat }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="mt-6 pt-4 border-t border-gray-200 flex flex-wrap gap-3 justify-center">
                <a href="{{ route('donatur.edit', $donatur->id) }}"
                class="rounded-2xl bg-orange-500 px-5 py-2 text-sm font-semibold text-white border border-orange-600  transition hover:bg-orange-600">
                    Edit
                </a>
                <button onclick="openDeleteModal({{ $donatur->id }})"
                class="rounded-2xl bg-red-600 px-5 py-2 text-sm font-semibold text-white border border-red-700  transition hover:bg-red-700">
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
