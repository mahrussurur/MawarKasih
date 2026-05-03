@extends('layouts.app') <!-- Pastikan ini sesuai dengan nama file layout kalian -->

@section('content')
    <div class="p-6 sm:p-10">

        <!-- Header & Breadcrumb -->
        <div class="flex flex-col md:flex-row justify-between md:items-end mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Kegiatan</h1>
                <p class="text-sm text-gray-500 mt-1">
                    Dashboard <span class="mx-1">/</span> <span class="text-gray-400">Kegiatan</span>
                </p>
            </div>

            <div class="flex space-x-3">
                <!-- Tombol Cetak Laporan -->
                <!-- <button
                    class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium py-2 px-4 rounded-lg flex items-center shadow-sm transition-colors">
                    <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                        </path>
                    </svg>
                    Cetak Laporan
                </button> -->

                <!-- Tombol Tambah Kegiatan -->
                <a href="{{ route('kegiatan.create') }}"
                    class="bg-[#1a56db] hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg flex items-center shadow-sm transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Kegiatan
                </a>
            </div>
        </div>

        <!-- Kotak Utama Konten -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">

        <!-- Baris Pencarian dan Filter -->
        <form action="{{ route('kegiatan.index') }}" method="GET" class="flex flex-col md:flex-row justify-between mb-6 gap-4">
            
            <!-- Input Pencarian -->
            <div class="relative w-full md:w-80">
                <!-- Icon Kaca Pembesar (Kiri) -->
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                
                <!-- Input Teks (Perhatikan pr-10 agar teks tidak menabrak icon kirim) -->
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul kegiatan..." class="w-full pl-10 pr-10 py-2 border border-gray-200 rounded-lg text-sm focus:ring-[#1a56db] focus:border-[#1a56db]">
                
                <!-- Tombol Icon Kirim (Kanan) -->
                <button type="submit" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-[#1a56db] transition-colors" title="Cari Data">
                    <svg class="h-5 w-5 rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </button>
            </div>

            <!-- Dropdown Filter Tahun (Tetap Otomatis) -->
            <select name="tahun" onchange="this.form.submit()" class="border border-gray-200 text-gray-600 text-sm rounded-lg focus:ring-[#1a56db] focus:border-[#1a56db] py-2 px-4 bg-white cursor-pointer shadow-sm">
                <option value="">Semua Tahun</option>
                <option value="2026" {{ request('tahun') == '2026' ? 'selected' : '' }}>2026</option>
                <option value="2025" {{ request('tahun') == '2025' ? 'selected' : '' }}>2025</option>
            </select>
            
        </form>

            <!-- Tabel Data -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-600 text-sm font-semibold border-b border-gray-200">
                            <th class="px-4 py-3 text-center w-12">No</th>
                            <th class="px-4 py-3 w-20">Foto</th>
                            <th class="px-4 py-3">Judul Kegiatan</th>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Deskripsi Singkat</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-sm">
                        @forelse($kegiatans as $index => $kegiatan)
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-4 text-center">{{ $index + 1 }}</td>
                                <td class="px-4 py-4">
                                    @if($kegiatan->foto_dokumentasi)
                                        <img src="{{ asset('storage/' . $kegiatan->foto_dokumentasi) }}"
                                            class="w-12 h-12 object-cover rounded shadow-sm">
                                    @else
                                        <div
                                            class="w-12 h-12 bg-gray-100 rounded flex items-center justify-center text-xs text-gray-400 border border-gray-200">
                                            Kosong
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-4 font-medium">{{ $kegiatan->nama_kegiatan }}</td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($kegiatan->tanggal_pelaksanaan)->translatedFormat('d M Y') }}</td>
                                <td class="px-4 py-4">
                                    <!-- Memotong deskripsi agar tidak merusak tabel -->
                                    <span class="line-clamp-2">{{ $kegiatan->deskripsi }}</span>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex justify-center space-x-2">
                                        <!-- Tombol Lihat Detail (Icon Mata - Biru Terang) -->
                                        <a href="{{ route('kegiatan.show', $kegiatan->id) }}"
                                            class="p-2 text-blue-500 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 rounded border border-blue-200 transition-colors"
                                            title="Lihat Detail">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </a>

                                        <!-- Tombol Edit (Icon Pensil - Sesuai Mockup) -->
                                        <a href="{{ route('kegiatan.edit', $kegiatan->id) }}"
                                            class="p-2 text-[#1a56db] hover:text-blue-800 border border-[#1a56db] hover:bg-blue-50 rounded transition-colors"
                                            title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </a>

                                        <!-- Tombol Hapus (Icon Tong Sampah - Merah Sesuai Mockup) -->
                                        <form action="{{ route('kegiatan.destroy', $kegiatan->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus data ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 text-white bg-red-500 hover:bg-red-600 rounded transition-colors shadow-sm"
                                                title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-gray-500">
                                    Belum ada data kegiatan. Silakan tambah kegiatan baru.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection