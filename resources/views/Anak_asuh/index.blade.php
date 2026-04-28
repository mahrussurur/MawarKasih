@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <!-- <h2 class="text-2xl font-bold mb-4">Data Anak Asuh</h2> -->

    <div class="flex justify-between mb-4">
        <button class="bg-blue-400 text-white px-4 py-2 rounded-lg flex items-center">
            <a href="{{ route('anak-asuh.create') }}">
                <span class="mr-2">+</span>Tambah Anak Asuh
            </a>
        </button>
        <div class="flex gap-2">
            <a href="{{ route('anak-asuh.cetak') }}" target="_blank" class="bg-white rounded-lg flex items-center hover:bg-gray-50">
                <button class="bg-white border px-4 py-2 rounded-lg flex items-center">
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
                    <button class="bg-orange-400 text-white px-4 py-1 rounded w-24 text-sm">Edit</button>
                    <form action="{{ route('anak-asuh.destroy', $item->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="bg-red-400 text-white px-4 py-1 rounded w-24 text-sm">Hapus</button>
                    </form>
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
@endsection