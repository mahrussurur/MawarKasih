@extends('admin.layouts.app')
@section('page-title', 'Detail Donasi')

@section('content')
<div class="p-4 md:p-6 bg-gray-100 min-h-screen">

    <!-- Container lebih sempit: max-w-3xl (768px) -->
    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow overflow-hidden">
        
        <!-- Header -->
        <div class="p-2 md:p-4 border-b border-gray-200 flex justify-between items-center gap-4 bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex justify-between items-center">
            <div class="min-w-0">
                <h2 class="text-lg font-bold text-white truncate">Detail Donasi</h2>
                <p class="text-xs md:text-sm text-gray-300">Informasi lengkap donasi.</p>
            </div>
            <a href="{{ route('donasi.index') }}" class="text-xs md:text-sm font-semibold text-white hover:text-gray-400 flex items-center transition-colors whitespace-nowrap">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="hidden sm:inline">Kembali</span>
            </a>
        </div>

        <div class="p-4 md:p-6">
            <!-- Layout: Foto di atas -->
            <div class="flex flex-col gap-6 items-center">
                
                <!-- Section -->
                <div class="flex flex-col items-center gap-3 flex-shrink-0">
                    <div class="text-center">
                        <span class="text-base md:text-lg font-bold text-gray-900 block text-center whitespace-normal break-words max-w-full md:max-w-none px-2">
                            {{ $donasi->kode_donasi }}
                        </span><br>
                        <span class="inline-block mt-1 px-3 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-800 
                        {{ $donasi->donatur_id ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-700' }}">
                            {{ $donasi->donatur_id ? 'Donatur Tetap' : 'Donatur Umum' }}
                        </span>
                    </div>
                </div>

                <div class="border-t border-gray-200 my-1 w-full"></div>

                <!-- Detail Section -->
                <div class="w-full space-y-2.5">

                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-28 flex-shrink-0">Nama Donatur</span>
                            <span class="text-gray-400">:</span>
                            <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">{{ $donasi->nama_donatur }}</span>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-28 flex-shrink-0">Nomor HP</span>
                            <span class="text-gray-400">:</span>
                            <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">{{ $donasi->no_hp ?? '-' }}</span>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-28 flex-shrink-0">Nominal</span>
                            <span class="text-gray-400">:</span>
                            <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">{{ $donasi->nominal_rupiah }}</span>
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-28 flex-shrink-0">Tanggal</span>
                            <span class="text-gray-400">:</span>
                            <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">{{ \Carbon\Carbon::parse($donasi->tanggal)->format('d - m - Y') }}</span>
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-28 flex-shrink-0">Status</span>
                            <span class="text-gray-400">:</span>
                            <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">
                                <span class="inline-flex items-center rounded-full px-3 py-1 text-[11px] font-semibold {{ $donasi->status === 'pending' ? 'bg-amber-100 text-amber-800' : ($donasi->status === 'valid' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($donasi->status) }}
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-28 flex-shrink-0">Keterangan</span>
                            <span class="text-gray-400">:</span>
                            <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">{{ $donasi->keterangan ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-28 flex-shrink-0">Catatan Admin</span>
                            <span class="text-gray-400">:</span>
                            <span class="text-sm text-gray-900 font-medium break-words whitespace-normal overflow-hidden">{{ $donasi->catatan_admin ?? '-' }}</span>
                        </div>
                    </div>
                    
                    
                    <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-600 w-28 flex-shrink-0">Bukti Transfer</span>
                            <span class="text-gray-400">:</span>
                            @if($donasi->bukti_transfer)
                                <div class="mt-1">
                                    <button type="button"
                                        class="inline-flex"
                                        onclick="openImagePreview('{{ Storage::url($donasi->bukti_transfer) }}')"
                                        aria-label="Perbesar bukti transfer {{ $donasi->kode_donasi }}">
                                        <img src="{{ Storage::url($donasi->bukti_transfer) }}"
                                            alt="Bukti transfer {{ $donasi->kode_donasi }}"
                                            class="h-32 w-32 rounded-lg border-2 border-gray-200 object-cover cursor-pointer transition duration-200 hover:scale-105">
                                    </button>
                                </div>
                            @else
                                <span class="text-sm text-gray-500 font-medium">-</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Tombol Aksi -->
            <div class="mt-6 pt-4 border-t border-gray-200 flex flex-wrap gap-3 justify-center">
                <a href="{{ route('donasi.edit', $donasi->id) }}" 
                class="rounded-2xl bg-orange-500 px-5 py-2 text-sm font-semibold text-white border border-orange-600  transition hover:bg-orange-600">
                    Edit
                </a>
                <button onclick="openDeleteModal({{ $donasi->id }})" 
                class="rounded-2xl bg-red-600 px-5 py-2 text-sm font-semibold text-white border border-red-700  transition hover:bg-red-700">
                    Hapus
                </button>
            </div>

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
        <img id="imagePreview" src="" alt="Preview bukti transfer" class="max-h-[90vh] max-w-[90vw] rounded-2xl border border-white/70 bg-white object-contain shadow-2xl">
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

    imagePreviewModal.addEventListener('click', function (event) {
        if (event.target === imagePreviewModal) {
            closeImagePreview();
        }
    });
</script>
@endsection
