@extends('layouts.app')
@section('page-title', 'Data Anak Asuh')
@section('title', 'Data Anak Asuh | Panti Asuhan Mawar Kasih')

@section('content')
<div>
    <!-- Toolbar -->
    <div class="flex justify-between mb-4">
        <div class="flex flex-wrap items-start gap-3">
            <a href="{{ route('pengasuh.anak-asuh.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Anak Asuh
            </a>
        </div>
    </div>

    <!-- Kotak Utama Konten -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6">
        
        <div class="flex flex-col gap-4 border-b border-gray-200 pb-4 lg:flex-row lg:items-center lg:justify-end">
            <!-- Search -->
            <form method="GET" action="{{ route('pengasuh.anak-asuh.index') }}" class="flex w-full items-center gap-3 lg:w-auto">
                <label class="relative block w-full lg:w-[260px]">
                    <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-gray-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / sekolah..."
                           class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent text-sm" />
                </label>
            </form>
        </div>

        <!-- Table Data -->
        @if($data->count() > 0)
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left divide-y divide-gray-200 text-sm border-b border-gray-200 whitespace-nowrap">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 font-semibold text-gray-700 text-center w-12">No</th>
                        <th class="px-6 py-4 font-semibold text-gray-700 w-20">Foto</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Nama Lengkap</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Nama Panggilan</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Tempat, Tanggal Lahir</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Jenis Kelamin</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Status Sosial Anak</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Nama Ayah</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Nama Ibu</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Tinggal di LKSA Sejak</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Sekolah</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Kelas</th>
                        <th class="px-6 py-4 font-semibold text-gray-700 text-center sticky right-0 bg-gray-50 z-10 shadow-[inset_1px_0_0_#e5e7eb]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($data as $index => $item)
                    <tr class="hover:bg-gray-50 transition-colors group">
                        <td class="px-6 py-4 text-center text-gray-700">{{ $data->firstItem() + $index }}</td>
                        <td class="px-6 py-4 text-center">
                            <button type="button"
                                    class="inline-flex"
                                    onclick="openImagePreview('{{ asset('storage/'.$item->foto) }}')"
                                    aria-label="Perbesar foto {{ $item->nama }}">
                                <img src="{{ asset('storage/'.$item->foto) }}"
                                     class="w-12 h-12 rounded object-cover mx-auto cursor-pointer transition duration-200 hover:scale-105"
                                     alt="Foto {{ $item->nama }}"
                                     title="Klik untuk perbesar">
                            </button>
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-900">{{ $item->nama }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $item->nama_panggilan ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-700">
                            {{ $item->tempat_lahir }}, <br>
                            <span class="text-gray-500">{{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d - m - Y') }}</span>
                        </td>
                        <td class="px-6 py-4 text-gray-700">{{ $item->jenis_kelamin ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-700">
                            <span class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-semibold ring-1 ring-inset ring-gray-200">{{ $item->status_social_anak ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4 text-gray-700">{{ $item->nama_ayah ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $item->nama_ibu ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $item->tinggal_di_lksa_sejak ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $item->sekolah ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $item->kelas ?? '-' }}</td>
                        <td class="px-6 py-4 text-center sticky right-0 bg-white group-hover:bg-gray-50 z-10 transition-colors shadow-[inset_1px_0_0_#e5e7eb]">
                            <div class="flex justify-center gap-1">
                                <!-- Tombol Lihat Detail -->
                                <a href="{{ route('pengasuh.anak-asuh.show', $item->id) }}"
                                   class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-blue-400 bg-blue-50 text-blue-600 transition hover:bg-blue-600 hover:text-white"
                                   title="Lihat Detail">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <!-- Tombol Edit -->
                                <a href="{{ route('pengasuh.anak-asuh.edit', $item->id) }}"
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-amber-400 bg-amber-50 text-amber-600 transition hover:bg-amber-500 hover:text-white"
                                    title="Edit">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <!-- Tombol Jadikan Alumni -->
                                <a href="{{ route('pengasuh.alumni.create', $item->id) }}"
                                        class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-purple-400 bg-purple-50 text-purple-600 transition hover:bg-purple-600 hover:text-white"
                                        title="Jadikan Alumni">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                        <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0v6" />
                                    </svg>
                                </a>

                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @include('layouts.partials.admin._pagination', ['paginator' => $data])

        @else
        <div class="flex min-h-[300px] flex-col items-center justify-center gap-3 px-6 py-10 text-center text-gray-500">
            <p class="text-base font-semibold text-gray-900">Belum ada data anak asuh</p>
            <span class="text-sm text-gray-500">{{ request('search') ? 'Data "'. request('search') . '" tidak ditemukan' : 'Tambahkan data anak asuh' }}</span>
        </div>
        @endif
    </div>
</div>

@endsection
