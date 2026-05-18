<footer class="bg-brand-600 text-gray-300">

    {{-- ===== FOOTER MAIN ===== --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10">

            {{-- KOLOM 1: Brand --}}
            <div class="lg:col-span-2">
                {{-- Logo --}}
                <a href="{{ route('public.home') }}" class="flex items-center gap-3 mb-4">
                    <img src="{{ asset('images/logo.png') }}" alt="Mawar Kasih" class="h-11 w-auto brightness-200">
                    <div class="leading-tight">
                        <div class="text-xs text-gray-400 uppercase tracking-wider">Panti Asuhan</div>
                        <div class="text-lg font-bold text-white">Mawar Kasih</div>
                    </div>
                </a>

                {{-- Deskripsi singkat --}}
                <p class="text-sm text-gray-400 leading-relaxed mb-6 max-w-xs">
                    Panti Asuhan Mawar Kasih berkomitmen untuk memberikan kasih sayang, pendidikan, dan pembinaan bagi anak-anak yang membutuhkan.
                </p>

                {{-- ======================================================
                     SOSIAL MEDIA
                     Ganti href dengan URL profil sosial media Anda.
                     Hapus <a> yang tidak digunakan.
                ====================================================== --}}
                <div class="flex items-center gap-3">
                    {{-- Facebook --}}
                    <a href="https://facebook.com/mawarkasih" target="_blank" rel="noopener"
                        class="w-9 h-9 bg-gray-700 hover:bg-brand-600 rounded-lg flex items-center justify-center transition-colors"
                        aria-label="Facebook">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                    </a>
                    {{-- Instagram --}}
                    <a href="https://instagram.com/mawarkasih" target="_blank" rel="noopener"
                        class="w-9 h-9 bg-gray-700 hover:bg-brand-600 rounded-lg flex items-center justify-center transition-colors"
                        aria-label="Instagram">
                        <i data-lucide="instagram" class="w-4 h-4"></i>
                    </a>
                    {{-- YouTube --}}
                    <a href="https://youtube.com/@mawarkasih" target="_blank" rel="noopener"
                        class="w-9 h-9 bg-gray-700 hover:bg-brand-600 rounded-lg flex items-center justify-center transition-colors"
                        aria-label="YouTube">
                        <i data-lucide="youtube" class="w-4 h-4"></i>
                    </a>
                    {{-- WhatsApp --}}
                    <a href="https://wa.me/6281234567890" target="_blank" rel="noopener"
                        class="w-9 h-9 bg-gray-700 hover:bg-green-600 rounded-lg flex items-center justify-center transition-colors"
                        aria-label="WhatsApp">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                    </a>
                </div>
            </div>

            {{-- KOLOM 2: Menu --}}
            <div>
                <h4 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider">Menu</h4>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="{{ route('public.home') }}" class="hover:text-white hover:translate-x-1 transition-all inline-flex items-center gap-1">Beranda</a></li>
                    <li><a href="{{ route('public.kegiatan.index') }}" class="hover:text-white hover:translate-x-1 transition-all inline-flex items-center gap-1">Kegiatan</a></li>
                    <li><a href="{{ route('public.fasilitas') }}" class="hover:text-white hover:translate-x-1 transition-all inline-flex items-center gap-1">Fasilitas</a></li>
                    <li><a href="{{ route('public.galeri') }}" class="hover:text-white hover:translate-x-1 transition-all inline-flex items-center gap-1">Galeri</a></li>
                    <li><a href="{{ route('public.kontak') }}" class="hover:text-white hover:translate-x-1 transition-all inline-flex items-center gap-1">Kontak</a></li>
                </ul>
            </div>

            {{-- KOLOM 3: Donasi --}}
            <div>
                <h4 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider">Donasi</h4>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="{{ route('public.donasi.form') }}" class="hover:text-white transition-all">Form Donasi</a></li>
                    <li><a href="{{ route('public.donasi.rekening') }}" class="hover:text-white transition-all">Rekening Donasi</a></li>
                    <li><a href="{{ route('public.donasi.tutorial') }}" class="hover:text-white transition-all">Tutorial Berdonasi</a></li>
                    <li><a href="{{ route('public.donasi.validasi') }}" class="hover:text-white transition-all">Validasi Donasi (Opsional)</a></li>
                </ul>
            </div>

            {{-- KOLOM 4: Tentang Kami --}}
            <div>
                <h4 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider">Tentang Kami</h4>
                <ul class="space-y-2.5 text-sm mb-6">
                    <li><a href="{{ route('public.tentang.profil') }}" class="hover:text-white transition-all">Profil Lembaga</a></li>
                    <li><a href="{{ route('public.tentang.visi-misi') }}" class="hover:text-white transition-all">Visi & Misi</a></li>
                    <li><a href="{{ route('public.galeri') }}" class="hover:text-white transition-all">Galeri</a></li>
                    <li><a href="{{ route('public.kontak') }}" class="hover:text-white transition-all">Kontak</a></li>
                </ul>

                {{-- ======================================================
                     KONTAK INFO
                     Ubah alamat, nomor telepon, dan email di sini.
                ====================================================== --}}
                <h4 class="text-white font-semibold mb-3 text-sm uppercase tracking-wider">Kontak Kami</h4>
                <ul class="space-y-2.5 text-sm">
                    {{-- Alamat --}}
                    <li class="flex items-start gap-2">
                        <i data-lucide="map-pin" class="w-4 h-4 text-brand-400 mt-0.5 flex-shrink-0"></i>
                        <span>Jl. Mawar No. 25, Kota Bandung,<br>Jawa Barat 40225</span>
                    </li>
                    {{-- Telepon --}}
                    <li class="flex items-center gap-2">
                        <i data-lucide="phone" class="w-4 h-4 text-brand-400 flex-shrink-0"></i>
                        <a href="tel:+62081234567890" class="hover:text-white transition">0812-3456-7890</a>
                    </li>
                    {{-- Email --}}
                    <li class="flex items-center gap-2">
                        <i data-lucide="mail" class="w-4 h-4 text-brand-400 flex-shrink-0"></i>
                        <a href="mailto:info@mawarkasih.or.id" class="hover:text-white transition">info@mawarkasih.or.id</a>
                    </li>
                </ul>
            </div>

        </div>
    </div>

    {{-- ===== FOOTER BOTTOM ===== --}}
    <div class="bg-gray-900 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-gray-500">
            {{-- Copyright --}}
            <p>© {{ date('Y') }} Panti Asuhan Mawar Kasih. Semua Hak Dilindungi.</p>
            {{-- Legal links --}}
            <div class="flex items-center gap-4">
                <a href="{{ route('public.kebijakan') }}" class="hover:text-gray-300 transition">Kebijakan Privasi</a>
                <span>|</span>
                <a href="{{ route('public.syarat') }}" class="hover:text-gray-300 transition">Syarat &amp; Ketentuan</a>
            </div>
        </div>
    </div>

</footer>