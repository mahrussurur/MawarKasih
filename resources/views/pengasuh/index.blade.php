@extends('layouts.app')
@section('page-title', 'Data Pengasuh')

@section('content')
<div class="p-1 bg-gray-100 min-h-screen">

    <div class="flex justify-between mb-4">
        <button class="bg-blue-500 text-white px-4 py-2 rounded-lg flex items-center hover:bg-blue-600 transition shadow-sm">
            <a href="{{ route('pengasuh.create') }}">
                <span class="mr-2">+</span>Tambah Pengasuh
            </a>
        </button>
        <div class="flex gap-2">
            <a href="{{ route('pengasuh.cetak') }}" target="_blank" class="bg-white rounded-lg flex items-center hover:bg-gray-50">
                <button class="bg-white border-[1px] border-gray-500 px-4 py-2 rounded-lg flex items-center hover:bg-gray-100">
                    <i class="fas fa-print mr-2"></i> Cetak Laporan
                </button>
            </a>
        </div>
    </div>

    <!-- Kotak utama konten -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        
        <!-- Baris Pencarian dan Filter -->
        <form action="{{ route('pengasuh.index') }}" method="GET" class="flex flex-col md:flex-row justify-between mb-6 gap-4">
            <!-- Input Pencarian -->
            <div class="relative w-full md:w-80">
                <!-- Icon Kaca Pembesar (Kiri) -->
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>

                <!-- Input Teks (Perhatikan pr-10 agar teks tidak menabrak icon kirim) -->
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pengasuh..." class="w-full pl-10 pr-10 py-2 border border-gray-200 rounded-lg text-sm focus:ring-[#1a56db] focus:border-[#1a56db]">

                <!-- Tombol Icon Kirim (Kanan) -->
                <button type="submit" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-[#1a56db] transition-colors" title="Cari Data">
                    <svg class="h-5 w-5 rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </button>
            </div>
        </form>

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
                <tbody  class="text-gray-700 text-sm">
                    @forelse($data as $index => $item)
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-4 text-center">{{ $loop->iteration }}</td>
                        <td class="px-4 py-4 text-center">
                            <img src="{{ asset('storage/'.$item->foto) }}" class="w-12 h-12 rounded object-cover mx-auto">
                        </td>
                        <td class="px-4 py-4 font-semibold">{{ $item->nama }}</td>
                        <td class="px-4 py-4">{{ $item->jabatan }}</td>
                        <td class="px-4 py-4">{{ $item->jenis_kelamin}}</td>
                        <td class="px-4 py-4">{{ $item->no_hp }}</td>
                        <td class="px-4 py-4 text-center">
                            <div class="flex justify-center space-x-2">
                                <!-- Tombol Lihat Detail (Icon Mata - Biru Terang) -->
                                <a href="{{ route('pengasuh.show', $item->id) }}"
                                    class="p-2 text-blue-500 hover:text-blue-600 bg-blue-50 hover:bg-blue-100 rounded border border-blue-500 transition-colors"
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
                                <a href="{{ route('pengasuh.edit', $item->id) }}"
                                    class="p-2 text-yellow-500 hover:text-yellow-600 bg-yellow-50 hover:bg-yellow-100 rounded border border-yellow-500 transition-colors"                                        title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                </a>
                                <button
                                    onclick="openDeleteModal({{ $item->id }})"
                                    class="p-2 text-white bg-red-500 hover:bg-red-600 rounded transition-colors shadow-sm"
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
                            <td colspan="6" class="px-4 py-4 text-center text-gray-500">
                                Tidak ada data pengasuh yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 flex justify-end">
            {{ $data->links() }}
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
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
function openDeleteModal(id) {
    document.getElementById('deleteForm').action = '/pengasuh/' + id;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}
</script>
@endsection