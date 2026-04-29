@extends('layouts.app')
@section('page-title', 'Data Anak Asuh')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <div class="flex justify-between mb-4">
        <button class="bg-blue-500 text-white px-4 py-2 rounded-lg flex items-center hover:bg-blue-600 transition shadow-sm">
            <a href="{{ route('anak-asuh.create') }}">
                <span class="mr-2">+</span>Tambah Anak Asuh
            </a>
        </button>
        <div class="flex gap-2">
            <a href="{{ route('anak-asuh.cetak') }}" target="_blank" class="bg-white rounded-lg flex items-center hover:bg-gray-50">
                <button class="bg-white border-[1px] border-gray-500 px-4 py-2 rounded-lg flex items-center hover:bg-gray-100">
                    <i class="fas fa-print mr-2"></i> Cetak Laporan
                </button>
            </a>
            <div class="relative">
                <input type="text" placeholder="Search..." class="border rounded-lg px-4 py-2 pl-10">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full text-left border-collapse">
    <thead class="bg-gray-200">
        <tr>
            <th class="p-4 border">No</th>
            <th class="p-4 border">Foto</th>
            <th class="p-4 border">Nama lengkap</th>
            <th class="p-4 border">Tempat, tanggal lahir</th>
            <th class="p-4 border">Jenis kelamin</th>
            <th class="p-4 border">Status sosial anak</th>
            <th class="p-4 border">Nama ayah</th>
            <th class="p-4 border">Nama ibu</th>
            <th class="p-4 border text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $key => $item)
        <tr class="hover:bg-gray-50">
            <td class="p-4 border text-center">{{ $loop->iteration }}</td>
            <td class="p-4 border text-center">
                <img src="{{ asset('storage/'.$item->foto) }}" class="w-12 h-12 rounded object-cover mx-auto">
            </td>
            <td class="p-4 border font-semibold">{{ $item->nama }}</td>
            <td class="p-4 border">
                {{ $item->tempat_lahir }}, <br>
                <span class="text-gray-500">{{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d - m - Y') }}</span>
            </td>
            <td class="p-4 border text-center">{{ $item->jenis_kelamin }}</td>
            <td class="p-4 border">{{ $item->status_social_anak }}</td>
            <td class="p-4 border">{{ $item->nama_ayah }}</td>
            <td class="p-4 border">{{ $item->nama_ibu }}</td>
            <td class="p-4 border text-center">
                <div class="flex flex-col gap-2 items-center">
                    <a href="{{ route('anak-asuh.show', $item->id) }}" class="bg-green-600 text-white px-4 py-1 rounded w-24 text-sm inline-block">
                        Lihat
                    </a>
                    <a href="{{ route('anak-asuh.edit', $item->id) }}" class="bg-orange-400 text-white px-4 py-1 rounded w-24 text-sm inline-block">
                        Edit
                    </a>
                    <button onclick="openDeleteModal({{ $item->id }})" class="bg-red-400 text-white px-4 py-1 rounded w-24 text-sm">Hapus</button>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
        
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