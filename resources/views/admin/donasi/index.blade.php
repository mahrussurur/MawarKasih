@extends('admin.layouts.app')
@section('page-title', 'Data Donasi')

@section('content')

    {{-- ── Summary Cards ── --}}
    <div class="grid gap-4 xl:grid-cols-4 mb-6">
        <div class="flex items-center gap-4 rounded-3xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-sky-100 text-xl">💰</div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Total Valid</p>
                <p class="text-lg font-bold text-slate-900">Rp {{ number_format($totalNominal, 0, ',', '.') }}</p>
            </div>
        </div>
        <!-- <div class="flex items-center gap-4 rounded-3xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-100 text-xl">⏳</div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Pending</p>
                <p class="text-lg font-bold text-slate-900">{{ $totalPending }}</p>
            </div>
        </div>
        <div class="flex items-center gap-4 rounded-3xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-100 text-xl">✅</div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Tervalidasi</p>
                <p class="text-lg font-bold text-slate-900">{{ $totalValid }}</p>
            </div>
        </div>
        <div class="flex items-center gap-4 rounded-3xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-red-100 text-xl">❌</div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Ditolak</p>
                <p class="text-lg font-bold text-slate-900">{{ $totalDitolak }}</p>
            </div>
        </div> -->
    </div>

    <!-- Toolbar -->
    <div class="mb-6 flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('donasi.create') }}" class="inline-flex items-center gap-2 rounded-2xl bg-blue-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-600">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Donasi
            </a>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('donasi.cetak') }}" target="_blank" class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak Laporan
            </a>
        </div>
    </div>

    <!-- Kotak Utama Konten -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">

        <!-- Filter Bar -->
        <div class="flex flex-col gap-4 border-b border-slate-200 py-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex flex-wrap gap-2">
                @php $activeStatus = request('status', 'semua'); @endphp

                <a href="{{ route('donasi.index', array_merge(request()->except('status','page'), ['status'=>'semua'])) }}"
                   class="inline-flex items-center gap-2 rounded-full border px-4 py-2 text-[11px] font-semibold transition {{ $activeStatus === 'semua' ? 'bg-slate-900 text-white border-slate-900' : 'bg-slate-100 text-slate-600 border-slate-200 hover:bg-slate-200' }}">
                    Semua
                    <span class="rounded-full bg-white px-2 py-0.5 text-[10px] font-bold text-slate-600 shadow-sm">{{ $totalDonasi }}</span>
                </a>
                <a href="{{ route('donasi.index', array_merge(request()->except('status','page'), ['status'=>'pending'])) }}"
                   class="inline-flex items-center gap-2 rounded-full border px-4 py-2 text-[11px] font-semibold transition {{ $activeStatus === 'pending' ? 'bg-amber-600 text-white border-amber-600' : 'bg-amber-100 text-amber-800 border-amber-100 hover:bg-amber-200' }}">
                    Pending
                    <span class="rounded-full bg-white px-2 py-0.5 text-[10px] font-bold text-slate-600 shadow-sm">{{ $totalPending }}</span>
                </a>
                <a href="{{ route('donasi.index', array_merge(request()->except('status','page'), ['status'=>'valid'])) }}"
                   class="inline-flex items-center gap-2 rounded-full border px-4 py-2 text-[11px] font-semibold transition {{ $activeStatus === 'valid' ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-emerald-100 text-emerald-800 border-emerald-100 hover:bg-emerald-200' }}">
                    Valid
                    <span class="rounded-full bg-white px-2 py-0.5 text-[10px] font-bold text-slate-600 shadow-sm">{{ $totalValid }}</span>
                </a>
                <a href="{{ route('donasi.index', array_merge(request()->except('status','page'), ['status'=>'ditolak'])) }}"
                   class="inline-flex items-center gap-2 rounded-full border px-4 py-2 text-[11px] font-semibold transition {{ $activeStatus === 'ditolak' ? 'bg-red-600 text-white border-red-600' : 'bg-red-100 text-red-800 border-red-100 hover:bg-red-200' }}">
                    Ditolak
                    <span class="rounded-full bg-white px-2 py-0.5 text-[10px] font-bold text-slate-600 shadow-sm">{{ $totalDitolak }}</span>
                </a>
            </div>

            <!-- Search -->
            <form method="GET" action="{{ route('donasi.index') }}" class="flex w-full items-center gap-3 lg:w-auto">
                <input type="hidden" name="status" value="{{ $activeStatus }}">
                <label class="relative block w-full lg:w-[260px]">
                    <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-slate-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / kode..."
                           class="w-full rounded-2xl border border-slate-200 bg-slate-50 py-2.5 pl-11 pr-4 text-sm text-slate-700 outline-none transition focus:border-sky-400 focus:bg-white focus:ring-2 focus:ring-sky-100" />
                </label>
            </form>
        </div>

        <!-- Table data -->
        @if($donasi->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-sm font-semibold border-b border-gray-200">
                        <th class="px-4 py-3 text-center w-12">No</th>
                        <th class="px-4 py-3">Kode Donasi</th>
                        <th class="px-4 py-3">Nama Donatur</th>
                        <th class="px-4 py-3">Sumber Donatur</th>
                        <th class="px-4 py-3">No. HP</th>
                        <th class="px-4 py-3">Nominal</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Keterangan</th>
                        <th class="px-4 py-3 text-center">Bukti</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm">
                    @foreach($donasi as $index => $item)
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-4 text-center text-sm">{{ $donasi->firstItem() + $index }}</td>
                        <td class="px-4 py-4 text-sm font-semibold">{{ $item->kode_donasi }}</td>
                        <td class="px-4 py-4 text-sm font-semibold max-w-4">
                            <span class="line-clamp-2 break-words">{{ $item->nama_donatur ?? '-' }}</span>
                        </td>
                        <td class="px-4 py-4 text-sm">
                            @if($item->donatur_id)
                                <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-[11px] font-semibold text-emerald-800">Tetap</span>
                                <!-- <div class="mt-1 text-[11px] text-slate-500">ID: {{ $item->donatur_id }}</div> -->
                            @else
                                <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-[11px] font-semibold text-slate-700">Guest</span>
                            @endif
                        </td>
                        <td class="px-4 py-4 text-sm ">{{ $item->no_hp ?? '-' }}</td>
                        <td class="px-4 py-4 text-sm font-semibold">{{ $item->nominal_rupiah }}</td>
                        <td class="px-4 py-4 text-sm ">{{ \Carbon\Carbon::parse($item->tanggal)->format('d - m - Y') }}</td>
                        <td class="px-4 py-4 text-sm max-w-4">
                            <span class="line-clamp-2 break-words">{{ $item->keterangan ?? '-' }}</span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            @if($item->bukti_transfer)
                                <button type="button"
                                        class="inline-flex"
                                        onclick="openImagePreview('{{ Storage::url($item->bukti_transfer) }}')"
                                        aria-label="Perbesar bukti transfer {{ $item->kode_donasi }}">
                                    <img src="{{ Storage::url($item->bukti_transfer) }}"
                                         class="h-12 w-12 rounded border border-slate-200 object-cover transition duration-200 hover:scale-105 cursor-pointer"
                                         alt="Bukti transfer {{ $item->kode_donasi }}"
                                         title="Klik untuk perbesar">
                                </button>
                            @else
                                <div class="flex h-12 w-12 items-center justify-center rounded-xl border border-slate-200 bg-slate-100 text-slate-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-4 text-center">
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-amber-100 text-amber-800',
                                    'valid' => 'bg-emerald-100 text-emerald-800',
                                    'ditolak' => 'bg-red-100 text-red-800',
                                ];
                            @endphp
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-[11px] font-semibold {{ $statusClasses[$item->status] ?? 'bg-slate-100 text-slate-700' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <div class="flex justify-center gap-1">
                                <!-- Tombol Lihat Detail -->
                                <a href="{{ route('donasi.show', $item->id) }}"
                                   class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-blue-500 bg-sky-100 text-blue-600 transition hover:bg-blue-500 hover:text-white"
                                   title="Lihat Detail">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>

                                @if($item->status === 'pending')
                                    <form method="POST" action="{{ route('donasi.validasi', $item->id) }}" class="inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700 transition hover:bg-emerald-600 hover:text-white" title="Validasi" onclick="return confirm('Validasi donasi {{ $item->kode_donasi }}?')">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </button>
                                    </form>
                                    <button type="button"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-red-100 text-red-700 transition hover:bg-red-600 hover:text-white"
                                            title="Tolak"
                                            data-tolak-route="{{ route('donasi.tolak', $item->id) }}"
                                            data-kode-donasi="{{ $item->kode_donasi }}"
                                            onclick="openTolakModal(this)">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                @else
                                    <a href="{{ route('donasi.edit', $item->id) }}"
                                        class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-amber-500 bg-yellow-100 text-amber-700 transition hover:bg-amber-500 hover:text-white"
                                        title="Edit">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <button type="button"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-red-600 bg-red-100 text-red-700 transition hover:bg-red-600 hover:text-white"
                                            title="Hapus"
                                            data-delete-route="{{ route('donasi.destroy', $item->id) }}"
                                            data-kode-donasi="{{ $item->kode_donasi }}"
                                            onclick="openDeleteModal(this)">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($donasi->hasPages())
        <div class="flex flex-wrap items-center justify-end gap-2 border-t border-slate-200 px-5 py-4">
            <a href="{{ $donasi->previousPageUrl() ?? '#' }}" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 transition hover:border-slate-300 hover:text-slate-900 {{ $donasi->onFirstPage() ? 'opacity-40 pointer-events-none' : '' }}">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </a>

            @foreach($donasi->getUrlRange(1, $donasi->lastPage()) as $page => $url)
                <a href="{{ $url }}" class="inline-flex h-9 min-w-[2.25rem] items-center justify-center rounded-xl border px-3 text-sm font-semibold transition {{ $page == $donasi->currentPage() ? 'border-sky-600 bg-sky-600 text-white' : 'border-slate-200 bg-white text-slate-700 hover:border-slate-300' }}">
                    {{ $page }}
                </a>
            @endforeach

            <a href="{{ $donasi->nextPageUrl() ?? '#' }}" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 transition hover:border-slate-300 hover:text-slate-900 {{ !$donasi->hasMorePages() ? 'opacity-40 pointer-events-none' : '' }}">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        @endif

        @else
        <div class="flex min-h-[40px] flex-col items-center justify-center gap-3 px-6 py-10 text-center text-slate-500">
            <p class="text-base font-semibold text-slate-900">Belum ada data donasi</p>
            <span class="text-sm text-slate-500">{{ request('search') ? 'Coba kata kunci lain' : 'Tambahkan donasi pertama' }}</span>
        </div>
        @endif

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

    <div id="tolakModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 px-4">
        <div class="w-full max-w-lg rounded-3xl bg-white p-6 shadow-xl" onclick="event.stopPropagation()">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Tolak Donasi</p>
                    <h3 class="mt-2 text-lg font-bold text-slate-900">Kode: <span id="tolakModalKode"></span></h3>
                </div>
                <button type="button" class="rounded-full p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-900" onclick="closeTolakModal()" aria-label="Tutup modal tolak">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <p class="mt-4 text-sm text-slate-600">Masukkan alasan penolakan jika perlu, lalu simpan untuk mengubah status donasi menjadi ditolak.</p>

            <form id="tolakForm" method="POST" class="mt-5 space-y-4">
                @csrf
                @method('PATCH')
                <div>
                    <label for="catatan_admin" class="text-sm font-semibold text-slate-700">Catatan Admin</label>
                    <textarea id="catatan_admin" name="catatan_admin" rows="4" placeholder="Contoh: Bukti transfer tidak valid atau data tidak sesuai."
                              class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-rose-400 focus:ring-2 focus:ring-rose-100"></textarea>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" class="rounded-2xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50" onclick="closeTolakModal()">Batal</button>
                    <button type="submit" class="rounded-2xl bg-rose-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-rose-700">Tolak Donasi</button>
                </div>
            </form>
        </div>
    </div>

    <div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 px-4">
        <div class="w-full max-w-md rounded-3xl bg-white p-6 shadow-xl" onclick="event.stopPropagation()">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Konfirmasi Hapus</p>
                    <h3 class="mt-2 text-lg font-bold text-slate-900">Hapus donasi <span id="deleteModalKode"></span>?</h3>
                </div>
                <button type="button" class="rounded-full p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-900" onclick="closeDeleteModal()" aria-label="Tutup modal hapus">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <p class="mt-4 text-sm text-slate-600">Tindakan ini tidak dapat dibatalkan. Pastikan data donasi sudah tidak diperlukan lagi.</p>

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
        const tolakModal = document.getElementById('tolakModal');
        const deleteModal = document.getElementById('deleteModal');
        const tolakForm = document.getElementById('tolakForm');
        const deleteForm = document.getElementById('deleteForm');

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

        function openTolakModal(button) {
            const route = button.dataset.tolakRoute;
            const kode = button.dataset.kodeDonasi;

            tolakForm.action = route;
            document.getElementById('tolakModalKode').textContent = kode;
            tolakModal.classList.remove('hidden');
            tolakModal.classList.add('flex');
        }

        function closeTolakModal() {
            tolakModal.classList.add('hidden');
            tolakModal.classList.remove('flex');
        }

        function openDeleteModal(button) {
            const route = button.dataset.deleteRoute;
            const kode = button.dataset.kodeDonasi;

            deleteForm.action = route;
            document.getElementById('deleteModalKode').textContent = kode;
            deleteModal.classList.remove('hidden');
            deleteModal.classList.add('flex');
        }

        function closeDeleteModal() {
            deleteModal.classList.add('hidden');
            deleteModal.classList.remove('flex');
        }

        imagePreviewModal.addEventListener('click', function (event) {
            if (event.target === imagePreviewModal) {
                closeImagePreview();
            }
        });

        tolakModal.addEventListener('click', function (event) {
            if (event.target === tolakModal) {
                closeTolakModal();
            }
        });

        deleteModal.addEventListener('click', function (event) {
            if (event.target === deleteModal) {
                closeDeleteModal();
            }
        });
    </script>
    
@endsection