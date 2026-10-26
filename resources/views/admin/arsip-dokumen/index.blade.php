@extends('layouts.app')

@section('title', 'Arsip Dokumen Administrasi')
@section('page-title', 'Arsip Dokumen Administrasi')

@section('content')
<div>
    <!-- Summary Cards -->
    <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 mb-4">
        <!-- Total Semua Arsip -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Total Arsip Keseluruhan</p>
            <p class="text-xl font-bold text-gray-900 mt-1">{{ $totalArsip }}</p>
        </div>
        <!-- Total Legalitas -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wider text-blue-600">Legalitas &amp; Izin</p>
            <p class="text-xl font-bold text-gray-900 mt-1">{{ \App\Models\ArsipDokumen::where('kategori', 'Legalitas')->count() }}</p>
        </div>
        <!-- Total Surat Menyurat -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wider text-emerald-600">Surat Menyurat</p>
            <p class="text-xl font-bold text-gray-900 mt-1">{{ \App\Models\ArsipDokumen::whereIn('kategori', ['Surat Masuk', 'Surat Keluar'])->count() }}</p>
        </div>
        <!-- Total Notula & Lainnya -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wider text-violet-600">Notula &amp; Lainnya</p>
            <p class="text-xl font-bold text-gray-900 mt-1">{{ \App\Models\ArsipDokumen::whereIn('kategori', ['Notula Rapat', 'Lainnya'])->count() }}</p>
        </div>
    </div>

    <!-- Toolbar -->
    <div class="flex justify-between mb-4">
        <div class="flex flex-wrap items-center gap-3">
            <button type="button" onclick="document.getElementById('modalUpload').classList.remove('hidden')" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Dokumen Baru
            </button>
        </div>
    </div>

    <!-- Kotak Utama Konten -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6">

        <!-- Filter Bar -->
        <div class="flex flex-col gap-4 border-b border-gray-200 pb-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex flex-wrap items-center gap-2">
                @php $activeKategori = request('kategori', 'semua'); @endphp

                <a href="{{ route('admin.arsip-dokumen.index', array_merge(request()->except('kategori','page'), ['kategori'=>'semua'])) }}"
                class="inline-flex items-center gap-2 rounded-xl border px-3 py-1.5 text-xs font-semibold transition {{ in_array($activeKategori, ['semua', '', null], true) ? 'bg-gray-900 text-white border-gray-900' : 'bg-gray-100 text-gray-600 border-gray-200 hover:bg-gray-200' }}">
                    Semua
                    <span class="rounded-md bg-white px-1.5 py-0.5 text-[10px] font-bold text-gray-600 shadow-sm">{{ $totalArsip }}</span>
                </a>

                @foreach($kategoriList as $kat)
                    @php
                        $countKat = \App\Models\ArsipDokumen::where('kategori', $kat)->count();
                    @endphp
                    <a href="{{ route('admin.arsip-dokumen.index', array_merge(request()->except('kategori','page'), ['kategori'=>$kat])) }}"
                    class="inline-flex items-center gap-2 rounded-xl border px-3 py-1.5 text-xs font-semibold transition {{ $activeKategori === $kat ? 'bg-blue-600 text-white border-blue-600' : 'bg-gray-100 text-gray-600 border-gray-200 hover:bg-gray-200' }}">
                        {{ $kat }}
                        <span class="rounded-md bg-white px-1.5 py-0.5 text-[10px] font-bold text-gray-600 shadow-sm">{{ $countKat }}</span>
                    </a>
                @endforeach
            </div>

            <!-- Search -->
            <form method="GET" action="{{ route('admin.arsip-dokumen.index') }}" class="flex w-full items-center gap-3 lg:w-auto">
                @if(request('kategori') && request('kategori') !== 'semua')
                    <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                @endif
                <label class="relative block w-full lg:w-[260px]">
                    <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-gray-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Dokumen..."
                           class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent text-sm" />
                </label>
            </form>
        </div>

        <!-- Table data -->
        @if($arsips->count() > 0)
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 font-semibold text-gray-700 text-center w-12">No</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Dokumen</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Kategori</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Tgl Dokumen</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Nama File Asli</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Ukuran</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Pengunggah</th>
                        <th class="px-6 py-4 font-semibold text-gray-700 text-center sticky right-0 bg-gray-50 z-10 shadow-[inset_1px_0_0_#e5e7eb]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($arsips as $index => $item)
                    <tr class="hover:bg-gray-50 transition-colors group">
                        <td class="px-6 py-4 text-center text-gray-700">{{ $arsips->firstItem() + $index }}</td>
                        <td class="px-6 py-4 font-semibold text-gray-900">
                            {{ $item->judul }}
                            @if($item->nomor_dokumen)
                                <div class="text-xs text-gray-500 font-mono mt-0.5">No: {{ $item->nomor_dokumen }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-700">
                            <span class="inline-flex rounded-md bg-blue-50 px-2 py-1 text-xs font-semibold text-blue-700 ring-1 ring-inset ring-blue-600/20">
                                {{ $item->kategori }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-700">
                            {{ $item->tanggal_dokumen ? $item->tanggal_dokumen->format('d - m - Y') : '-' }}
                        </td>
                        <td class="px-6 py-4 text-gray-700 max-w-[200px] truncate" title="{{ $item->file_name_asli }}">
                            {{ $item->file_name_asli }}
                        </td>
                        <td class="px-6 py-4 text-gray-700">{{ $item->formatted_file_size }}</td>
                        <td class="px-6 py-4 text-gray-700">
                            {{ $item->uploader?->nama ?? 'Admin' }}
                        </td>
                        <td class="px-6 py-4 text-center sticky right-0 bg-white group-hover:bg-gray-50 z-10 transition-colors shadow-[inset_1px_0_0_#e5e7eb]">
                            <div class="flex justify-center gap-1">
                                <!-- Tombol Unduh -->
                                <a href="{{ route('admin.arsip-dokumen.download', $item) }}"
                                   class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-emerald-400 bg-emerald-50 text-emerald-600 transition hover:bg-emerald-600 hover:text-white"
                                   title="Unduh Berkas">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                </a>
                                <!-- Tombol Lihat Detail -->
                                <a href="{{ route('admin.arsip-dokumen.show', $item) }}"
                                   class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-blue-400 bg-blue-50 text-blue-600 transition hover:bg-blue-600 hover:text-white"
                                   title="Lihat Detail">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <!-- Tombol Edit -->
                                <a href="{{ route('admin.arsip-dokumen.edit', $item) }}"
                                   class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-amber-400 bg-amber-50 text-amber-600 transition hover:bg-amber-500 hover:text-white"
                                   title="Edit">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <!-- Tombol Hapus -->
                                <button type="button"
                                        class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-red-400 bg-red-50 text-red-600 transition hover:bg-red-600 hover:text-white"
                                        title="Hapus"
                                        onclick="confirmDelete('{{ route('admin.arsip-dokumen.destroy', $item) }}', '{{ addslashes($item->judul) }}')">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @include('layouts.partials.admin._pagination', ['paginator' => $arsips])

        @else
        <div class="flex min-h-[300px] flex-col items-center justify-center gap-3 px-6 py-10 text-center text-gray-500">
            <p class="text-base font-semibold text-gray-900">Belum ada data arsip dokumen</p>
            <span class="text-sm text-gray-500">{{ request('search') ? 'Data "'. request('search') . '" tidak ditemukan' : 'Unggah arsip dokumen pertama' }}</span>
        </div>
        @endif

    </div>
</div>

    <!-- Modal Upload -->
    <div id="modalUpload" class="fixed inset-0 z-[100] hidden">
        <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm" onclick="document.getElementById('modalUpload').classList.add('hidden')"></div>
        <div class="absolute top-1/2 left-1/2 w-full max-w-lg -translate-x-1/2 -translate-y-1/2 rounded-2xl bg-white p-6 shadow-xl sm:p-8 max-h-[90vh] overflow-y-auto">
            <div class="mb-4 flex items-center justify-between border-b border-gray-100 pb-3">
                <h3 class="text-lg font-bold text-gray-900">Unggah Arsip Dokumen Administrasi</h3>
                <button type="button" onclick="document.getElementById('modalUpload').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form method="POST" action="{{ route('admin.arsip-dokumen.store') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Judul / Nama Dokumen <span class="text-red-500">*</span></label>
                    <input type="text" name="judul" required placeholder="Contoh: Akta Notaris Pendirian Yayasan" value="{{ old('judul') }}"
                           class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Nomor Dokumen / Surat</label>
                        <input type="text" name="nomor_dokumen" placeholder="Contoh: 01/SK/MK/2026" value="{{ old('nomor_dokumen') }}"
                               class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Kategori Dokumen <span class="text-red-500">*</span></label>
                        <select name="kategori" required class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3.5 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                            <option value="">Pilih Kategori...</option>
                            @foreach($kategoriList as $kat)
                                <option value="{{ $kat }}" @selected(old('kategori') === $kat)>{{ $kat }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Tanggal Dokumen</label>
                    <input type="date" name="tanggal_dokumen" value="{{ old('tanggal_dokumen') }}"
                           class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Keterangan / Deskripsi Singkat</label>
                    <textarea name="deskripsi" rows="3" placeholder="Catatan atau keterangan mengenai dokumen..."
                              class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20">{{ old('deskripsi') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Berkas Dokumen <span class="text-red-500">*</span></label>
                    <input type="file" name="file" required accept=".pdf,.doc,.docx,.xls,.xlsx,.png,.jpg,.jpeg"
                           class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3 py-2 text-xs file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200 focus:outline-none">
                    <p class="text-[11px] text-gray-400 mt-1">Format: PDF, DOC, DOCX, XLS, XLSX, PNG, JPG (Maks. 10 MB). Berkas disimpan secara aman dan privat.</p>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="button" onclick="document.getElementById('modalUpload').classList.add('hidden')" class="rounded-xl px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100 transition">Batal</button>
                    <button type="submit" class="rounded-xl bg-blue-600 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 transition">Simpan Dokumen</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="modalDelete" class="fixed inset-0 z-[100] hidden">
        <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm" onclick="document.getElementById('modalDelete').classList.add('hidden')"></div>
        <div class="absolute top-1/2 left-1/2 w-full max-w-md -translate-x-1/2 -translate-y-1/2 rounded-2xl bg-white p-6 shadow-xl">
            <h3 class="text-base font-bold text-gray-900 mb-2">Konfirmasi Hapus Arsip</h3>
            <p class="text-sm text-gray-600 mb-4">Apakah Anda yakin ingin menghapus arsip dokumen <span id="deleteDocTitle" class="font-bold text-gray-900"></span>? Berkas fisik dan data dokumen akan dihapus permanen.</p>
            <form id="formDelete" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('modalDelete').classList.add('hidden')" class="rounded-xl px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100">Batal</button>
                    <button type="submit" class="rounded-xl bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700">Ya, Hapus</button>
                </div>
            </form>
        </div>
    </div>

@push('scripts')
<script>
    function confirmDelete(url, title) {
        document.getElementById('formDelete').action = url;
        document.getElementById('deleteDocTitle').textContent = `"${title}"`;
        document.getElementById('modalDelete').classList.remove('hidden');
    }
</script>
@endpush
@endsection
