@extends('admin.layouts.app')
@section('page-title', 'Data Donasi')
@section('title', 'Data Donasi | Panti Asuhan Mawar Kasih')

@section('content')
<div class="px-8 pt-4 bg-gray-100 min-h-screen">

    <!-- Summary Cards -->
    <div class="grid gap-4 xl:grid-cols-4 mb-4">
        <div class="flex items-center gap-4 rounded-3xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-100 text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M3.75 5.25h16.5a1.5 1.5 0 011.5 1.5v10.5a1.5 1.5 0 01-1.5 1.5H3.75a1.5 1.5 0 01-1.5-1.5V6.75a1.5 1.5 0 011.5-1.5z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 14.25h2.25" />
                </svg>
            </div>

            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                    Total Donasi
                </p>
                <p class="text-lg font-bold text-slate-900">
                    Rp {{ number_format($totalNominal, 0, ',', '.') }}
                </p>
            </div>
        </div>
    </div>

    <!-- Toolbar -->
    <div class="flex justify-between mb-4">
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('donasi.create') }}" class="inline-flex items-center gap-2 rounded-full bg-blue-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Donasi
            </a>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('donasi.cetak') }}" target="_blank" class="inline-flex items-center gap-2 rounded-full border border-gray-200 bg-white px-4 py-3 text-sm font-semibold shadow-sm transition hover:border-gray-300 hover:bg-gray-100">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak Laporan
            </a>
        </div>
    </div>

    <!-- Kotak Utama Konten -->
    <div class="bg-white rounded-[28px] shadow-sm border border-gray-100 p-6 mb-4">

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
                <a href="{{ route('donasi.index', array_merge(request()->except('status','page'), ['status'=>'diterima'])) }}"
                   class="inline-flex items-center gap-2 rounded-full border px-4 py-2 text-[11px] font-semibold transition {{ $activeStatus === 'diterima' ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-emerald-100 text-emerald-800 border-emerald-100 hover:bg-emerald-200' }}">
                    Diterima
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
                           class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent text-sm" />
                </label>
            </form>
        </div>

        <!-- Table data -->
        @if($donasi->count() > 0)
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full min-w-[1600px] text-left divide-y divide-gray-200 text-sm border-b border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 font-semibold text-gray-700 text-center w-12">No</th>
                        <th class="px-6 py-4 font-semibold text-gray-700 w-40">Kode Donasi</th>
                        <th class="px-6 py-4 font-semibold text-gray-700 w-40">Nama Donatur</th>
                        <th class="px-6 py-4 font-semibold text-gray-700 w-40">Sumber Donatur</th>
                        <th class="px-6 py-4 font-semibold text-gray-700 w-40">No. HP</th>
                        <th class="px-6 py-4 font-semibold text-gray-700 w-40">Tanggal</th>
                        <th class="px-6 py-4 font-semibold text-gray-700 w-40">Keterangan</th>
                        <th class="px-6 py-4 font-semibold text-gray-700 w-40">Nominal</th>
                        <th class="px-6 py-4 font-semibold text-gray-700 w-40">Metode Pembayaran</th>
                        <th class="px-6 py-4 font-semibold text-gray-700 text-center">Bukti</th>
                        <th class="px-6 py-4 font-semibold text-gray-700 text-center">Status</th>
                        <th class="px-6 py-4 font-semibold text-gray-700 text-center sticky right-0 bg-gray-50 z-10 shadow-[inset_1px_0_0_#e5e7eb]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($donasi as $index => $item)
                    <tr class="hover:bg-gray-50 transition-colors group">
                        <td class="px-6 py-4 text-center text-gray-700">{{ $donasi->firstItem() + $index }}</td>
                        <td class="px-6 py-4 font-semibold text-gray-900">{{ $item->kode_donasi }}</td>
                        <td class="px-6 py-4 font-semibold text-gray-900 max-w-4">
                            <span class="line-clamp-2 break-words">{{ $item->nama_donatur ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4 text-gray-700">
                            @if($item->donatur_id)
                                <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-[11px] font-semibold text-emerald-800">Tetap</span>
                                <!-- <div class="mt-1 text-[11px] text-gray-500">ID: {{ $item->donatur_id }}</div> -->
                            @else
                                <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-[11px] font-semibold text-slate-700">Umum</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-700">{{ $item->no_hp ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ \Carbon\Carbon::parse($item->tanggal)->format('d - m - Y') }}</td>
                        <td class="px-6 py-4 text-gray-700 max-w-4">
                            <span class="line-clamp-2 break-words">{{ $item->keterangan ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-900">{{ $item->nominal_rupiah }}</td>
                        <td class="px-6 py-4 text-gray-700">
                            {{ ucfirst($item->jenis_donasi) ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-center">
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
                                <span class="text-slate-400 font-medium">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-amber-100 text-amber-800',
                                    'diterima' => 'bg-emerald-100 text-emerald-800',
                                    'ditolak' => 'bg-red-100 text-red-800',
                                ];
                            @endphp
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-[11px] font-semibold {{ $statusClasses[$item->status] ?? 'bg-slate-100 text-slate-700' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center sticky right-0 bg-white group-hover:bg-gray-50 z-10 transition-colors shadow-[inset_1px_0_0_#e5e7eb]">
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
                                    <button type="button"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700 transition hover:bg-emerald-600 hover:text-white"
                                            title="Validasi"
                                            data-validasi-route="{{ route('donasi.validasi', $item->id) }}"
                                            data-kode-donasi="{{ $item->kode_donasi }}"
                                            onclick="openValidasiModal(this)">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </button>
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
                                            data-name="{{ $item->kode_donasi }}"
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

        <!-- Pagination -->
        @if($donasi->hasPages())
        <div class="flex flex-wrap items-center justify-end gap-1 mt-4">
            <a href="{{ $donasi->previousPageUrl() ?? '#' }}" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-gray-200 bg-white text-gray-600 transition hover:border-gray-300 hover:text-gray-900 {{ $donasi->onFirstPage() ? 'opacity-40 pointer-events-none' : '' }}">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </a>

            @foreach($donasi->getUrlRange(1, $donasi->lastPage()) as $page => $url)
                <a href="{{ $url }}" class="inline-flex h-9 min-w-[2.25rem] items-center justify-center rounded-xl border px-3 text-sm font-semibold transition {{ $page == $donasi->currentPage() ? 'border-blue-500 bg-blue-500 text-white' : 'border-gray-200 bg-white text-gray-700 hover:border-gray-300' }}">
                    {{ $page }}
                </a>
            @endforeach

            <a href="{{ $donasi->nextPageUrl() ?? '#' }}" class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-gray-200 bg-white text-gray-600 transition hover:border-gray-300 hover:text-gray-900 {{ !$donasi->hasMorePages() ? 'opacity-40 pointer-events-none' : '' }}">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        @endif

        @else
        <div class="flex min-h-[300px] flex-col items-center justify-center gap-3 px-6 py-10 text-center text-gray-500">
            <p class="text-base font-semibold text-gray-900">Belum ada data donasi</p>
            <span class="text-sm text-gray-500">{{ request('search') ? 'Coba kata kunci lain' : 'Tambahkan donasi pertama' }}</span>
        </div>
        @endif

    </div>
</div>


    <div id="validasiModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 px-4">
        <div class="w-full max-w-lg rounded-3xl bg-white p-6 shadow-xl" onclick="event.stopPropagation()">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Validasi Donasi</p>
                    <h3 class="mt-2 text-lg font-bold text-slate-900">Kode: <span id="validasiModalKode"></span></h3>
                </div>
                <button type="button" class="rounded-full p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-900" onclick="closeValidasiModal()" aria-label="Tutup modal validasi">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <p class="mt-4 text-sm text-slate-600">Masukkan catatan admin untuk donasi yang diterima.</p>

            <form id="validasiForm" method="POST" class="mt-5 space-y-4">
                @csrf
                @method('PATCH')
                <div>
                    <label for="catatan_admin_validasi" class="text-sm font-semibold text-slate-700">Catatan Admin</label>
                    <textarea id="catatan_admin_validasi" name="catatan_admin" rows="4" placeholder="Contoh: Donasi telah diterima, terima kasih."
                              class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100"></textarea>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" class="rounded-2xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50" onclick="closeValidasiModal()">Batal</button>
                    <button type="submit" class="rounded-2xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-700">Validasi Donasi</button>
                </div>
            </form>
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

            <p class="mt-4 text-sm text-slate-600">Masukkan catatan admin jika perlu, untuk donasi yang akan ditolak.</p>

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

    <script>
        const validasiModal = document.getElementById('validasiModal');
        const tolakModal = document.getElementById('tolakModal');
        const validasiForm = document.getElementById('validasiForm');
        const tolakForm = document.getElementById('tolakForm');

        function openValidasiModal(button) {
            const route = button.dataset.validasiRoute;
            const kode = button.dataset.kodeDonasi;

            validasiForm.action = route;
            document.getElementById('validasiModalKode').textContent = kode;
            validasiModal.classList.remove('hidden');
            validasiModal.classList.add('flex');
        }

        function closeValidasiModal() {
            validasiModal.classList.add('hidden');
            validasiModal.classList.remove('flex');
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

        validasiModal.addEventListener('click', function (event) {
            if (event.target === validasiModal) {
                closeValidasiModal();
            }
        });

        tolakModal.addEventListener('click', function (event) {
            if (event.target === tolakModal) {
                closeTolakModal();
            }
        });
    </script>
    
    @include('admin.partials.modals')
    
@endsection
