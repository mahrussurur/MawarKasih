@extends('layouts.app')
@section('page-title', 'Data Donasi')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Main Content Card -->
    <div class="overflow-hidden rounded-2xl bg-white shadow-sm border border-gray-200">
        
        <!-- Header / Banner Cover -->
        <div class="relative bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-6 sm:px-8 sm:py-7">
            <div class="flex flex-row items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-white sm:text-2xl">Detail Donasi</h2>
                    <p class="text-sm text-blue-100 mt-0.5">Informasi lengkap transaksi donasi dan verifikasi bukti transfer.</p>
                </div>
                <!-- Tombol Kembali -->
                <a href="{{ route('donasi.index') }}" 
                   class="inline-flex items-center gap-2 rounded-xl bg-white/20 backdrop-blur-sm border border-white/30 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-white/30 transition flex-shrink-0" 
                   title="Kembali">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span class="hidden sm:inline">Kembali</span>
                </a>
            </div>
        </div>

        <!-- Layout Grid Content -->
        <div class="grid grid-cols-1 divide-y divide-gray-100 lg:grid-cols-3 lg:divide-x lg:divide-y-0">
            
            <!-- Left Column: Detail Transaksi & Bukti -->
            <div class="p-6 sm:p-8 lg:col-span-2 space-y-8">
                
                <!-- Rincian Donasi -->
                <section>
                    <h3 class="flex items-center text-base font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Rincian Transaksi
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Donatur</p>
                            <p class="mt-1 text-sm font-bold text-gray-900">{{ $donasi->nama_donatur }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor HP / WhatsApp</p>
                            <p class="mt-1 text-sm font-semibold text-gray-800">{{ $donasi->no_hp ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Nominal Donasi</p>
                            <p class="mt-1 text-base font-extrabold text-emerald-600">{{ $donasi->nominal_rupiah }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Metode Pembayaran</p>
                            <p class="mt-1 text-sm font-semibold text-gray-800">{{ ucfirst($donasi->metode_pembayaran) ?? '-' }}</p>
                        </div>
                    </div>
                </section>

                <!-- Keterangan & Catatan -->
                <section>
                    <h3 class="flex items-center text-base font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                        </svg>
                        Keterangan & Catatan
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Keterangan Donatur</p>
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 text-sm text-gray-800 leading-relaxed break-words">
                                {{ $donasi->keterangan ?? 'Tidak ada keterangan dari donatur.' }}
                            </div>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Catatan Admin</p>
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 text-sm text-gray-800 leading-relaxed break-words">
                                {{ $donasi->catatan_admin ?? 'Belum ada catatan dari admin.' }}
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Bukti Transfer -->
                <section>
                    <h3 class="flex items-center text-base font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Bukti Transfer
                    </h3>
                    @if($donasi->bukti_transfer)
                        <div class="relative group w-full aspect-video overflow-hidden rounded-xl border border-gray-200 bg-gray-100 shadow-sm flex items-center justify-center p-2">
                            <img src="{{ Storage::url($donasi->bukti_transfer) }}" 
                                 alt="Bukti transfer {{ $donasi->kode_donasi }}"
                                 class="h-full w-full object-contain cursor-pointer"
                                 onclick="openImagePreview('{{ Storage::url($donasi->bukti_transfer) }}')"
                                 title="Klik untuk memperbesar">
                        </div>
                    @else
                        <div class="rounded-xl border border-dashed border-gray-200 bg-gray-50 p-6 text-center text-sm text-gray-400">
                            Tidak ada bukti transfer yang diunggah.
                        </div>
                    @endif
                </section>

            </div>

            <!-- Right Column: Info Status & Tombol Aksi -->
            <div class="bg-gray-50/50 p-6 sm:p-8 space-y-8">
                
                <section>
                    <h3 class="flex items-center text-base font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Informasi Status
                    </h3>
                    
                    <div class="space-y-5">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Donasi</p>
                            <p class="mt-1 text-sm font-mono font-bold text-gray-900 leading-snug">{{ $donasi->kode_donasi }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe Donatur</p>
                            <p class="mt-1.5">
                                <span class="inline-flex items-center rounded-lg border px-2.5 py-1 text-xs font-semibold {{ $donasi->donatur_id ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : 'bg-slate-100 text-slate-700 border-slate-200' }}">
                                    {{ $donasi->donatur_id ? 'Donatur Tetap' : 'Donatur Umum' }}
                                </span>
                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Status Transaksi</p>
                            <p class="mt-1.5">
                                <span class="inline-flex items-center rounded-lg border px-2.5 py-1 text-xs font-semibold {{ $donasi->status === 'pending' ? 'bg-amber-50 text-amber-800 border-amber-200' : ($donasi->status === 'diterima' ? 'bg-emerald-50 text-emerald-800 border-emerald-200' : 'bg-red-50 text-red-800 border-red-200') }}">
                                    {{ ucfirst($donasi->status) }}
                                </span>
                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Donasi</p>
                            <p class="mt-1.5">
                                <span class="inline-flex items-center gap-1.5 rounded-lg bg-blue-50 border border-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ \Carbon\Carbon::parse($donasi->tanggal)->format('d - m - Y') }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="pt-8 mt-8 border-t border-gray-200 space-y-3">
                        @if($donasi->status === 'pending')
                            <button type="button" 
                                    class="w-full inline-flex items-center justify-center gap-2 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-2.5 text-sm font-semibold text-emerald-600 shadow-sm transition hover:bg-emerald-600 hover:text-white"
                                    data-validasi-route="{{ route('donasi.validasi', $donasi->id) }}"
                                    data-kode-donasi="{{ $donasi->kode_donasi }}"
                                    onclick="openValidasiModal(this)">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Terima Donasi
                            </button>
                            <button type="button" 
                                    class="w-full inline-flex items-center justify-center gap-2 rounded-xl border border-red-200 bg-red-50 px-4 py-2.5 text-sm font-semibold text-red-600 shadow-sm transition hover:bg-red-600 hover:text-white"
                                    data-tolak-route="{{ route('donasi.tolak', $donasi->id) }}"
                                    data-kode-donasi="{{ $donasi->kode_donasi }}"
                                    onclick="openTolakModal(this)">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                Tolak Donasi
                            </button>
                        @else
                            <a href="{{ route('donasi.edit', $donasi->id) }}" 
                               class="w-full inline-flex items-center justify-center gap-2 rounded-xl border border-amber-200 bg-amber-50 px-4 py-2.5 text-sm font-semibold text-amber-600 shadow-sm transition hover:bg-amber-500 hover:text-white">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit Donasi
                            </a>
                            <button type="button"
                                    class="w-full inline-flex items-center justify-center gap-2 rounded-xl border border-red-200 bg-red-50 px-4 py-2.5 text-sm font-semibold text-red-600 shadow-sm transition hover:bg-red-600 hover:text-white"
                                    data-delete-route="{{ route('donasi.destroy', $donasi->id) }}"
                                    data-name="{{ $donasi->kode_donasi }}"
                                    onclick="openDeleteModal(this)">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Hapus Donasi
                            </button>
                        @endif
                    </div>
                </section>

            </div>

        </div>
    </div>
</div>

@push('modals')
<div id="validasiModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/50 backdrop-blur-sm px-4 opacity-0 invisible transition-all duration-300">
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

<div id="tolakModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/50 backdrop-blur-sm px-4 opacity-0 invisible transition-all duration-300">
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
        validasiModal.classList.remove('opacity-0', 'invisible');
        validasiModal.classList.add('opacity-100', 'visible');
    }

    function closeValidasiModal() {
        validasiModal.classList.add('opacity-0', 'invisible');
        validasiModal.classList.remove('opacity-100', 'visible');
    }

    function openTolakModal(button) {
        const route = button.dataset.tolakRoute;
        const kode = button.dataset.kodeDonasi;

        tolakForm.action = route;
        document.getElementById('tolakModalKode').textContent = kode;
        tolakModal.classList.remove('opacity-0', 'invisible');
        tolakModal.classList.add('opacity-100', 'visible');
    }

    function closeTolakModal() {
        tolakModal.classList.add('opacity-0', 'invisible');
        tolakModal.classList.remove('opacity-100', 'visible');
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
@endpush
@endsection 