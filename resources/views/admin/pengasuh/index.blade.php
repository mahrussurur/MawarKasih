@extends('admin.layouts.app')
@section('page-title', 'Data Pengasuh')

@section('content')
<div class="p-1 bg-gray-100 min-h-screen">

    <div class="flex justify-between mb-4">
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('pengasuh.create') }}" class="inline-flex items-center gap-2 rounded-2xl bg-blue-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-600">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Pengasuh
            </a>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('pengasuh.cetak') }}" target="_blank" class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak Laporan
            </a>
        </div>
    </div>

    <!-- Kotak utama konten -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        
        <div class="flex flex-col gap-4 border-b border-slate-200 py-4 lg:flex-row lg:items-center lg:justify-between">
             <!-- Search -->
            <form method="GET" action="{{ route('pengasuh.index') }}" class="flex w-full items-center gap-3 lg:w-auto">
                <label class="relative block w-full lg:w-[260px]">
                    <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-slate-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama pengasuh..."
                           class="w-full rounded-2xl border border-slate-200 bg-slate-50 py-2.5 pl-11 pr-4 text-sm text-slate-700 outline-none transition focus:border-sky-400 focus:bg-white focus:ring-2 focus:ring-sky-100" />
                </label>
            </form>
        </div>

        <!-- table data -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-sm font-semibold border-b border-gray-200">
                        <th class="px-4 py-3 text-center w-12">No</th>
                        <th class="px-4 py-3 w-20">Foto</th>
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Jabatan</th>
                        <th class="px-4 py-3">Jenis Kelamin</th>
                        <th class="px-4 py-3">No. HP</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm">
                    @forelse($data as $item)
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-4 text-center">{{ $loop->iteration }}</td>
                        <td class="px-4 py-4 text-center">
                            <button type="button"
                                    class="inline-flex"
                                    onclick="openImagePreview('{{ asset('storage/'.$item->foto) }}')"
                                    aria-label="Perbesar foto {{ $item->nama }}">
                                <img src="{{ asset('storage/'.$item->foto) }}"
                                     class="w-12 h-12 rounded object-cover mx-auto cursor-pointer transition duration-200 hover:scale-105"
                                     alt="Foto {{ $item->nama }}"
                                     title="Klik untuk perbesar">
                            </button>
                        </td>
                        <td class="px-4 py-4 font-semibold">{{ $item->nama }}</td>
                        <td class="px-4 py-4">{{ $item->jabatan }}</td>
                        <td class="px-4 py-4">{{ $item->jenis_kelamin }}</td>
                        <td class="px-4 py-4">{{ $item->no_hp }}</td>
                        <td class="px-4 py-4 text-center">
                            <div class="flex justify-center gap-1">
                                <!-- Tombol Lihat Detail -->
                                <a href="{{ route('pengasuh.show', $item->id) }}"
                                    class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-blue-500 bg-sky-100 text-blue-600 transition hover:bg-blue-500 hover:text-white"
                                    title="Lihat Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                </a>
                                <!-- Tombol Edit -->
                                <a href="{{ route('pengasuh.edit', $item->id) }}"
                                    class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-amber-500 bg-yellow-100 text-amber-700 transition hover:bg-amber-500 hover:text-white"
                                    title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                </a>
                                <!-- Tombol Hapus -->
                                <button
                                    onclick="openDeleteModal({{ $item->id }})"
                                    class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-red-500 bg-red-100 text-red-700 transition hover:bg-red-500 hover:text-white"
                                    title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-500">Belum ada data pengasuh</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="border-t p-4 flex justify-end">
            {{ $data->links() }}
        </div>
    </div>
</div>

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

<div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 px-4">
    <div class="w-full max-w-md rounded-3xl bg-white p-6 shadow-xl" onclick="event.stopPropagation()">
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Konfirmasi Hapus</p>
                <h3 class="mt-2 text-lg font-bold text-slate-900">Hapus data pengasuh?</h3>
            </div>
            <button type="button" class="rounded-full p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-900" onclick="closeDeleteModal()" aria-label="Tutup modal hapus">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <p class="mt-4 text-sm text-slate-600">Tindakan ini tidak dapat dibatalkan. Pastikan data pengasuh sudah tidak diperlukan lagi.</p>

        <form id="deleteForm" method="POST" class="mt-5 flex justify-end gap-3">
            @csrf
            @method('DELETE')
            <button type="button" class="rounded-2xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50" onclick="closeDeleteModal()">Batal</button>
            <button type="submit" class="rounded-2xl bg-red-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-red-700">Hapus</button>
        </form>
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
    document.getElementById('deleteModal').classList.add('flex');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.getElementById('deleteModal').classList.remove('flex');
}

imagePreviewModal.addEventListener('click', function (event) {
    if (event.target === imagePreviewModal) {
        closeImagePreview();
    }
});
</script>
@endsection