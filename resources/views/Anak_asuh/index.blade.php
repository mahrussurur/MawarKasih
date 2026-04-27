<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Anak Asuh - Yayasan Mawar Kasih</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-200 font-sans">

    <div class="flex min-h-screen">
        <aside class="w-64 bg-[#2D3748] text-gray-300 flex flex-col">
            <div class="p-6 flex items-center gap-3">
                <div class="w-10 h-10 bg-gray-600 rounded-full"></div> 
                <span class="font-bold text-white text-lg leading-tight">Yayasan<br>Mawar Kasih</span>
            </div>

            <nav class="mt-6 flex-1 px-4 space-y-2">
                <a href="#" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition">
                    <span class="ml-3">Dashboard</span>
                </a>
                <a href="{{ route('anak-asuh.index') }}" class="flex items-center p-3 rounded-lg bg-[#4A5568] text-white shadow-md">
                    <span class="ml-3 font-semibold">Data Anak Asuh</span>
                </a>
                <a href="#" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition">
                    <span class="ml-3">Data Pengasuh</span>
                </a>
                <a href="#" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition">
                    <span class="ml-3">Data Donasi</span>
                </a>
            </nav>

            <div class="p-4 border-t border-gray-700">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center p-3 bg-red-500 hover:bg-red-600 text-white rounded-xl transition shadow-lg">
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 p-10">
            <header class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Data Anak Asuh</h1>
                <div class="flex items-center gap-3 bg-white p-2 rounded-full shadow-sm pr-4">
                    <div class="w-8 h-8 bg-green-400 rounded-full"></div>
                    <span class="font-semibold text-gray-700 text-sm">Admin</span>
                </div>
            </header>

            <div class="flex justify-between mb-6">
                <a href="{{ route('anak-asuh.create') }}" class="bg-[#78ace2] hover:bg-blue-500 text-white px-6 py-2 rounded-lg font-semibold shadow-md transition flex items-center">
                    + Tambah Anak Asuh
                </a>
                
                <a href="{{ route('anak-asuh.cetak') }}" target="_blank" class="bg-gray-100 border border-gray-300 px-6 py-2 rounded-lg font-semibold text-gray-700 hover:bg-white shadow-sm transition flex items-center gap-2">
                   <span>📄</span> Cetak Laporan
                </a>
            </div>

            <div class="bg-white rounded-3xl shadow-xl p-8">
                <div class="flex justify-end mb-4">
                    <div class="relative">
                        <input type="text" placeholder="Search..." class="border border-gray-300 rounded-lg px-4 py-2 w-64 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                </div>

                <div class="overflow-hidden border border-gray-200 rounded-xl">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-300 text-gray-800 font-bold">
                            <tr>
                                <th class="p-4 border">No</th>
                                <th class="p-4 border">Nama lengkap</th>
                                <th class="p-4 border">Tempat, tanggal lahir</th>
                                <th class="p-4 border text-center">Jenis kelamin</th>
                                <th class="p-4 border text-center">Foto</th>
                                <th class="p-4 border text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @forelse($anakAsuh as $key => $anak)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 border text-center">{{ $key + 1 }}</td>
                                <td class="p-4 border font-medium">{{ $anak->nama }}</td>
                                <td class="p-4 border">
                                    {{ $anak->tempat_lahir }}, {{ \Carbon\Carbon::parse($anak->tanggal_lahir)->format('d - m - Y') }}
                                </td>
                                <td class="p-4 border text-center">{{ $anak->jenis_kelamin }}</td>
                                <td class="p-4 border text-center">
                                    @if($anak->foto)
                                        <img src="{{ asset('storage/'.$anak->foto) }}" class="w-16 h-16 object-cover rounded-lg mx-auto shadow-sm">
                                    @else
                                        <div class="w-16 h-16 bg-gray-200 rounded-lg mx-auto flex items-center justify-center text-xs text-gray-400">No Foto</div>
                                    @endif
                                </td>
                                <td class="p-4 border text-center space-y-2">
                                    <a href="{{ route('anak-asuh.edit', $anak->id) }}" class="inline-block w-full bg-[#f6ad55] text-white px-3 py-1 rounded-md text-sm font-bold shadow hover:bg-orange-400 transition text-center">
                                        Edit
                                    </a>

                                    <form action="{{ route('anak-asuh.destroy', $anak->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full bg-[#f56565] text-white px-3 py-1 rounded-md text-sm font-bold shadow hover:bg-red-600 transition">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="p-10 text-center text-gray-500 italic">Belum ada data anak asuh.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

</body>
</html>