@extends('public.layouts.app')

@section('title', 'Validasi Donasi')

@section('content')
@include('public.components.page-header', ['title' => 'Validasi Donasi'])
<div class="bg-gray-50 py-10 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        @if(isset($donasi) && $donasi)

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Kiri: Detail Donasi -->
                <div class="lg:col-span-2 bg-white rounded-[28px] p-10 border border-gray-200 shadow-sm">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="mt-2 text-xl font-bold text-gray-900">Detail Donasi</h2>
                        <div class="flex items-center gap-3">
                            @php
                                $color = $donasi->status_color === 'warning' ? 'yellow' : ($donasi->status_color === 'success' ? 'green' : ($donasi->status_color === 'danger' ? 'red' : 'gray'));
                            @endphp
                            <span class="px-3 py-1 text-sm font-medium rounded-full bg-{{ $color }}-100 text-{{ $color }}-800">
                                {{ $donasi->status_label }}
                            </span>
                        </div>
                    </div>

                    <div class="space-y-3 text-sm text-gray-700">
                        <div class="space-y-3">
                            <!-- Bagian Kunci Validasi -->
                            <div class="grid grid-cols-3">
                                <div class="col-span-1 text-gray-500">Kunci Validasi</div>
                                <div class="col-span-2 font-medium flex items-center gap-2">
                                    : {{ $donasi->kode_donasi }}
                                    <button onclick="salinKunci('{{ $donasi->kode_donasi }}')" class="text-gray-400 hover:text-gray-600" title="Salin Kunci">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Pemberitahuan / Info Box -->
                            @if(session('success'))
                                <div id="infoBoxKunci" class="flex items-start gap-2 p-3 bg-yellow-50 border border-yellow-100 rounded-lg transition-all duration-300">
                                    <svg class="w-5 h-5 text-yellow-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-xs text-yellow-700 leading-relaxed">
                                        <span class="font-semibold">Penting:</span> Simpan Kunci Validasi ini. Anda dapat menggunakannya untuk mengecek status dan detail donasi Anda kapan saja.
                                    </p>
                                </div>
                            @endif
                            
                        </div>
                        <div class="grid grid-cols-3">
                            <div class="col-span-1 text-gray-500">Nama</div>
                            <div class="col-span-2 font-medium break-all">: {{ $donasi->nama_donatur }}</div>
                        </div>
                        <div class="grid grid-cols-3">
                            <div class="col-span-1 text-gray-500">Email</div>
                            <div class="col-span-2 font-medium break-all">: {{ $donasi->email ?? '-' }}</div>
                        </div>
                        <div class="grid grid-cols-3">
                            <div class="col-span-1 text-gray-500">Alamat</div>
                            <div class="col-span-2 font-medium break-all">: {{ $donasi->alamat ?? '-' }}</div>
                        </div>
                        <div class="grid grid-cols-3">
                            <div class="col-span-1 text-gray-500">No. Telp</div>
                            <div class="col-span-2 font-medium break-all">: {{ $donasi->no_hp }}</div>
                        </div>
                    </div>

                    <hr class="my-6 border-gray-200">

                    <div class="space-y-3 text-sm text-gray-700">
                        <div class="grid grid-cols-3">
                            <div class="col-span-1 text-gray-500">Nama Tertera</div>
                            <div class="col-span-2 font-medium break-all">: {{ ucwords(str_replace('_', ' ', $donasi->tampilkan_nama)) }}</div>
                        </div>
                        <div class="grid grid-cols-3">
                            <div class="col-span-1 text-gray-500">Keterangan</div>
                            <div class="col-span-2 font-medium break-all">: {{ $donasi->keterangan ?? '-' }}</div>
                        </div>
                        <div class="grid grid-cols-3">
                            <div class="col-span-1 text-gray-500">Nominal</div>
                            <div class="col-span-2 font-medium break-all">: {{ $donasi->nominal_rupiah }}</div>
                        </div>
                        <div class="grid grid-cols-3">
                            <div class="col-span-1 text-gray-500">Metode</div>
                            <div class="col-span-2 font-medium uppercase break-all">: {{ $donasi->metode_pembayaran }}</div>
                        </div>
                    </div>

                    @if($donasi->catatan_admin)
                        @php
                            $catatanBg = 'bg-gray-50 border-gray-200 text-gray-700';
                            $catatanTitle = 'text-gray-800';
                            if ($donasi->status === 'diterima') {
                                $catatanBg = 'bg-green-50 border-green-100 text-green-700';
                                $catatanTitle = 'text-green-800';
                            } elseif ($donasi->status === 'ditolak') {
                                $catatanBg = 'bg-red-50 border-red-100 text-red-700';
                                $catatanTitle = 'text-red-800';
                            }
                        @endphp
                        <div class="mt-6 p-4 rounded-xl border {{ $catatanBg }}">
                            <p class="text-xs font-bold mb-1 {{ $catatanTitle }}">Catatan Admin:</p>
                            <p class="text-sm leading-relaxed">{{ $donasi->catatan_admin }}</p>
                        </div>
                    @endif
                </div>

                <!-- Kanan: Bukti Pembayaran -->
                <div class="lg:col-span-1">
                    
                    @if($donasi->bukti_transfer)
                    <div class="rounded-[28px] border border-gray-200 bg-white p-10 shadow-sm flex flex-col h-full lg:col-span-2">
                        <h2 class="mt-2 text-xl font-bold text-gray-900 flex justify-between items-center mb-6">Bukti Pembayaran</h2>
                        <img src="{{ asset('storage/' . $donasi->bukti_transfer) }}" alt="Bukti Transfer" class="w-full object-cover rounded-2xl border border-gray-100">
                    </div>
                    @else
                        <div class="rounded-[28px] border border-gray-200 bg-white p-10 shadow-sm flex flex-col h-full lg:col-span-2">
                            <h2 class="mt-2 text-xl font-bold text-gray-900 flex justify-between items-center mb-6">Bukti Pembayaran</h2>
                            
                            <!-- Perubahan ada di class justify-start dan pt-8 -->
                            <div class="flex-grow flex flex-col items-center justify-start text-gray-400 pt-8">
                                <svg class="w-12 h-12 mb-3 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-sm font-medium">Tidak ada foto bukti</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @else
            <!-- Form Pencarian (Jika tidak ada Donasi/Kode) -->
            <section class="rounded-[28px] border border-gray-200 bg-white p-10 shadow-sm">

                <form action="{{ route('public.donasi.validasi') }}" method="GET" class="space-y-5">
                    <div>
                        <label class="text-sm font-bold text-gray-800">
                            Kunci Validasi <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="kode_donasi" value="{{ request('kode_donasi') }}" placeholder="Masukkan Kunci Validasi" class="mt-2 w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent text-sm" required>
                    </div>
                    <div class="flex gap-4 justify-center">
                        <button type="submit" class="inline-flex justify-center items-center rounded-full bg-brand-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-brand-700 shadow-sm">
                            Validasi
                        </button>
                    </div>
                </form>
            </section>
        @endif
    </div>
</div>

<script>
    function salinKunci(text) {
        navigator.clipboard.writeText(text).then(() => {
            showToast('Kunci berhasil disalin!', 'success');

            // Sembunyikan pesan penting (jika ada) setelah kunci disalin
            const infoBox = document.getElementById('infoBoxKunci');
            if (infoBox) {
                infoBox.classList.add('opacity-0', '-translate-y-2');
                setTimeout(() => {
                    infoBox.style.display = 'none';
                }, 300);
            }

        }).catch(err => {
            console.error('Gagal menyalin: ', err);
        });
    }
</script>
@endsection
