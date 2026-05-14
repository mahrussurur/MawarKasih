@extends('admin.layouts.app')
@section('page-title', 'Data Donasi')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen flex justify-center items-start">

    <div class="w-full max-w-3xl bg-white rounded-xl shadow-md p-8 border border-gray-200 mt-4">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Tambah Data Donasi</h2>

        <form action="{{ route('donasi.store') }}" method="POST">
            @csrf

            <div class="mb-5">
                <label class="block text-gray-800 font-semibold mb-2">Nama Donatur</label>
                <input type="text" name="nama_donatur" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <div class="flex gap-4 mb-5">
                <div class="w-1/2">
                    <label class="block text-gray-800 font-semibold mb-2">No. HP</label>
                    <input type="text" name="no_hp" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div class="w-1/2">
                    <label class="block text-gray-800 font-semibold mb-2">Nominal</label>
                    <input type="number" name="nominal" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400" min="1000" required>
                </div>
            </div>

            <div class="mb-5">
                <label class="block text-gray-800 font-semibold mb-2">Tanggal</label>
                <input type="date" name="tanggal" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 text-gray-600" required>
            </div>

            <div class="mb-8">
                <label class="block text-gray-800 font-semibold mb-2">Keterangan</label>
                <textarea name="keterangan" rows="4" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Tambahkan keterangan donasi..."></textarea>
            </div>

            <div class="flex justify-between items-center pt-6 border-t border-gray-200 mt-6 pb-2">
                <a href="{{ route('donasi.index') }}" class="bg-gray-200 text-gray-700 border border-gray-300 px-8 py-2 rounded-lg font-medium hover:bg-gray-300 transition">
                    Batal
                </a>
                <button type="submit" class="bg-blue-500 text-white px-8 py-2 rounded-lg font-medium hover:bg-blue-600 transition shadow-sm">
                    Simpan
                </button>
            </div>

        </form>
    </div>
</div>
@endsection