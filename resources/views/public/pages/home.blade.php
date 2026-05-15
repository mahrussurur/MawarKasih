{{-- =========================================================================
     HOME — resources/views/public/pages/home.blade.php
     Controller : App\Http\Controllers\Public\HomeController@index
     Data yang di-pass controller:
       - $kegiatanTerbaru  : koleksi Kegiatan (4 terbaru) dari model Kegiatan
       - $totalAnakAsuh    : integer, total baris dari model AnakAsuh
       - $totalPengasuh    : integer, total baris dari model Pengasuh
       - $totalKegiatan    : integer, total baris dari model Kegiatan
       - $totalDonatur     : integer, total baris dari model Donasi (unik donatur)
     ========================================================================= --}}

@extends('public.layouts.app')

@section('title', 'Beranda — Panti Asuhan Mawar Kasih')
@section('meta_description', 'Menebar Kasih, Merangkai Harapan. Bersama kita hadirkan cinta, pendidikan, dan masa depan yang lebih baik.')

@section('content')

{{-- =========================================================================
     SECTION 1 : HERO
     ========================================================================= --}}
<section class="relative min-h-[90vh] flex items-center overflow-hidden bg-gray-900">

    {{-- Background image — ganti URL dengan foto nyata dari storage --}}
    {{-- Contoh: style="background-image:url('{{ asset('storage/hero.jpg') }}')" --}}
    <div class="absolute inset-0 bg-cover bg-center opacity-40"
         style="background-image:url('https://images.unsplash.com/photo-1594608661623-aa0bd3a69799?w=1400&auto=format&fit=crop')">
    </div>

    {{-- Overlay gradient --}}
    <div class="absolute inset-0 bg-gradient-to-r from-gray-950 via-gray-900/80 to-transparent"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="max-w-xl">
            {{-- Label --}}
            <span class="animate-fade-up inline-block bg-white/10 backdrop-blur text-white text-xs font-semibold px-4 py-1.5 rounded-full border border-white/20 mb-6 tracking-widest uppercase">
                Panti Asuhan Mawar Kasih
            </span>

            {{-- Heading --}}
            <h1 class="animate-fade-up delay-100 text-4xl sm:text-5xl lg:text-6xl font-bold text-white leading-tight mb-4"
                style="font-family:'Playfair Display',serif">
                Menebar Kasih,<br>
                <span class="text-primary-400">Merangkai Harapan</span>
            </h1>

            {{-- Sub --}}
            <p class="animate-fade-up delay-200 text-gray-300 text-lg leading-relaxed mb-8">
                Bersama kita hadirkan cinta, pendidikan, dan masa depan yang lebih baik untuk mereka.
            </p>

            {{-- CTA --}}
            <div class="animate-fade-up delay-300 flex flex-wrap gap-3">
                {{-- route public.donasi — controller: Public\DonasiPublicController@index --}}
                <a href="{{ route('public.donasi') }}"
                   class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-500 text-white font-semibold px-6 py-3 rounded-full transition">
                    <i class="fa-regular fa-heart"></i> Donasi Sekarang
                </a>
                {{-- route public.kegiatan — controller: Public\KegiatanPublicController@index --}}
                <a href="{{ route('public.kegiatan') }}"
                   class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 backdrop-blur text-white font-semibold px-6 py-3 rounded-full border border-white/30 transition">
                    Lihat Kegiatan
                </a>
            </div>
        </div>
    </div>
</section>

{{-- =========================================================================
     SECTION 2 : STATISTIK
     Data: $totalAnakAsuh, $totalPengasuh, $totalKegiatan, $totalDonatur
     ========================================================================= --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10 relative z-10">
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 grid grid-cols-2 lg:grid-cols-4 divide-x divide-y lg:divide-y-0 divide-gray-100">

        {{-- Stat item komponen: icon, angka, label --}}
        @php
            $stats = [
                ['icon' => 'fa-solid fa-children',      'value' => ($totalAnakAsuh ?? 42).'+'  , 'label' => 'Anak Asuh',      'sub' => 'sedang kami bina dengan kasih'],
                ['icon' => 'fa-solid fa-hands-holding-heart', 'value' => ($totalPengasuh ?? 15).'+', 'label' => 'Pengurus', 'sub' => 'berdedikasi melayani'],
                ['icon' => 'fa-regular fa-calendar-check', 'value' => ($totalKegiatan ?? 28).'+', 'label' => 'Kegiatan Aktif', 'sub' => 'sepanjang tahun'],
                ['icon' => 'fa-solid fa-users',          'value' => ($totalDonatur ?? 120).'+'  , 'label' => 'Donatur',        'sub' => 'berbagi kebaikan bersama kami'],
            ];
        @endphp

        @foreach($stats as $s)
        <div class="flex items-center gap-4 px-6 py-6">
            <div class="w-12 h-12 rounded-full bg-primary-50 flex items-center justify-center text-primary-600 flex-shrink-0">
                <i class="{{ $s['icon'] }} text-xl"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $s['value'] }}</p>
                <p class="text-sm font-semibold text-gray-700">{{ $s['label'] }}</p>
                <p class="text-xs text-gray-400">{{ $s['sub'] }}</p>
            </div>
        </div>
        @endforeach

    </div>
</section>

{{-- =========================================================================
     SECTION 3 : KEGIATAN TERBARU
     Data: $kegiatanTerbaru — koleksi model Kegiatan (4 item, ordered by created_at desc)
     Kolom yang dipakai: id, nama, deskripsi, tanggal, kategori, foto (path storage)
     ========================================================================= --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-20">

    {{-- Header section --}}
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900" style="font-family:'Playfair Display',serif">
            Kegiatan Terbaru
        </h2>
        {{-- route public.kegiatan — controller: Public\KegiatanPublicController@index --}}
        <a href="{{ route('public.kegiatan') }}"
           class="text-primary-600 font-semibold text-sm hover:underline flex items-center gap-1">
            Lihat Semua Kegiatan <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

    {{-- Grid kegiatan --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

        {{-- Loop data dari controller --}}
        @forelse($kegiatanTerbaru ?? [] as $kegiatan)
        @include('public.components.card-kegiatan', ['kegiatan' => $kegiatan])
        @empty
        {{-- Placeholder jika data kosong (hapus saat sudah ada data nyata) --}}
        @foreach(range(1,4) as $i)
        <div class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm">
            <div class="h-44 bg-gray-200 animate-pulse"></div>
            <div class="p-4">
                <div class="h-3 bg-gray-200 rounded animate-pulse mb-2"></div>
                <div class="h-5 bg-gray-300 rounded animate-pulse mb-2"></div>
                <div class="h-3 bg-gray-200 rounded animate-pulse w-3/4"></div>
            </div>
        </div>
        @endforeach
        @endforelse

    </div>
</section>

{{-- =========================================================================
     SECTION 4 : FASILITAS PANTI
     CATATAN: Fasilitas TIDAK dikelola admin — data hardcode di view ini.
     Jika suatu saat ingin dikelola, tambahkan tabel & model Fasilitas.
     ========================================================================= --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-20">

    <div class="flex items-center justify-between mb-8">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900" style="font-family:'Playfair Display',serif">
            Fasilitas Panti <span class="text-gray-400 text-lg font-normal">(Sarana &amp; Prasarana)</span>
        </h2>
        {{-- Belum ada halaman tersendiri; arahkan ke tentang --}}
        <a href="{{ route('public.tentang') }}#fasilitas"
           class="text-primary-600 font-semibold text-sm hover:underline flex items-center gap-1">
            Lihat Semua Fasilitas <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

    {{-- Grid fasilitas — data statis karena tidak dikelola admin --}}
    @php
        $fasilitas = [
            ['nama' => 'Asrama Putra',       'icon' => 'fa-solid fa-bed',         'img' => 'https://images.unsplash.com/photo-1555854877-bab0e564b8d5?w=400&auto=format&fit=crop'],
            ['nama' => 'Asrama Putri',       'icon' => 'fa-solid fa-person-dress', 'img' => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=400&auto=format&fit=crop'],
            ['nama' => 'Ruang Belajar',      'icon' => 'fa-solid fa-book-open',   'img' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=400&auto=format&fit=crop'],
            ['nama' => 'Ruang Komputer',     'icon' => 'fa-solid fa-desktop',     'img' => 'https://images.unsplash.com/photo-1562774053-701939374585?w=400&auto=format&fit=crop'],
            ['nama' => 'Ruang Makan',        'icon' => 'fa-solid fa-utensils',    'img' => 'https://images.unsplash.com/photo-1567521464027-f127ff144326?w=400&auto=format&fit=crop'],
            ['nama' => 'Dapur',              'icon' => 'fa-solid fa-kitchen-set', 'img' => 'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=400&auto=format&fit=crop'],
            ['nama' => 'Mushola',            'icon' => 'fa-solid fa-mosque',      'img' => 'https://images.unsplash.com/photo-1564769610726-59cead6a6f8f?w=400&auto=format&fit=crop'],
            ['nama' => 'Halaman &amp; Lapangan', 'icon' => 'fa-solid fa-futbol', 'img' => 'https://images.unsplash.com/photo-1518002054494-3a6f94352e9d?w=400&auto=format&fit=crop'],
        ];
    @endphp

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($fasilitas as $f)
        <div class="relative rounded-2xl overflow-hidden group cursor-default">
            <img src="{{ $f['img'] }}" alt="{{ $f['nama'] }}"
                 class="w-full h-40 object-cover group-hover:scale-105 transition duration-500">
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/70 to-transparent"></div>
            <div class="absolute bottom-0 left-0 right-0 p-3 flex items-center gap-2">
                <i class="{{ $f['icon'] }} text-white text-sm"></i>
                <span class="text-white text-sm font-semibold">{!! $f['nama'] !!}</span>
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- =========================================================================
     SECTION 5 : CTA DONASI BANNER
     ========================================================================= --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-20">
    <div class="relative overflow-hidden rounded-3xl bg-primary-700 px-8 py-12 flex flex-col lg:flex-row items-center justify-between gap-8">

        {{-- Lingkaran dekoratif --}}
        <div class="absolute -top-10 -left-10 w-48 h-48 bg-primary-600 rounded-full opacity-50"></div>
        <div class="absolute -bottom-10 right-40 w-64 h-64 bg-primary-800 rounded-full opacity-40"></div>

        {{-- Foto anak — ganti dengan asset nyata jika ada --}}
        <div class="hidden lg:block absolute right-0 top-0 bottom-0 w-72 overflow-hidden">
            <img src="/images/logo.png"
                 alt="Anak asuh" class="h-full w-full object-cover opacity-30">
        </div>

        <div class="relative text-white max-w-lg">
            <h2 class="text-2xl sm:text-3xl font-bold mb-3" style="font-family:'Playfair Display',serif">
                Mari Jadi Bagian dari<br>Perubahan Mereka
            </h2>
            <p class="text-primary-200 text-sm leading-relaxed">
                Setiap bantuan Anda sangat berarti untuk masa depan anak-anak Panti Asuhan Mawar Kasih.
            </p>
        </div>

        <div class="relative flex flex-col sm:flex-row gap-3 flex-shrink-0">
            <a href="{{ route('public.donasi') }}"
               class="inline-flex items-center gap-2 bg-white text-primary-700 font-semibold px-6 py-3 rounded-full hover:bg-primary-50 transition">
                <i class="fa-regular fa-heart"></i> Donasi Sekarang
            </a>
            <a href="{{ route('public.donasi') }}#cara"
               class="inline-flex items-center gap-2 border border-white/40 text-white font-semibold px-6 py-3 rounded-full hover:bg-white/10 transition">
                Lihat Cara Berdonasi <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

@endsection