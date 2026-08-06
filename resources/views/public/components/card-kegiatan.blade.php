{{-- =========================================================================
     COMPONENT: Card Kegiatan
     File     : resources/views/public/components/card-kegiatan.blade.php
     Dipakai  : home.blade.php (section kegiatan terbaru)
                pages/kegiatan/index.blade.php (daftar kegiatan)

     Variable yang dibutuhkan:
       $kegiatan->id         : integer
       $kegiatan->nama       : string — nama / judul kegiatan
       $kegiatan->deskripsi  : string — deskripsi singkat
       $kegiatan->tanggal    : date   — tanggal pelaksanaan
       $kegiatan->kategori   : string — label kategori (Kegiatan Harian, Sosial, dll.)
       $kegiatan->foto       : string|null — path file di storage (nullable)

     Sambungan route:
       Detail kegiatan → route('public.kegiatan.show', $kegiatan->id)
                         controller: Public\KegiatanPublicController@show
     ========================================================================= --}}

<div class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition group">

    {{-- Foto kegiatan --}}
    {{-- Jika ada foto dari storage, gunakan: asset('storage/' . $kegiatan->foto) --}}
    <div class="relative h-44 overflow-hidden bg-gray-100">
        @if(!empty($kegiatan->foto))
            <img src="{{ asset('storage/' . $kegiatan->foto) }}"
                 alt="{{ $kegiatan->nama }}"
                 class="w-full h-full object-cover">
        @else
            {{-- Placeholder jika foto belum diisi admin --}}
            <div class="w-full h-full flex items-center justify-center bg-primary-50">
                <i class="fa-regular fa-image text-3xl text-primary-200"></i>
            </div>
        @endif
    </div>

    {{-- Konten --}}
    <div class="p-4">
        {{-- Tanggal --}}
        <p class="text-xs text-gray-400 mb-1">
            {{ \Carbon\Carbon::parse($kegiatan->tanggal)->locale('id')->isoFormat('D MMM YYYY') }}
        </p>

        {{-- Judul --}}
        <h3 class="font-bold text-gray-900 text-sm leading-snug mb-2 line-clamp-2">
            {{ $kegiatan->nama }}
        </h3>

        {{-- Deskripsi singkat --}}
        <p class="text-xs text-gray-500 leading-relaxed line-clamp-2 mb-3">
            {{ $kegiatan->deskripsi }}
        </p>

        {{-- Badge kategori --}}
        <span class="inline-block bg-primary-50 text-primary-700 text-xs font-semibold px-3 py-1 rounded-full">
            {{ $kegiatan->kategori ?? 'Kegiatan' }}
        </span>
    </div>
</div>
