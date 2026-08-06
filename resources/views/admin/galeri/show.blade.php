@extends('admin.layouts.app')
@section('page-title', 'Detail Galeri')

@section('content')
<div class="p-4 md:p-6 bg-gray-100 min-h-screen">

    <!-- Container lebih sempit: max-w-3xl (768px) -->
    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow overflow-hidden">

        <!-- Header -->
        <div class="p-2 md:p-4 border-b border-gray-200 flex justify-between items-center gap-4 bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex justify-between items-center">
            <div class="min-w-0">
                <h2 class="text-lg font-bold text-white truncate">Detail Galeri</h2>
                <p class="text-xs md:text-sm text-gray-300">Informasi lengkap galeri.</p>
            </div>
            <a href="{{ route('galeri.index') }}" class="text-xs md:text-sm font-semibold text-white hover:text-gray-400 flex items-center transition-colors whitespace-nowrap">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="hidden sm:inline">Kembali</span>
            </a>
        </div>

        <div class="p-6 sm:p-6">

        <!-- Layout: Foto di atas -->
            <div class="flex flex-col gap-6 items-center">

                <!-- Foto Section -->
                <div class="flex flex-col items-center gap-3 flex-shrink-0">
                    <button type="button"
                            onclick="openImagePreview('{{ asset('storage/'.$galeri->foto) }}')"
                            aria-label="Perbesar foto {{ $galeri->judul }}">
                        <img src="{{ asset('storage/'.$galeri->foto) }}"
                            class="w-40 md:w-80 aspect-video rounded-lg border-2 border-gray-200 cursor-pointer transition duration-200 hover:scale-105"
                            alt="Foto {{ $galeri->judul }}"
                            title="Klik untuk perbesar">
                    </button>
                    <div class="text-center">
                        <span class="text-base md:text-lg font-bold text-gray-900 block truncate max-w-[180px] md:max-w-none">
                            {{ $galeri->judul }}
                        </span>
                        <span class="inline-block mt-1 px-3 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                            {{ \Carbon\Carbon::parse($galeri->created_at)->translatedFormat('d F Y') }}
                        </span>
                        <span class="inline-block mt-1 px-3 py-0.5 rounded-full text-xs font-semibold {{ $galeri->kategori === 'fasilitas' ? 'bg-emerald-100 text-emerald-700' : 'bg-sky-100 text-sky-700' }}">
                            {{ ucfirst($galeri->kategori) }}
                        </span>
                    </div>
                </div>

                <div class="border-t border-gray-200 my-1 w-full"></div>

                <!-- Detail Section -->
                <div class="w-full space-y-2.5">
                    <!-- Deskripsi -->
                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-28 flex-shrink-0">Deskripsi</span>
                            <span class="text-gray-400">:</span>
                            <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">{{ $galeri->deskripsi ?? '-' }}</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Tombol Aksi -->
            <div class="mt-6 pt-4 border-t border-gray-200 flex flex-wrap gap-3 justify-center">
                <a href="{{ route('galeri.edit', $galeri->id) }}" 
                class="rounded-2xl bg-orange-500 px-5 py-2 text-sm font-semibold text-white border border-orange-600  transition hover:bg-orange-600">
                    Edit
                </a>
                <button onclick="openDeleteModal({{ $galeri->id }})" 
                class="rounded-2xl bg-red-600 px-5 py-2 text-sm font-semibold text-white border border-red-700  transition hover:bg-red-700">
                    Hapus
                </button>
            </div>
            
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div id="imagePreviewModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/70 px-4">
    <div class="relative max-h-[90vh] max-w-[90vw]" onclick="event.stopPropagation()">
        <button type="button"
                class="absolute -right-3 -top-3 inline-flex h-10 w-10 items-center justify-center rounded-full bg-white text-slate-700 shadow-lg transition hover:bg-slate-100"
                onclick="closeImagePreview()"
                aria-label="Tutup preview gambar">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <img id="imagePreview" src="" alt="Preview foto" class="max-h-[90vh] max-w-[90vw] rounded-2xl border border-white/70 bg-white object-contain shadow-2xl">
    </div>
</div>

<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg font-medium text-gray-900">Konfirmasi Hapus</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus data pengasuh ini?</p>
            </div>
            <div class="flex items-center px-4 py-3 gap-3">
                <button onclick="closeDeleteModal()" class="py-2 bg-gray-500 text-white text-base font-medium rounded-md flex-1 shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-300">Batal</button>
                <form id="deleteForm" method="POST" class="flex-1">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-full px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
const imagePreviewModal = document.getElementById('imagePreviewModal');
const imagePreview = document.getElementById('imagePreview');

function openImagePreview(src) {
    imagePreview.src = src;
    imagePreviewModal.classList.remove('hidden');
    imagePreviewModal.classList.add('flex');
}

function closeImagePreview() {
    imagePreviewModal.classList.add('hidden');
    imagePreviewModal.classList.remove('flex');
    imagePreview.src = '';
}

function openDeleteModal(id) {
    document.getElementById('deleteForm').action = '{{ route("pengasuh.destroy", ["pengasuh" => ":id"]) }}'.replace(':id', id);
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

imagePreviewModal.addEventListener('click', function (event) {
    if (event.target === imagePreviewModal) {
        closeImagePreview();
    }
});
</script>

@endsection
