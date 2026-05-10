{{-- =========================================================================
     FOOTER — resources/views/public/layouts/footer.blade.php
     Dipakai oleh : resources/views/public/layouts/app.blade.php
     ========================================================================= --}}
<footer class="bg-gray-900 text-gray-300 mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-10">

            {{-- Brand --}}
            <div class="lg:col-span-2">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-primary-600 rounded-xl flex items-center justify-center text-white font-bold text-sm">MTK</div>
                    <div>
                        <p class="text-xs text-gray-400">Panti Asuhan</p>
                        <p class="text-base font-bold text-white" style="font-family:'Playfair Display',serif">Mawar Kasih</p>
                    </div>
                </div>
                <p class="text-sm text-gray-400 leading-relaxed mb-5">
                    Panti Asuhan Mawar Kasih berkomitmen untuk memberikan kasih sayang, pendidikan, dan pembinaan bagi anak-anak yang membutuhkan.
                </p>
                {{-- Sosial media --}}
                <div class="flex items-center gap-3">
                    <a href="#" class="w-9 h-9 rounded-full bg-gray-800 hover:bg-primary-600 flex items-center justify-center transition">
                        <i class="fa-brands fa-facebook-f text-sm"></i>
                    </a>
                    <a href="#" class="w-9 h-9 rounded-full bg-gray-800 hover:bg-primary-600 flex items-center justify-center transition">
                        <i class="fa-brands fa-instagram text-sm"></i>
                    </a>
                    <a href="#" class="w-9 h-9 rounded-full bg-gray-800 hover:bg-primary-600 flex items-center justify-center transition">
                        <i class="fa-brands fa-youtube text-sm"></i>
                    </a>
                    <a href="#" class="w-9 h-9 rounded-full bg-gray-800 hover:bg-primary-600 flex items-center justify-center transition">
                        <i class="fa-brands fa-whatsapp text-sm"></i>
                    </a>
                </div>
            </div>

            {{-- Menu --}}
            <div>
                <h4 class="text-white font-semibold mb-4">Menu</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('public.home') }}" class="hover:text-white transition">Beranda</a></li>
                    <li><a href="{{ route('public.kegiatan') }}" class="hover:text-white transition">Kegiatan</a></li>
                    <li><a href="{{ route('public.galeri') }}" class="hover:text-white transition">Galeri</a></li>
                </ul>
            </div>

            {{-- Donasi --}}
            <div>
                <h4 class="text-white font-semibold mb-4">Donasi</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('public.donasi') }}" class="hover:text-white transition">Form Donasi</a></li>
                    <li><a href="{{ route('public.donasi') }}#rekening" class="hover:text-white transition">Rekening Donasi</a></li>
                    <li><a href="{{ route('public.donasi') }}#cara" class="hover:text-white transition">Tutorial Berdonasi</a></li>
                    <li><a href="{{ route('public.donasi') }}#validasi" class="hover:text-white transition">Validasi Donasi (Opsional)</a></li>
                </ul>
            </div>

            {{-- Tentang & Kontak --}}
            <div>
                <h4 class="text-white font-semibold mb-4">Tentang Kami</h4>
                <ul class="space-y-2 text-sm mb-6">
                    <li><a href="{{ route('public.tentang') }}" class="hover:text-white transition">Profil Lembaga</a></li>
                    <li><a href="{{ route('public.tentang') }}#visi-misi" class="hover:text-white transition">Visi Misi</a></li>
                    <li><a href="{{ route('public.galeri') }}" class="hover:text-white transition">Galeri</a></li>
                    <li><a href="{{ route('public.tentang') }}#kontak" class="hover:text-white transition">Kontak</a></li>
                </ul>

                <h4 class="text-white font-semibold mb-3">Kontak Kami</h4>
                <ul class="space-y-2 text-sm">
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-location-dot mt-0.5 text-primary-400"></i>
                        Jl. Mawar No. 25, Kota Bandung, Jawa Barat 40225
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fa-solid fa-phone text-primary-400"></i>
                        0812-3456-7890
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fa-solid fa-envelope text-primary-400"></i>
                        info@mawarkasih.or.id
                    </li>
                </ul>
            </div>

        </div>
    </div>

    {{-- Bottom bar --}}
    <div class="border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-gray-500">
            <p>© {{ date('Y') }} Panti Asuhan Mawar Kasih. Semua Hak Dilindungi.</p>
            <div class="flex gap-4">
                <a href="#" class="hover:text-gray-300 transition">Kebijakan Privasi</a>
                <span>|</span>
                <a href="#" class="hover:text-gray-300 transition">Syarat &amp; Ketentuan</a>
            </div>
        </div>
    </div>
</footer>