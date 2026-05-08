@extends('layouts.app')
@section('page-title', 'Data Anak Asuh')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow overflow-hidden">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <div>
                <h2 class="text-lg font-bold text-gray-900">Detail Anak Asuh</h2>
                <p class="text-sm text-gray-500">Informasi lengkap anak asuh.</p>
            </div>
            <a href="{{ route('anak-asuh.index') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-800 flex items-center transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6">
            <!-- Foto -->
            <div class="col-span-1 flex flex-col items-center gap-2">
                <img src="{{ asset('storage/'.$anakAsuh->foto) }}" class="w-48 h-48 rounded-lg object-cover border-2 border-gray-200">    
                <span class="text-lg font-bold text-gray-700">{{ $anakAsuh->nama }}</span>
                <span class="text-sm text-gray-700">{{ $anakAsuh->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
            </div>

            <!-- Detail -->
            <div class="col-span-2 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                        <div class="text-sm text-gray-500">Tempat Lahir</div>
                        <div class="text-gray-900 font-semibold">{{ $anakAsuh->tempat_lahir }}</div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                        <div class="text-sm text-gray-500">Tanggal Lahir</div>
                        <div class="text-gray-900 font-semibold">{{ \Carbon\Carbon::parse($anakAsuh->tanggal_lahir)->format('d - m - Y') }}</div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                        <div class="text-sm text-gray-500">Nama Ayah</div>
                        <div class="text-gray-900 font-semibold">{{ $anakAsuh->nama_ayah ?? '-' }}</div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                        <div class="text-sm text-gray-500">Nama Ibu</div>
                        <div class="text-gray-900 font-semibold">{{ $anakAsuh->nama_ibu ?? '-' }}</div>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <div class="text-sm text-gray-500">Status Sosial Anak</div>
                    <div class="text-gray-900 font-semibold">{{ $anakAsuh->status_social_anak ?? '-' }}</div>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('anak-asuh.edit', $anakAsuh->id) }}" class="font-semibold bg-orange-400 text-white px-8 py-2 rounded-lg hover:bg-orange-500">
                        Edit
                    </a>
                    <button onclick="openDeleteModal({{ $anakAsuh->id }})" class="font-semibold bg-red-500 text-white px-5 py-2 rounded-lg hover:bg-red-600">
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
                <p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus data anak asuh ini?</p>
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
