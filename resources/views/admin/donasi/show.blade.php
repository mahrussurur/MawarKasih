@extends('admin.layouts.app')
@section('page-title', 'Detail Donasi')

@section('content')
<div class="min-h-screen bg-slate-100 py-8">
    <div class="mx-auto max-w-4xl rounded-[28px] bg-white p-8 shadow-sm border border-slate-200">
        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-200 pb-5">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Detail Donasi</p>
                <h1 class="mt-2 text-2xl font-bold text-slate-900">{{ $donasi->kode_donasi }}</h1>
            </div>
            <a href="{{ route('donasi.index') }}" class="inline-flex items-center rounded-2xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                Kembali ke daftar
            </a>
        </div>

        <div class="mt-6 grid gap-5 lg:grid-cols-2">
            <div class="rounded-2xl bg-slate-50 p-4">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Nama Donatur</p>
                <p class="mt-2 text-base font-semibold text-slate-900">{{ $donasi->nama_donatur }}</p>
            </div>
            <div class="rounded-2xl bg-slate-50 p-4">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Sumber</p>
                <p class="mt-2 text-base font-semibold text-slate-900">{{ $donasi->donatur_id ? 'Donatur Tetap' : 'Guest' }}</p>
            </div>
            <div class="rounded-2xl bg-slate-50 p-4">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Nomor HP</p>
                <p class="mt-2 text-base font-semibold text-slate-900">{{ $donasi->no_hp ?? '-' }}</p>
            </div>
            <div class="rounded-2xl bg-slate-50 p-4">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Nominal</p>
                <p class="mt-2 text-base font-semibold text-slate-900">{{ $donasi->nominal_rupiah }}</p>
            </div>
            <div class="rounded-2xl bg-slate-50 p-4">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Tanggal</p>
                <p class="mt-2 text-base font-semibold text-slate-900">{{ \Carbon\Carbon::parse($donasi->tanggal)->format('d - m - Y') }}</p>
            </div>
            <div class="rounded-2xl bg-slate-50 p-4">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Status</p>
                <p class="mt-2">
                    <span class="inline-flex items-center rounded-full px-3 py-1 text-[11px] font-semibold {{ $donasi->status === 'pending' ? 'bg-amber-100 text-amber-800' : ($donasi->status === 'valid' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800') }}">
                        {{ ucfirst($donasi->status) }}
                    </span>
                </p>
            </div>
            <div class="rounded-2xl bg-slate-50 p-4 lg:col-span-2">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Keterangan</p>
                <p class="mt-2 text-sm leading-7 text-slate-700">{{ $donasi->keterangan ?? '-' }}</p>
            </div>
            <div class="rounded-2xl bg-slate-50 p-4 lg:col-span-2">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Catatan Admin</p>
                <p class="mt-2 text-sm leading-7 text-slate-700">{{ $donasi->catatan_admin ?? '-' }}</p>
            </div>
        </div>

        @if($donasi->bukti_transfer)
            <div class="mt-6 rounded-2xl border border-slate-200 p-4">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Bukti Transfer</p>
                <div class="mt-4">
                    <button type="button"
                            class="inline-flex"
                            onclick="openImagePreview('{{ Storage::url($donasi->bukti_transfer) }}')"
                            aria-label="Perbesar bukti transfer {{ $donasi->kode_donasi }}">
                        <img src="{{ Storage::url($donasi->bukti_transfer) }}"
                             alt="Bukti transfer {{ $donasi->kode_donasi }}"
                             class="h-48 w-48 rounded-lg border-2 border-gray-200 object-cover cursor-pointer transition duration-200 hover:scale-105">
                    </button>
                </div>
            </div>
        @endif

        <div class="mt-6 flex flex-wrap gap-3">
            <a href="{{ route('donasi.index') }}" class="rounded-2xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Kembali</a>
            <a href="{{ route('donasi.edit', $donasi->id) }}" class="rounded-2xl bg-amber-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-amber-600">Edit</a>
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
