@extends('layouts.app')

@section('title', 'Dashboard Ketua')
@section('page-title', 'Dashboard Ketua')

@section('content')
<div class="space-y-6">
    <!-- Header Sambutan -->
    <div>
        <h2 class="text-2xl font-extrabold text-gray-900">Selamat Datang, {{ Auth::user()->nama }}!</h2>
        <p class="mt-1 text-sm font-medium text-gray-500">Dashboard peninjauan data panti asuhan, verifikasi laporan bulanan, dan pengelolaan arsip administrasi.</p>
    </div>

    <!-- Ringkasan Statistik Utama -->
    <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Donatur -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-amber-100 text-amber-600">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><polyline points="16 11 18 13 22 9"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Data Donatur</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalDonatur }}</p>
                </div>
            </div>
            <a href="{{ route('ketua.donatur.index') }}" class="mt-4 block w-full rounded-xl bg-amber-500 px-3 py-2 text-center text-xs font-bold text-white transition hover:bg-amber-600">Lihat Donatur</a>
        </div>

        <!-- Anak Asuh -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-blue-100 text-blue-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Anak Asuh</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalAnak }}</p>
                </div>
            </div>
            <a href="{{ route('ketua.anak-asuh.index') }}" class="mt-4 block w-full rounded-xl bg-blue-600 px-3 py-2 text-center text-xs font-bold text-white transition hover:bg-blue-700">Lihat Anak Asuh</a>
        </div>

        <!-- Alumni -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-violet-100 text-violet-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0v6"/></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Data Alumni</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalAlumni }}</p>
                </div>
            </div>
            <a href="{{ route('ketua.alumni.index') }}" class="mt-4 block w-full rounded-xl bg-violet-600 px-3 py-2 text-center text-xs font-bold text-white transition hover:bg-violet-700">Lihat Alumni</a>
        </div>

        <!-- Arsip Dokumen -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-md">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-teal-100 text-teal-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Arsip Dokumen</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalArsip }}</p>
                </div>
            </div>
            <a href="{{ route('ketua.arsip-dokumen.index') }}" class="mt-4 block w-full rounded-xl bg-teal-600 px-3 py-2 text-center text-xs font-bold text-white transition hover:bg-teal-700">Lihat Arsip</a>
        </div>
    </div>

    <!-- Section Laporan Bulanan Menunggu Review -->
    <div class="rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 border-b border-gray-100 pb-4">
            <div class="flex items-center gap-3">
                <h3 class="text-base font-extrabold text-gray-900">Laporan Bulanan Menunggu Review</h3>
                @if($laporanMenungguReview > 0)
                    <span class="inline-flex items-center justify-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-bold text-blue-800 animate-pulse">
                        {{ $laporanMenungguReview }} Menunggu Tindakan
                    </span>
                @endif
            </div>
            <a href="{{ route('ketua.laporan-bulanan.index', ['status' => 'diajukan']) }}" class="text-xs font-bold text-blue-600 hover:text-blue-700">
                Lihat Semua Laporan Diajukan →
            </a>
        </div>

        @if($laporanTerbaru->isNotEmpty())
            <div class="overflow-x-auto mt-4">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-2.5 font-semibold text-gray-700">Periode</th>
                            <th class="px-4 py-2.5 font-semibold text-gray-700">Pemasukan</th>
                            <th class="px-4 py-2.5 font-semibold text-gray-700">Pengeluaran</th>
                            <th class="px-4 py-2.5 font-semibold text-gray-700">Saldo Akhir</th>
                            <th class="px-4 py-2.5 font-semibold text-gray-700">Diajukan Pada</th>
                            <th class="px-4 py-2.5 text-center font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($laporanTerbaru as $lap)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 font-bold text-gray-900">
                                    {{ \Carbon\Carbon::create()->month($lap->bulan)->translatedFormat('F') }} {{ $lap->tahun }}
                                </td>
                                <td class="px-4 py-3 font-semibold text-emerald-600">+Rp {{ number_format($lap->total_pemasukan, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 font-semibold text-rose-600">-Rp {{ number_format($lap->total_pengeluaran, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 font-extrabold text-gray-900">Rp {{ number_format($lap->saldo_akhir, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-xs text-gray-500">
                                    {{ $lap->submitted_at ? $lap->submitted_at->format('d M Y, H:i') : '-' }}
                                    <div class="text-[11px] text-gray-400">oleh {{ $lap->submitter?->nama ?? 'Bendahara' }}</div>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('ketua.laporan-bulanan.show', $lap) }}" class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-3 py-1.5 text-xs font-semibold text-white shadow-sm transition hover:bg-blue-700">
                                        <span>Tinjau &amp; Setujui</span>
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-8 text-center text-gray-500">
                <svg class="h-10 w-10 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-sm font-semibold text-gray-700">Tidak ada laporan yang menunggu review saat ini.</p>
                <p class="text-xs text-gray-400 mt-0.5">Semua laporan yang diajukan Bendahara telah ditinjau.</p>
            </div>
        @endif
    </div>

    <!-- Section Dokumen Administrasi Terbaru -->
    <div class="rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 border-b border-gray-100 pb-4">
            <h3 class="text-base font-extrabold text-gray-900">Arsip Dokumen Administrasi Terbaru</h3>
            <div class="flex items-center gap-2">
                <a href="{{ route('ketua.arsip-dokumen.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700">
                    Buka Semua Arsip →
                </a>
            </div>
        </div>

        @if($arsipTerbaru->isNotEmpty())
            <div class="overflow-x-auto mt-4">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-2.5 font-semibold text-gray-700">Nama Dokumen</th>
                            <th class="px-4 py-2.5 font-semibold text-gray-700">Kategori</th>
                            <th class="px-4 py-2.5 font-semibold text-gray-700">Tanggal Dokumen</th>
                            <th class="px-4 py-2.5 font-semibold text-gray-700">Ukuran</th>
                            <th class="px-4 py-2.5 text-center font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($arsipTerbaru as $arsip)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3">
                                    <div class="font-bold text-gray-900">{{ $arsip->judul }}</div>
                                    @if($arsip->nomor_dokumen)
                                        <div class="text-xs text-gray-500">No: {{ $arsip->nomor_dokumen }}</div>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex rounded-md bg-gray-100 px-2 py-0.5 text-xs font-semibold text-gray-700">
                                        {{ $arsip->kategori }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">
                                    {{ $arsip->tanggal_dokumen ? $arsip->tanggal_dokumen->format('d M Y') : '-' }}
                                </td>
                                <td class="px-4 py-3 text-xs text-gray-500">{{ $arsip->formatted_file_size }}</td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('ketua.arsip-dokumen.download', $arsip) }}" class="inline-flex items-center gap-1 rounded-lg border border-gray-200 bg-white px-2.5 py-1 text-xs font-semibold text-gray-700 hover:bg-gray-50" title="Unduh">
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                            <span>Unduh</span>
                                        </a>
                                        <a href="{{ route('ketua.arsip-dokumen.show', $arsip) }}" class="inline-flex items-center gap-1 rounded-lg bg-teal-50 px-2.5 py-1 text-xs font-semibold text-teal-700 hover:bg-teal-100" title="Detail">
                                            <span>Detail</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-8 text-center text-gray-500">
                <svg class="h-10 w-10 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                <p class="text-sm font-semibold text-gray-700">Belum ada dokumen administrasi yang diarsipkan.</p>
                <p class="text-xs text-gray-400 mt-0.5">Dokumen administrasi yayasan LKSA Mawar Kasih dikelola oleh Admin.</p>
            </div>
        @endif
    </div>
</div>
@endsection
