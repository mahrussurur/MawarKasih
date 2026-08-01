@extends('public.layouts.app')

@section('title', 'Rekening Donasi')

@section('content')
@include('public.components.page-header', ['title' => 'Rekening Donasi'])
<div class="bg-gray-50 py-10 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="rounded-3xl border border-gray-200 bg-white p-6 md:p-10 shadow-sm text-center">

            <div class="flex flex-col md:flex-row divide-y-2 md:divide-y-0 md:divide-x-2 divide-gray-200 items-center max-w-5xl mx-auto">
                <!-- Kiri: QRIS -->
                <div class="flex-1 flex justify-center md:justify-end w-full pb-8 md:pb-0 md:pr-16">
                    @if(file_exists(public_path('images/qris-mawarkasih.jpg')))
                        <img src="{{ asset('images/qris-mawarkasih.jpg') }}" alt="QRIS Panti Asuhan Mawar Kasih" class="w-full max-w-[280px] object-contain rounded-xl shadow-sm border border-gray-200">
                    @else
                        <div class="w-full max-w-[280px] aspect-square flex flex-col items-center justify-center bg-gray-50 rounded-xl border border-dashed border-gray-300 p-6 text-center">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center text-gray-400 mb-3">
                                <i data-lucide="qr-code" class="w-8 h-8"></i>
                            </div>
                            <p class="text-sm font-semibold text-gray-700 mb-1">QRIS Belum Tersedia</p>
                            <p class="text-xs text-gray-400 max-w-[180px] leading-relaxed">
                                Metode pembayaran via QRIS saat ini belum diaktifkan.
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Kanan: Rekening -->
                <div class="flex-1 space-y-5 text-left w-full pt-8 md:pt-0 md:pl-16">
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

@section('extra_scripts')
<script>
    function salinNomor(text) {
        navigator.clipboard.writeText(text).then(() => {
            showToast('Nomor rekening berhasil disalin!', 'success');
        }).catch(err => {
            console.error('Gagal menyalin: ', err);
        });
    }
</script>
@endsection
@endsection
