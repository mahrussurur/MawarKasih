@extends('public.layouts.app')

@section('title', 'Rekening Donasi')

@section('content')
<div class="bg-gray-50 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="rounded-3xl border border-gray-200 bg-white p-10 shadow-sm text-center">
            <div class="text-start mb-10">
                <h1 class="mt-2 text-xl font-bold text-gray-900">Rekening Donasi</h1>
            </div>

            <div class="flex flex-col md:flex-row divide-y-2 md:divide-y-0 md:divide-x-2 divide-gray-200 items-center max-w-5xl mx-auto mt-6">
                <!-- Kiri: QRIS -->
                <div class="flex-1 flex justify-center md:justify-end w-full p-6 md:pr-16 md:py-8">
                    <img src="{{ asset('images/qris-barcode.jpg') }}" alt="QRIS Panti Asuhan Mawar Kasih" class="w-full max-w-[280px] object-contain rounded-xl shadow-sm border border-gray-200">
                </div>

                <!-- Kanan: Rekening -->
                <div class="flex-1 space-y-5 text-left w-full p-6 md:pl-16 md:py-8">
                    <h3 class="text-base text-gray-800">Rekening Donasi Panti Asuhan Mawar Kasih:</h3>
                    
                    <ul class="space-y-4">
                        <li class="flex items-center gap-3 text-gray-800">
                            <span class="font-bold w-16">Mandiri:</span> 
                            <span class="font-mono text-base tracking-wide">143-00-2888931 7</span>
                            <button onclick="salinNomor('1430028889317')" class="text-gray-400 hover:text-gray-600 transition" title="Salin Rekening">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                            </button>
                        </li>
                    </ul>
                    
                    <p class="mt-4 text-sm text-gray-600">a.n. Panti Asuhan Mawar Kasih</p>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Elemen Notifikasi Toast -->
<div id="toastNotifikasi" class="fixed top-6 left-1/2 -translate-x-1/2 flex items-center gap-2 bg-green-600 text-white px-5 py-3 rounded-lg shadow-lg transform transition-all duration-300 -translate-y-4 opacity-0 pointer-events-none z-50">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
    </svg>
    <span id="toastMessage" class="text-sm font-medium whitespace-nowrap">Berhasil!</span>
</div>

@section('extra_scripts')
<script>
    function showToast(message) {
        const toast = document.getElementById('toastNotifikasi');
        const toastMessage = document.getElementById('toastMessage');
        
        toastMessage.textContent = message;
        
        toast.classList.remove('-translate-y-4', 'opacity-0');
        toast.classList.add('translate-y-0', 'opacity-100');
        
        setTimeout(() => {
            toast.classList.remove('translate-y-0', 'opacity-100');
            toast.classList.add('-translate-y-4', 'opacity-0');
        }, 3500);
    }

    function salinNomor(text) {
        navigator.clipboard.writeText(text).then(() => {
            showToast('Nomor rekening berhasil disalin!');
        }).catch(err => {
            console.error('Gagal menyalin: ', err);
        });
    }
</script>
@endsection
@endsection
