<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    /* Membuat scrollbar lebih tipis di area tabel */
    .overflow-hidden::-webkit-scrollbar {
        height: 8px;
    }
    .overflow-hidden::-webkit-scrollbar-thumb {
        background: #cbd5e0;
        border-radius: 10px;
    }
</style>
</head>
<body>
    <x-app-layout>
    <div class="p-10 bg-gray-100 min-h-screen">
        <h2 class="text-2xl font-bold mb-6">Tambah Data Anak Asuh</h2>
        <div class="bg-white p-8 rounded-3xl shadow-lg max-w-2xl">
            <form action="{{ route('anak-asuh.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 gap-4">
                    <input type="text" name="nama" placeholder="Nama Lengkap" class="border p-3 rounded-xl w-full">
                    <div class="grid grid-cols-2 gap-4">
                        <input type="text" name="tempat_lahir" placeholder="Tempat Lahir" class="border p-3 rounded-xl">
                        <input type="date" name="tanggal_lahir" class="border p-3 rounded-xl">
                    </div>
                    <select name="jenis_kelamin" class="border p-3 rounded-xl">
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                    <input type="file" name="foto" class="border p-3 rounded-xl">
                    <button type="submit" class="bg-blue-500 text-white p-3 rounded-xl font-bold">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
</body>
</html>