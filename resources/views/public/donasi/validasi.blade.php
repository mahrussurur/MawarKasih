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
                        <input type="text" name="kode_donasi" value="{{ request('kode_donasi') }}" placeholder="Masukkan Kunci Validasi" class="mt-2 w-full px-4 py-3 rounded-lg text-sm text-gray-900 border border-gray-300 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300" required>
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

<!-- Elemen Notifikasi Toast - Posisi Atas Tengah -->
<div id="toastNotifikasi" class="fixed top-6 left-1/2 -translate-x-1/2 flex items-center gap-2 bg-green-600 text-white px-5 py-3 rounded-lg shadow-lg transform transition-all duration-300 -translate-y-4 opacity-0 pointer-events-none z-50">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
    </svg>
    <span id="toastMessage" class="text-sm font-medium whitespace-nowrap">Berhasil!</span>
</div>

<script>
    function showToast(message, type = 'success') {
        const toast = document.getElementById('toastNotifikasi');
        const toastMessage = document.getElementById('toastMessage');
        const iconPath = toast.querySelector('path');
        
        toastMessage.textContent = message;
        
        toast.classList.remove('bg-green-600', 'bg-red-600');
        
        if (type === 'error') {
            toast.classList.add('bg-red-600');
            iconPath.setAttribute('d', 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z');
        } else {
            toast.classList.add('bg-green-600');
            iconPath.setAttribute('d', 'M5 13l4 4L19 7');
        }
        
        // Tampilkan notifikasi (turun dari atas)
        toast.classList.remove('-translate-y-4', 'opacity-0');
        toast.classList.add('translate-y-0', 'opacity-100');
        
        // Sembunyikan kembali setelah 3.5 detik
        setTimeout(() => {
            toast.classList.remove('translate-y-0', 'opacity-100');
            toast.classList.add('-translate-y-4', 'opacity-0');
        }, 3500);
    }

    function salinKunci(text) {
        navigator.clipboard.writeText(text).then(() => {
            showToast('Kunci berhasil disalin!');
            
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

    // Jika ada session success atau error, tampilkan notifikasi saat halaman dimuat
    @if(session('success'))
        document.addEventListener('DOMContentLoaded', function() {
            showToast("{{ session('success') }}", 'success');
        });
    @endif

    @if(session('error'))
        document.addEventListener('DOMContentLoaded', function() {
            showToast("{{ session('error') }}", 'error');
        });
    @endif
</script>
@endsection
