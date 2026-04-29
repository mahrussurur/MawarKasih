@extends('layouts.app')
@section('page-title', 'Data Pengasuh')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow overflow-hidden">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Detail Pengasuh</h2>
                <p class="text-gray-500">Informasi lengkap pengasuh.</p>
            </div>
            <a href="{{ route('pengasuh.index') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200">Kembali</a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6">
            <!-- Foto -->
            <div class="col-span-1 flex flex-col items-center gap-2">
                <img src="{{ asset('storage/'.$pengasuh->foto) }}" class="w-48 h-48 rounded-lg object-cover border-2 border-gray-200">
                <span class="text-lg font-bold text-gray-700">{{ $pengasuh->nama }}</span>
                <span class="text-sm text-gray-700">{{ $pengasuh->jabatan }}</span>
            </div>
            
            
            <!-- Detail -->
            <div class="col-span-2 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                        <div class="text-sm text-gray-500">Jenis Kelamin</div>
                        <div class="text-gray-900 font-semibold">{{ $pengasuh->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                        <div class="text-sm text-gray-500">No. HP</div>
                        <div class="text-gray-900 font-semibold">{{ $pengasuh->no_hp }}</div>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <div class="text-sm text-gray-500">Tanggal Dibuat</div>
                    <div class="text-gray-900 font-semibold">{{ \Carbon\Carbon::parse($pengasuh->created_at)->format('d - m - Y') }}</div>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('pengasuh.edit', $pengasuh->id) }}" class="bg-orange-400 text-white px-8 py-2 rounded-lg hover:bg-orange-500">
                        Edit
                    </a>
                    <button onclick="openDeleteModal({{ $pengasuh->id }})" class="bg-red-500 text-white px-5 py-2 rounded-lg hover:bg-red-600">
                        Hapus
                    </button>
                </div>
            </div>
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
    document.getElementById('deleteForm').action = '{{ url("anak-asuh") }}/' + id;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}
</script>
@endsection