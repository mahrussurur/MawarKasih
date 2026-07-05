@extends('public.layouts.app')

@section('title', 'Profil Donatur')

@section('content')
<div class="min-h-screen bg-gray-50 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">

        <div class="grid gap-6 lg:grid-cols-1">
            <div class="rounded-3xl border border-gray-200 bg-white p-8 shadow-sm">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Informasi Pribadi</h2>
                <div class="space-y-5 text-sm text-gray-700">
                    <div>
                        <p class="text-xs text-gray-500">Nama Lengkap</p>
                        <p class="mt-2 font-semibold text-gray-900">{{ $donatur->nama }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Email</p>
                        <p class="mt-2 font-semibold text-gray-900">{{ $donatur->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Nomor HP</p>
                        <p class="mt-2 font-semibold text-gray-900">{{ $donatur->no_hp }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Alamat</p>
                        <p class="mt-2 font-semibold text-gray-900">{{ $donatur->alamat }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Status Donatur</p>
                        <p class="mt-2 inline-flex rounded-full bg-green-100 px-3 py-1 text-sm font-semibold text-green-700">{{ ucfirst($donatur->status) }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl border border-gray-200 bg-white p-8 shadow-sm">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Aksi Cepat</h2>
                <div class="space-y-4">
                    <a href="{{ route('public.donatur.history') }}" class="block rounded-3xl border border-brand-600 bg-brand-50 px-5 py-4 text-sm font-semibold text-brand-700 transition hover:bg-brand-100">Lihat Riwayat Donasi</a>
                    <form action="{{ route('public.donatur.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full rounded-3xl bg-red-500 px-5 py-4 text-sm font-semibold text-white transition hover:bg-red-600">Logout</button>
                    </form>
                </div>
            </div>
        </div>
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
