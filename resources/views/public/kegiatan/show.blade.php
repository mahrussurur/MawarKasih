@extends('public.layouts.app')
@section('title', ($kegiatan->nama_kegiatan ?? 'Detail Kegiatan').' — Panti Asuhan Mawar Kasih')

@section('content')
<div class="bg-gray-50 py-10 lg:py-16 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 p-6 md:p-8 lg:p-10">
                    <!-- Gambar Kegiatan -->
                    <div class="rounded-[24px] overflow-hidden mb-6 md:mb-8 shadow-sm border border-gray-100">
                        @if($kegiatan->foto_dokumentasi)
                            <img src="{{ asset('storage/' . $kegiatan->foto_dokumentasi) }}" alt="{{ $kegiatan->nama_kegiatan }}" class="w-full h-80 md:h-[400px] object-cover">
                        @else
                            <div class="w-full h-80 md:h-[400px] bg-gray-200 flex items-center justify-center">
                                <svg class="w-16 h-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Detail Kegiatan -->
                    <div>
                        <div class="flex items-center gap-2 mb-3 text-gray-400">
                            <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                            <span class="font-medium text-sm">{{ \Carbon\Carbon::parse($kegiatan->tanggal_pelaksanaan)->translatedFormat('d F Y') }}</span>
                        </div>

                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6 leading-tight" style="font-family:'Playfair Display',serif">
                            {{ $kegiatan->nama_kegiatan }}
                        </h1>

                        <div class="prose prose-lg max-w-none prose-brand text-gray-700 leading-relaxed">
                            {!! nl2br(e($kegiatan->deskripsi)) !!}
                        </div>
                        
                        <div class="mt-10 pt-6 border-t border-gray-100 text-center">
                            <p class="text-gray-500 mb-4">Ingin mendukung kegiatan-kegiatan panti asuhan kami?</p>
                            <a href="{{ route('public.donasi.form') }}" class="inline-flex rounded-full bg-brand-600 px-8 py-3 text-sm font-semibold text-white transition hover:bg-brand-700 shadow-sm">
                                Donasi Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Search & Recent Posts -->
                <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 p-6 md:p-8">
                    <!-- Search -->
                    <div class="mb-8">
                        <h3 class="font-bold text-gray-800 text-lg mb-4">Search</h3>
                        <form action="{{ route('public.kegiatan.index') }}" method="GET" class="relative">
                            <input type="text" name="search" placeholder="Cari kegiatan..." class="w-full pl-4 pr-10 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent text-sm">
                            <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-brand-600">
                                <i data-lucide="search" class="w-5 h-5"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Recent Posts -->
                    @if($recent_kegiatans->count() > 0)
                    <div>
                        <h3 class="font-bold text-gray-800 text-lg mb-6">Recent Posts</h3>
                        <div class="space-y-5">
                            @foreach($recent_kegiatans as $recent)
                            <div class="flex gap-3 group items-center">
                                <a href="{{ route('public.kegiatan.show', $recent->id) }}" class="flex-shrink-0 w-24 h-16 rounded-lg overflow-hidden">
                                    @if($recent->foto_dokumentasi)
                                        <img src="{{ asset('storage/' . $recent->foto_dokumentasi) }}" class="w-full h-full object-cover" alt="{{ $recent->nama_kegiatan }}">
                                    @else
                                        <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                            <i data-lucide="image" class="w-5 h-5 text-gray-400"></i>
                                        </div>
                                    @endif
                                </a>
                                <div class="flex flex-col justify-center">
                                    <a href="{{ route('public.kegiatan.show', $recent->id) }}" class="font-bold text-gray-700 text-sm line-clamp-2 group-hover:text-brand-600 transition leading-snug">
                                        {{ $recent->nama_kegiatan }}
                                    </a>
                                    <span class="text-xs text-gray-400 mt-2 flex items-center gap-1.5">
                                        <i data-lucide="clock" class="w-3.5 h-3.5 opacity-70"></i>
                                        {{ \Carbon\Carbon::parse($recent->tanggal_pelaksanaan)->translatedFormat('d F Y') }}
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Daftar Donatur -->
                <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 p-6 md:p-8">
                    <h3 class="font-bold text-gray-800 text-lg mb-4">Daftar Donatur</h3>
                    
                    <!-- Search Input for Donaturs -->
                    <div class="mb-4 relative">
                        <input type="text" id="searchDonatur" placeholder="Cari donatur atau catatan..." class="w-full pl-4 pr-10 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent text-sm">
                        <div class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <i data-lucide="search" class="w-4 h-4"></i>
                        </div>
                    </div>

                    <div class="space-y-4 max-h-[500px] overflow-y-auto overflow-x-hidden pr-2" id="donaturList" style="scrollbar-width: thin; scrollbar-color: #E5E7EB transparent;">
                        @forelse($donaturs as $donatur)
                        <div class="bg-brand-100 rounded-2xl p-4 border border-gray-100 donatur-item">
                            <div class="flex justify-between items-start mb-2 gap-2">
                                <span class="font-bold text-gray-700 text-sm">
                                    @if($donatur->tampilkan_nama == 'hamba_allah')
                                        Hamba Allah
                                    @elseif($donatur->tampilkan_nama == 'anonim')
                                        Anonim
                                    @else
                                        {{ $donatur->nama_donatur }}
                                    @endif
                                </span>
                                <span class="text-xs text-gray-400 font-medium whitespace-nowrap mt-0.5">
                                    {{ \Carbon\Carbon::parse($donatur->tanggal)->format('d/m/Y') }}
                                </span>
                            </div>
                            <div class="font-bold text-gray-900 mb-2">
                                {{ $donatur->nominal_rupiah ?? 'Rp ' . number_format($donatur->nominal, 0, ',', '.') }}
                            </div>
                            @if($donatur->keterangan)
                            <p class="text-xs text-gray-500 italic leading-relaxed break-all">
                                "{{ $donatur->keterangan }}"
                            </p>
                            @endif
                        </div>
                        @empty
                        <div class="text-center text-gray-500 text-sm py-4">
                            Belum ada donatur.
                        </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@section('extra_scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchDonatur');
        const donaturItems = document.querySelectorAll('.donatur-item');
        
        if(searchInput) {
            searchInput.addEventListener('input', function(e) {
                const keyword = e.target.value.toLowerCase();
                
                donaturItems.forEach(item => {
                    const text = item.innerText.toLowerCase();
                    if(text.includes(keyword)) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        }
    });
</script>
@endsection
@endsection