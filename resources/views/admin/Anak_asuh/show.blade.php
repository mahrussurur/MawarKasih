@extends('admin.layouts.app')
@section('page-title', 'Data Anak Asuh')

@section('content')
<div class="p-4 md:p-6 bg-slate-100 min-h-screen">

    <div class="max-w-3xl mx-auto overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        
        <!-- Header -->
        <div class="p-2 md:p-4 border-b border-gray-200 flex justify-between items-center gap-4 bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex justify-between items-center">
            <div class="min-w-0">
                <h2 class="text-lg font-bold text-white truncate">Detail Anak Asuh</h2>
                <p class="text-xs md:text-sm text-gray-300">Informasi lengkap anak asuh.</p>
            </div>
            <a href="{{ route('anak-asuh.index') }}" class="text-xs md:text-sm font-semibold text-white hover:text-gray-400 flex items-center transition-colors whitespace-nowrap">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="hidden sm:inline">Kembali</span>
            </a>
        </div>

        <div class="p-4 md:p-6">
            <!-- Layout: Foto di atas (mobile) / kiri (desktop) -->
            <div class="flex flex-col md:flex-row gap-6 items-center md:items-start">
                
                <!-- Foto Section -->
                <div class="flex flex-col items-center gap-3 flex-shrink-0">
                    <button type="button"
                            onclick="openImagePreview('{{ asset('storage/'.$anakAsuh->foto) }}')"
                            aria-label="Perbesar foto {{ $anakAsuh->nama }}">
                        <img src="{{ asset('storage/'.$anakAsuh->foto) }}"
                             class="w-32 h-32 md:w-40 md:h-40 rounded-lg object-cover border-2 border-gray-200 cursor-pointer transition duration-200 hover:scale-105"
                             alt="Foto {{ $anakAsuh->nama }}"
                             title="Klik untuk perbesar">
                    </button>
                    <div class="text-center">
                        <span class="text-base md:text-lg font-bold text-gray-900 block truncate max-w-[180px] md:max-w-none">
                            {{ $anakAsuh->nama }}
                        </span>
                        <span class="inline-block mt-1 px-3 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                            {{ $anakAsuh->status_social_anak }}
                        </span>
                    </div>
                </div>

                <!-- Divider vertikal (desktop only) -->
                <div class="hidden md:block w-px h-32 bg-gray-200"></div>
                
                <!-- Divider horizontal (mobile only) -->
                <div class="md:hidden w-full h-px bg-gray-200"></div>

                <!-- Detail Section -->
                <div class="w-full space-y-2.5">
                    
                    <!-- Nama Panggilan -->
                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-28 flex-shrink-0">Nama Panggilan</span>
                            <span class="text-gray-400">:</span>
                            <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">{{ $anakAsuh->nama_panggilan }}</span>
                        </div>
                    </div>

                    <!-- Tempat Lahir -->
                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-28 flex-shrink-0">Tempat Lahir</span>
                            <span class="text-gray-400">:</span>
                            <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">{{ $anakAsuh->tempat_lahir }}</span>
                        </div>
                    </div>

                    <!-- Tanggal Lahir -->
                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-28 flex-shrink-0">Tanggal Lahir</span>
                            <span class="text-gray-400">:</span>
                            <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">
                                {{ \Carbon\Carbon::parse($anakAsuh->tanggal_lahir)->isoFormat('D MMM Y') }}
                            </span>
                        </div>
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-28 flex-shrink-0">Jenis Kelamin</span>
                            <span class="text-gray-400">:</span>
                            <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">
                                {{ $anakAsuh->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </span>
                        </div>
                    </div>

                    <!-- Nama Ayah -->
                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-28 flex-shrink-0">Nama Ayah</span>
                            <span class="text-gray-400">:</span>
                            <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">{{ $anakAsuh->nama_ayah ?? '-' }}</span>
                        </div>
                    </div>

                    <!-- Nama Ibu -->
                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-28 flex-shrink-0">Nama Ibu</span>
                            <span class="text-gray-400">:</span>
                            <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">{{ $anakAsuh->nama_ibu ?? '-' }}</span>
                        </div>
                    </div>

                    <!-- Tinggal di LKSA -->
                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-28 flex-shrink-0">Tinggal di LKSA Sejak</span>
                            <span class="text-gray-400">:</span>
                            <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">{{ $anakAsuh->tinggal_di_lksa_sejak }}</span>
                        </div>
                    </div>

                    <!-- Sekolah -->
                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-28 flex-shrink-0">Sekolah</span>
                            <span class="text-gray-400">:</span>
                            <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">{{ $anakAsuh->sekolah }}</span>
                        </div>
                    </div>

                    <!-- Kelas -->
                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-28 flex-shrink-0">Kelas</span>
                            <span class="text-gray-400">:</span>
                            <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">{{ $anakAsuh->kelas }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="mt-6 pt-4 border-t border-gray-200 flex flex-wrap gap-3 justify-center">
                <a href="{{ route('anak-asuh.edit', $anakAsuh->id) }}" 
                class="rounded-2xl bg-orange-500 px-5 py-2 text-sm font-semibold text-white border border-orange-600  transition hover:bg-orange-600">
                    Edit
                </a>
                <button onclick="openDeleteModal({{ $anakAsuh->id }})" 
                class="rounded-2xl bg-red-600 px-5 py-2 text-sm font-semibold text-white border border-red-700  transition hover:bg-red-700">
                    Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Preview Gambar -->
<div id="imagePreviewModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/70 px-4" onclick="closeImagePreview()">
    <div class="relative max-h-[90vh] max-w-[95vw]" onclick="event.stopPropagation()">
        <button type="button"
                class="absolute -right-2 -top-2 md:-right-3 md:-top-3 h-8 w-8 md:h-10 md:w-10 flex items-center justify-center rounded-full bg-white text-slate-700 shadow-lg transition hover:bg-slate-100"
                onclick="closeImagePreview()"
                aria-label="Tutup preview">
            <svg class="h-4 w-4 md:h-5 md:w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        <img id="imagePreview" src="" alt="Preview foto" class="max-h-[90vh] max-w-[95vw] rounded-lg md:rounded-2xl object-contain shadow-2xl">
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div id="deleteModal" class="fixed inset-0 bg-gray-900/50 overflow-y-auto h-full w-full hidden z-50 items-center justify-center p-4">
    <div class="relative mx-auto p-5 border w-full max-w-sm shadow-lg rounded-lg bg-white">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-3">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <h3 class="text-base font-semibold text-gray-900 mb-1">Konfirmasi Hapus</h3>
            <p class="text-xs md:text-sm text-gray-500 mb-4">Yakin ingin menghapus data <strong>"{{ $anakAsuh->nama }}"</strong>?</p>
            <div class="flex gap-2">
                <button onclick="closeDeleteModal()" class="flex-1 py-2 bg-gray-200 text-gray-800 text-sm font-medium rounded-lg hover:bg-gray-300 transition">Batal</button>
                <form id="deleteForm" method="POST" class="flex-1">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-full py-2 bg-red-500 text-white text-sm font-medium rounded-lg hover:bg-red-600 transition">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
const imagePreviewModal = document.getElementById('imagePreviewModal');
const deleteModal = document.getElementById('deleteModal');
const imagePreview = document.getElementById('imagePreview');

function openImagePreview(src) {
    imagePreview.src = src;
    imagePreviewModal.classList.remove('hidden');
    imagePreviewModal.classList.add('flex');
}

function closeImagePreview() {
    imagePreviewModal.classList.add('hidden');
    imagePreviewModal.classList.remove('flex');
    setTimeout(() => { imagePreview.src = ''; }, 200);
}

function openDeleteModal(id) {
    document.getElementById('deleteForm').action = '{{ url("anak-asuh") }}/' + id;
    deleteModal.classList.remove('hidden');
    deleteModal.classList.add('flex');
}

function closeDeleteModal() {
    deleteModal.classList.add('hidden');
    deleteModal.classList.remove('flex');
}

// Close modal dengan klik di luar atau ESC
[imagePreviewModal, deleteModal].forEach(modal => {
    modal?.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeImagePreview();
            closeDeleteModal();
        }
    });
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImagePreview();
        closeDeleteModal();
    }
});
</script>
@endsection
