@extends('public.layouts.app')

@section('title', 'Beranda')
@section('meta_desc', 'Panti Asuhan Mawar Kasih - Menebar Kasih, Merangkai Harapan. Bersama kita hadirkan cinta, pendidikan, dan masa depan yang lebih baik untuk mereka.')

@section('content')

{{-- ============================================================
     1. HERO SECTION
     ─────────────────────────────────────────────────────────
     Background: Gambar foto anak-anak dengan overlay
     Kiri       : Teks tagline + 2 tombol CTA
     Kanan      : Foto utama

     CARA MODIFIKASI:
     - Ganti foto hero: ubah src pada <img> atau bg-image di style
     - Ubah judul: edit teks "Menebar Kasih," dan "Merangkai Harapan"
     - Ubah deskripsi: edit paragraf di bawah judul
     - Tombol: ubah teks & route pada kedua <a> tombol
     ============================================================ --}}
<section class="relative min-h-[560px] lg:min-h-[630px] overflow-hidden bg-gray-900">

    {{-- Background foto hero --}}
    {{--
        Ganti URL gambar di bawah dengan foto nyata.
        Simpan di: public/images/hero-bg.jpg
    --}}
    <img src="{{ asset('images/bg-login.jpg') }}"
        alt="Anak-anak Panti Asuhan Mawar Kasih"
        class="absolute inset-0 w-full h-full object-cover object-center opacity-60">

    {{-- Gradient overlay dari kiri --}}
    <div class="absolute inset-0 bg-gradient-to-r from-gray-900/85 via-gray-900/40 to-transparent"></div>

    {{-- Konten hero --}}
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center py-20">
        <div class="max-w-xl" data-aos="fade-right">

            {{-- Label kecil di atas judul --}}
            <span class="inline-block px-4 py-1.5 bg-white/10 backdrop-blur-sm border border-white/20 text-white text-xs font-semibold uppercase tracking-widest rounded-full mb-5">
                Lembaga Panti Asuhan Mawar Kasih
            </span>

            {{-- Judul utama --}}
            {{--
                Baris pertama: warna putih
                Baris kedua  : warna biru (brand-400) — warna utama
                Ganti teks di sini sesuai kebutuhan.
            --}}
            <h1 class="text-4xl sm:text-5xl lg:text-[3.4rem] font-extrabold !leading-tight text-white mb-5">
                Setiap Anak Berhak Memiliki<br>
                <span class="text-brand-400">Kasih Sayang.</span>
            </h1>

            {{-- Deskripsi pendek --}}
            <p class="text-gray-200 text-base sm:text-lg leading-relaxed mb-8">
                Bersama kita hadirkan cinta, pendidikan,<br class="hidden sm:block">
                dan masa depan yang lebih baik untuk mereka.
            </p>

            {{-- Tombol CTA --}}
            <div class="flex flex-wrap gap-3">
                {{-- Tombol primer: Donasi Sekarang --}}
                <a href="{{ route('public.donasi.form') }}"
                    class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-500 text-white font-semibold px-6 py-3 rounded-full transition-all duration-200 shadow-lg hover:shadow-brand-600/30 hover:-translate-y-0.5">
                    <i data-lucide="heart" class="w-4 h-4"></i>
                    Donasi Sekarang
                </a>
                {{-- Tombol sekunder: Lihat Kegiatan --}}
                <a href="{{ route('public.kegiatan.index') }}"
                    class="inline-flex items-center gap-2 bg-transparent border-2 border-white/60 hover:border-white text-white font-semibold px-6 py-3 rounded-full transition-all duration-200 hover:-translate-y-0.5">
                    Lihat Kegiatan
                </a>
            </div>

        </div>
    </div>
</section>


{{-- ============================================================
     2. STATISTIK SECTION
     ─────────────────────────────────────────────────────────
     4 angka statistik: Anak Asuh, Pengurus, Kegiatan, Donatur
     DATA: Dari variabel $stats yang dikirim controller.

     CARA MODIFIKASI:
     - Tambah statistik baru: duplikat salah satu <div> kolom
     - Ubah ikon: ganti value data-lucide
     - Ubah warna ikon background: ganti bg-brand-50 & text-brand-600
     - Ubah teks keterangan: edit paragraf di bawah angka

     FALLBACK: Jika $stats belum tersedia, gunakan ?? '0' sebagai default.
     ============================================================ --}}
<section class="py-10 bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8" data-aos="fade-up">

            {{-- Anak Asuh --}}
            <div class="flex items-center gap-4 p-4">
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i data-lucide="users" class="w-6 h-6 text-blue-600"></i>
                </div>
                <div>
                    {{-- Angka dari controller: $stats['totalAnakAsuh'] --}}
                    <div class="text-2xl font-extrabold text-gray-900">{{ $stats['totalAnakAsuh'] ?? '44' }}+</div>
                    <div class="text-sm font-semibold text-gray-700">Anak Asuh</div>
                    <div class="text-xs text-gray-400">sedang kami bina dengan kasih</div>
                </div>
            </div>

            {{-- Pengurus --}}
            <div class="flex items-center gap-4 p-4">
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i data-lucide="user-check" class="w-6 h-6 text-blue-600"></i>
                </div>
                <div>
                    {{-- Angka dari controller: $stats['totalPengasuh'] --}}
                    <div class="text-2xl font-extrabold text-gray-900">{{ $stats['totalPengasuh'] ?? '6' }}+</div>
                    <div class="text-sm font-semibold text-gray-700">Pengurus</div>
                    <div class="text-xs text-gray-400">berdedikasi melayani</div>
                </div>
            </div>

            {{-- Kegiatan Aktif --}}
            <div class="flex items-center gap-4 p-4">
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i data-lucide="calendar-check" class="w-6 h-6 text-blue-600"></i>
                </div>
                <div>
                    {{-- Angka dari controller: $stats['totalKegiatan'] --}}
                    <div class="text-2xl font-extrabold text-gray-900">{{ $stats['totalKegiatan'] ?? '10' }}+</div>
                    <div class="text-sm font-semibold text-gray-700">Kegiatan Aktif</div>
                    <div class="text-xs text-gray-400">sepanjang tahun</div>
                </div>
            </div>

            {{-- Donatur --}}
            <div class="flex items-center gap-4 p-4">
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i data-lucide="heart-handshake" class="w-6 h-6 text-blue-600"></i>
                </div>
                <div>
                    {{-- Angka dari controller: $stats['totalDonatur'] --}}
                    <div class="text-2xl font-extrabold text-gray-900">{{ $stats['totalDonatur'] ?? '0' }}+</div>
                    <div class="text-sm font-semibold text-gray-700">Donatur</div>
                    <div class="text-xs text-gray-400">berbagi kebaikan bersama kami</div>
                </div>
            </div>

        </div>
    </div>
</section>


{{-- ============================================================
     3. KEGIATAN SECTION
     ─────────────────────────────────────────────────────────
     Grid kartu kegiatan.
     DATA: $kegiatans — Collection semua kegiatan dari tabel kegiatan
           yang dikelola di panel admin.

     FIELD YANG DIAKSES:
     - $kegiatan->id
     - $kegiatan->judul
     - $kegiatan->tanggal_pelaksanaan  (format: Y-m-d)
     - $kegiatan->foto_dokumentasi      (path file, relatif dari storage)
     - $kegiatan->deskripsi_singkat
     - $kegiatan->kategori             (label: 'Kegiatan Harian', dll)

     CONTOH SEEDER / FACTORY:
     Kegiatan::create([
         'judul'               => 'Belajar Bersama',
         'tanggal_pelaksanaan' => '2024-05-18',
         'gambar'              => 'kegiatan/belajar.jpg',
         'deskripsi_singkat'   => 'Kegiatan belajar rutin...',
         'kategori'            => 'Kegiatan Harian',
     ]);
     ============================================================ --}}
<section class="py-14 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header section --}}
        <div class="flex items-center justify-between mb-8" data-aos="fade-up">
            <h2 class="text-2xl font-bold text-gray-900">Semua Kegiatan</h2>
            <a href="{{ route('public.kegiatan.index') }}"
                class="inline-flex items-center gap-1.5 text-sm font-semibold text-brand-600 hover:text-brand-700 transition group">
                Lihat Semua Kegiatan
                <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>

        {{-- Grid kartu kegiatan --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

            @forelse ($kegiatans ?? [] as $kegiatan)
            <article class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300 group"
                data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">

                {{-- Gambar kegiatan --}}
                <div class="aspect-[4/3] overflow-hidden bg-gray-100">
                    @if($kegiatan->foto_dokumentasi)
                        {{--
                            Foto dokumentasi disimpan di storage/app/public/kegiatan/
                            Pastikan sudah menjalankan: php artisan storage:link
                        --}}
                        <img src="{{ Storage::url($kegiatan->foto_dokumentasi) }}"
                            alt="{{ $kegiatan->judul }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                            loading="lazy">
                    @else
                        {{-- Placeholder jika gambar tidak tersedia --}}
                        <div class="w-full h-full flex items-center justify-center bg-brand-50">
                            <i data-lucide="image" class="w-10 h-10 text-brand-200"></i>
                        </div>
                    @endif
                </div>

                {{-- Konten kartu --}}
                <div class="p-4">
                    {{-- Tanggal --}}
                    <time class="text-xs text-gray-400 mb-1 block"
                        datetime="{{ \Carbon\Carbon::parse($kegiatan->tanggal_pelaksanaan)->format('Y-m-d') }}">
                        {{ \Carbon\Carbon::parse($kegiatan->tanggal_pelaksanaan)->translatedFormat('d F Y') }}
                    </time>
                    {{-- Judul --}}
                    <h3 class="font-bold text-gray-900 mb-1.5 line-clamp-2 group-hover:text-brand-600 transition-colors">
                        <a href="{{ route('public.kegiatan.show', $kegiatan->id) }}">
                            {{ $kegiatan->judul }}
                        </a>
                    </h3>
                    {{-- Deskripsi singkat --}}
                    <p class="text-xs text-gray-500 line-clamp-2 mb-3">
                        {{ $kegiatan->deskripsi_singkat }}
                    </p>
                    {{-- Badge kategori --}}
                    <span class="inline-block px-2.5 py-1 bg-brand-50 text-brand-700 text-xs font-medium rounded-full">
                        {{ $kegiatan->kategori ?? 'Kegiatan' }}
                    </span>
                </div>

            </article>
            @empty
            {{--
                TAMPILAN SAAT DATA KOSONG
                Ini muncul jika $kegiatans kosong atau null.
                Hapus/ubah sesuai kebutuhan.
            --}}
            <div class="lg:col-span-4 py-12 text-center text-gray-400">
                <i data-lucide="calendar-x" class="w-12 h-12 mx-auto mb-3 opacity-40"></i>
                <p class="text-sm">Belum ada kegiatan yang dipublikasikan.</p>
            </div>
            @endforelse

        </div>
    </div>
</section>


{{-- ============================================================
     4. FASILITAS SECTION
     ─────────────────────────────────────────────────────────
     Grid 8 kartu fasilitas panti — DATA STATIS (tidak dari DB).
     Fasilitas tidak dikelola dari admin, langsung ditulis di sini.

     CARA MODIFIKASI:
     - Tambah fasilitas: duplikat salah satu <article> di bawah
     - Ganti foto     : ubah src pada <img> di tiap kartu
     - Ubah nama      : edit teks di <figcaption>
     - Ubah ikon      : ganti data-lucide pada tiap kartu
     - Foto disimpan di: public/images/fasilitas/nama-file.jpg
     ============================================================ --}}
<section class="py-14 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header section --}}
        <div class="flex items-center justify-between mb-8" data-aos="fade-up">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Fasilitas Panti</h2>
                <p class="text-sm text-gray-500 mt-1">(Sarana &amp; Prasarana)</p>
            </div>
            {{-- Link ke halaman detail semua fasilitas --}}
            <a href="{{ route('public.fasilitas') }}"
                class="inline-flex items-center gap-1.5 text-sm font-semibold text-brand-600 hover:text-brand-700 transition group">
                Lihat Semua Fasilitas
                <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>

        {{-- Grid 4 kolom fasilitas --}}
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            {{-- ======================================================
                 KARTU FASILITAS — STATIS
                 Duplikat blok <article> berikut untuk menambah fasilitas.
                 Ganti: src gambar, data-lucide ikon, dan nama fasilitas.
            ====================================================== --}}

            {{-- 1. Asrama Putra --}}
            <article class="relative rounded-xl overflow-hidden group cursor-pointer"
                data-aos="zoom-in" data-aos-delay="0"
                onclick="openFasilitasModal('Asrama Putra', 'Kamar tidur bersih dan nyaman untuk anak-anak putra. Dilengkapi tempat tidur susun, lemari penyimpanan, ventilasi yang baik, dan area belajar bersama.', '{{ asset('images/fasilitas/asrama-putra.jpg') }}')">
                <div class="aspect-[4/3] bg-gray-100">
                    <img src="{{ asset('images/fasilitas/asrama-putra.jpg') }}"
                        alt="Asrama Putra"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                </div>
                {{-- Overlay label --}}
                <figcaption class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent px-3 py-2.5">
                    <div class="flex items-center gap-1.5">
                        <i data-lucide="bed" class="w-3.5 h-3.5 text-white"></i>
                        <span class="text-white text-sm font-semibold">Asrama Putra</span>
                    </div>
                </figcaption>
            </article>

            {{-- 2. Asrama Putri --}}
            <article class="relative rounded-xl overflow-hidden group cursor-pointer"
                data-aos="zoom-in" data-aos-delay="60"
                onclick="openFasilitasModal('Asrama Putri', 'Kamar tidur bersih dan aman untuk anak-anak putri. Dilengkapi fasilitas serupa asrama putra dengan area privasi yang terjaga.', '{{ asset('images/fasilitas/asrama-putri.jpg') }}')">
                <div class="aspect-[4/3] bg-gray-100">
                    <img src="{{ asset('images/fasilitas/asrama-putri.jpg') }}"
                        alt="Asrama Putri"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                </div>
                <figcaption class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent px-3 py-2.5">
                    <div class="flex items-center gap-1.5">
                        <i data-lucide="bed-single" class="w-3.5 h-3.5 text-white"></i>
                        <span class="text-white text-sm font-semibold">Asrama Putri</span>
                    </div>
                </figcaption>
            </article>

            {{-- 3. Ruang Belajar --}}
            <article class="relative rounded-xl overflow-hidden group cursor-pointer"
                data-aos="zoom-in" data-aos-delay="120"
                onclick="openFasilitasModal('Ruang Belajar', 'Ruang belajar yang nyaman dan kondusif. Dilengkapi meja, kursi, papan tulis, rak buku, dan pencahayaan yang baik untuk mendukung aktivitas belajar anak.', '{{ asset('images/fasilitas/ruang-belajar.jpg') }}')">
                <div class="aspect-[4/3] bg-gray-100">
                    <img src="{{ asset('images/fasilitas/ruang-belajar.jpg') }}"
                        alt="Ruang Belajar"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                </div>
                <figcaption class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent px-3 py-2.5">
                    <div class="flex items-center gap-1.5">
                        <i data-lucide="book-open" class="w-3.5 h-3.5 text-white"></i>
                        <span class="text-white text-sm font-semibold">Ruang Belajar</span>
                    </div>
                </figcaption>
            </article>

            {{-- 4. Ruang Komputer --}}
            <article class="relative rounded-xl overflow-hidden group cursor-pointer"
                data-aos="zoom-in" data-aos-delay="180"
                onclick="openFasilitasModal('Ruang Komputer', 'Laboratorium komputer yang dilengkapi unit PC terbaru. Digunakan untuk belajar teknologi informasi, mengetik, dan mengakses materi pendidikan digital.', '{{ asset('images/fasilitas/ruang-komputer.jpg') }}')">
                <div class="aspect-[4/3] bg-gray-100">
                    <img src="{{ asset('images/fasilitas/ruang-komputer.jpg') }}"
                        alt="Ruang Komputer"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                </div>
                <figcaption class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent px-3 py-2.5">
                    <div class="flex items-center gap-1.5">
                        <i data-lucide="monitor" class="w-3.5 h-3.5 text-white"></i>
                        <span class="text-white text-sm font-semibold">Ruang Komputer</span>
                    </div>
                </figcaption>
            </article>

            {{-- 5. Ruang Makan --}}
            <article class="relative rounded-xl overflow-hidden group cursor-pointer"
                data-aos="zoom-in" data-aos-delay="0"
                onclick="openFasilitasModal('Ruang Makan', 'Ruang makan bersama yang luas dan bersih. Menjadi tempat anak-anak berkumpul, makan bersama, dan mempererat kebersamaan setiap harinya.', '{{ asset('images/fasilitas/ruang-makan.jpg') }}')">
                <div class="aspect-[4/3] bg-gray-100">
                    <img src="{{ asset('images/fasilitas/ruang-makan.jpg') }}"
                        alt="Ruang Makan"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                </div>
                <figcaption class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent px-3 py-2.5">
                    <div class="flex items-center gap-1.5">
                        <i data-lucide="utensils" class="w-3.5 h-3.5 text-white"></i>
                        <span class="text-white text-sm font-semibold">Ruang Makan</span>
                    </div>
                </figcaption>
            </article>

            {{-- 6. Dapur --}}
            <article class="relative rounded-xl overflow-hidden group cursor-pointer"
                data-aos="zoom-in" data-aos-delay="60"
                onclick="openFasilitasModal('Dapur', 'Dapur bersih dan higienis untuk menyiapkan makanan bergizi bagi seluruh anak asuh. Dilengkapi peralatan memasak lengkap dan area cuci yang memadai.', '{{ asset('images/fasilitas/dapur.jpg') }}')">
                <div class="aspect-[4/3] bg-gray-100">
                    <img src="{{ asset('images/fasilitas/dapur.jpg') }}"
                        alt="Dapur"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                </div>
                <figcaption class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent px-3 py-2.5">
                    <div class="flex items-center gap-1.5">
                        <i data-lucide="chef-hat" class="w-3.5 h-3.5 text-white"></i>
                        <span class="text-white text-sm font-semibold">Dapur</span>
                    </div>
                </figcaption>
            </article>

            {{-- 7. Mushola --}}
            <article class="relative rounded-xl overflow-hidden group cursor-pointer"
                data-aos="zoom-in" data-aos-delay="120"
                onclick="openFasilitasModal('Mushola', 'Mushola yang bersih, nyaman, dan representatif untuk kegiatan ibadah sehari-hari. Digunakan untuk sholat berjamaah, mengaji, dan kegiatan keagamaan lainnya.', '{{ asset('images/fasilitas/mushola.jpg') }}')">
                <div class="aspect-[4/3] bg-gray-100">
                    <img src="{{ asset('images/fasilitas/mushola.jpg') }}"
                        alt="Mushola"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                </div>
                <figcaption class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent px-3 py-2.5">
                    <div class="flex items-center gap-1.5">
                        <i data-lucide="moon" class="w-3.5 h-3.5 text-white"></i>
                        <span class="text-white text-sm font-semibold">Mushola</span>
                    </div>
                </figcaption>
            </article>

            {{-- 8. Halaman & Lapangan --}}
            <article class="relative rounded-xl overflow-hidden group cursor-pointer"
                data-aos="zoom-in" data-aos-delay="180"
                onclick="openFasilitasModal('Halaman & Lapangan', 'Halaman luas dan lapangan olahraga untuk bermain, berolahraga, dan beraktivitas di luar ruangan. Mendukung tumbuh kembang fisik dan kegembiraan anak-anak.', '{{ asset('images/fasilitas/lapangan.jpg') }}')">
                <div class="aspect-[4/3] bg-gray-100">
                    <img src="{{ asset('images/fasilitas/lapangan.jpg') }}"
                        alt="Halaman dan Lapangan"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                </div>
                <figcaption class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent px-3 py-2.5">
                    <div class="flex items-center gap-1.5">
                        <i data-lucide="tree-pine" class="w-3.5 h-3.5 text-white"></i>
                        <span class="text-white text-sm font-semibold">Halaman &amp; Lapangan</span>
                    </div>
                </figcaption>
            </article>

        </div>
    </div>
</section>


{{-- ============================================================
     5. CTA BANNER SECTION
     ─────────────────────────────────────────────────────────
     Banner ajakan untuk berdonasi — di atas footer.
     Berisi foto anak-anak, teks ajakan, dan 2 tombol.

     CARA MODIFIKASI:
     - Ganti foto banner: ubah src pada <img>
     - Ubah teks judul: edit 2 baris h2
     - Ubah deskripsi: edit paragraf
     - Tombol 1 (Donasi Sekarang): ubah route
     - Tombol 2 (Lihat Cara Berdonasi): ubah route
     ============================================================ --}}
<section class="py-14 bg-brand-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative bg-white rounded-2xl overflow-hidden shadow-md" data-aos="fade-up">

            {{-- Background foto ringan di kanan --}}
            <div class="absolute right-0 top-0 bottom-0 w-1/2 hidden md:block">
                <img src="{{ asset('images/logo.png') }}"
                    alt="Anak-anak Mawar Kasih"
                    class="w-full h-full object-cover object-center opacity-90">
                {{-- Overlay gradient dari kiri --}}
                <div class="absolute inset-0 bg-gradient-to-r from-white via-white/70 to-transparent"></div>
            </div>

            {{-- Konten teks --}}
            <div class="relative px-8 py-12 lg:px-14 lg:py-16 max-w-lg">
                <h2 class="text-3xl lg:text-4xl font-extrabold text-gray-900 leading-tight mb-4">
                    Mari Jadi Bagian dari<br>
                    <span class="text-brand-600">Perubahan Mereka</span>
                </h2>
                <p class="text-gray-500 text-sm lg:text-base leading-relaxed mb-8">
                    Setiap bantuan Anda sangat berarti untuk masa depan anak-anak Panti Asuhan Mawar Kasih.
                </p>
                <div class="flex flex-col sm:flex-row gap-3">
                    {{-- Tombol utama --}}
                    <a href="{{ route('public.donasi.form') }}"
                        class="inline-flex items-center justify-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold px-7 py-3.5 rounded-full transition shadow-lg hover:shadow-brand-600/30">
                        <i data-lucide="heart" class="w-4 h-4"></i>
                        Donasi Sekarang
                    </a>
                    {{-- Tombol sekunder --}}
                    <a href="{{ route('public.donasi.tutorial') }}"
                        class="inline-flex items-center gap-1.5 text-brand-600 font-semibold hover:text-brand-700 transition self-center">
                        Lihat Cara Berdonasi
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>


{{-- ============================================================
     MODAL DETAIL FASILITAS
     ─────────────────────────────────────────────────────────
     Modal ini terbuka saat kartu fasilitas diklik.
     Menampilkan: foto besar, nama, dan deskripsi fasilitas.

     Dikontrol oleh fungsi openFasilitasModal() di bawah.
     Tidak perlu diubah kecuali ingin mengubah tampilan modal.
     ============================================================ --}}
<div id="fasilitasModal"
    class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 opacity-0 invisible transition-all duration-300"
    onclick="closeFasilitasModal(event)">

    <div class="bg-white rounded-2xl overflow-hidden max-w-lg w-full shadow-2xl transform scale-95 transition-transform duration-300" id="fasilitasModalBox">
        {{-- Foto fasilitas (besar) --}}
        <div class="aspect-video bg-gray-100">
            <img id="fasilitasModalImg" src="" alt="" class="w-full h-full object-cover">
        </div>
        {{-- Konten modal --}}
        <div class="p-6">
            <h3 id="fasilitasModalTitle" class="text-xl font-bold text-gray-900 mb-2"></h3>
            <p id="fasilitasModalDesc" class="text-gray-500 text-sm leading-relaxed mb-5"></p>
            {{-- Tombol tutup --}}
            <button onclick="closeFasilitasModal()"
                class="w-full bg-brand-600 hover:bg-brand-700 text-white font-semibold py-2.5 rounded-xl transition">
                Tutup
            </button>
        </div>
    </div>

</div>

@endsection


@section('extra_scripts')
<script>
    // ======================================================
    // MODAL FASILITAS
    // Fungsi untuk membuka dan menutup modal detail fasilitas.
    // Dipanggil dari atribut onclick pada kartu fasilitas.
    // ======================================================

    /**
     * Buka modal fasilitas
     * @param {string} nama  - Nama fasilitas (judul modal)
     * @param {string} desc  - Deskripsi fasilitas
     * @param {string} imgSrc - URL gambar fasilitas
     */
    function openFasilitasModal(nama, desc, imgSrc) {
        document.getElementById('fasilitasModalTitle').textContent = nama;
        document.getElementById('fasilitasModalDesc').textContent = desc;
        document.getElementById('fasilitasModalImg').src = imgSrc;
        document.getElementById('fasilitasModalImg').alt = nama;

        const modal = document.getElementById('fasilitasModal');
        const box = document.getElementById('fasilitasModalBox');
        modal.classList.remove('opacity-0', 'invisible');
        modal.classList.add('opacity-100', 'visible');
        box.classList.remove('scale-95');
        box.classList.add('scale-100');
        document.body.style.overflow = 'hidden'; // cegah scroll background
    }

    /**
     * Tutup modal fasilitas
     * Bisa dipanggil saat klik tombol tutup atau klik di luar modal.
     */
    function closeFasilitasModal(event) {
        // Jika klik di dalam box modal, jangan tutup
        if (event && event.target !== document.getElementById('fasilitasModal')) return;

        const modal = document.getElementById('fasilitasModal');
        const box = document.getElementById('fasilitasModalBox');
        modal.classList.add('opacity-0', 'invisible');
        modal.classList.remove('opacity-100', 'visible');
        box.classList.add('scale-95');
        box.classList.remove('scale-100');
        document.body.style.overflow = ''; // kembalikan scroll
    }

    // Tutup modal dengan tombol Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeFasilitasModal();
    });
</script>
@endsection