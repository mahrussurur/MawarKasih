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
                    G857+F87, Unnamed Road, Bayatrejo, Kedunggebang, Kec. Tegaldlimo, Kabupaten Banyuwangi, Jawa Timur 68484
                </p>

            </div>

            {{-- KOLOM 2: Menu --}}
            <div>
                <h4 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider">Menu</h4>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="{{ route('public.home') }}" class="hover:text-white hover:translate-x-1 transition-all inline-flex items-center gap-1">Beranda</a></li>
                    <li><a href="{{ route('public.kegiatan.index') }}" class="hover:text-white hover:translate-x-1 transition-all inline-flex items-center gap-1">Kegiatan</a></li>
                    <li><a href="{{ route('public.donasi.rekening') }}" class="hover:text-white hover:translate-x-1 transition-all inline-flex items-center gap-1">Donasi</a></li>
                    <li><a href="{{ route('public.donasi.registrasi') }}" class="hover:text-white hover:translate-x-1 transition-all inline-flex items-center gap-1">Registrasi</a></li>
                </ul>
            </div> 

            {{-- KOLOM 4: Tentang Kami --}}
            <div>
                <h4 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider">Tentang Kami</h4>
                <ul class="space-y-2.5 text-sm mb-6">
                    <li><a href="{{ route('public.tentang.profil') }}" class="hover:text-white hover:translate-x-1 transition-all inline-flex items-center gap-1">Profil Lembaga</a></li>
                    <li><a href="{{ route('public.tentang.visi-misi') }}" class="hover:text-white hover:translate-x-1 transition-all inline-flex items-center gap-1">Visi & Misi</a></li>
                    <li><a href="{{ route('public.galeri.index') }}" class="hover:text-white hover:translate-x-1 transition-all inline-flex items-center gap-1">Galeri</a></li>
                    <li><a href="{{ route('public.kontak') }}" class="hover:text-white hover:translate-x-1 transition-all inline-flex items-center gap-1">Kontak</a></li>
                </ul>
            </div>

            {{-- KOLOM 5: Sosial Media --}}
            <div>
                <h4 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider">Sosial Media</h4>
                <ul class="space-y-2.5 text-sm mb-6">
                <div class="flex items-center gap-3">

                    {{-- Facebook --}}
                    <a href="" target="_blank" rel="noopener"
                        class="w-9 h-9 bg-gray-900 hover:bg-brand-600 rounded-lg flex items-center justify-center transition-colors duration-400 shadow-lg hover:shadow-gray-900/30 hover:-translate-y-0.5"
                        aria-label="Facebook">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
                        </svg>
                    </a>

                    {{-- Instagram --}}
                    <a href="" target="_blank" rel="noopener"
                        class="w-9 h-9 bg-gray-900 hover:bg-gradient-to-r hover:from-pink-500 hover:to-blue-500 rounded-lg flex items-center justify-center transition-colors duration-400 shadow-lg hover:shadow-gray-900/30 hover:-translate-y-0.5"
                        aria-label="Instagram">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                            <path d="M7.75 2C4.57 2 2 4.57 2 7.75v8.5C2 19.43 4.57 22 7.75 22h8.5C19.43 22 22 19.43 22 16.25v-8.5C22 4.57 19.43 2 16.25 2h-8.5zm0 2h8.5C18.33 4 20 5.67 20 7.75v8.5C20 18.33 18.33 20 16.25 20h-8.5C5.67 20 4 18.33 4 16.25v-8.5C4 5.67 5.67 4 7.75 4zm8.75 1.5a1.25 1.25 0 1 0 0 2.5 1.25 1.25 0 0 0 0-2.5zM12 7a5 5 0 1 0 0 10 5 5 0 0 0 0-10zm0 2a3 3 0 1 1 0 6 3 3 0 0 1 0-6z"/>
                        </svg>
                    </a>                
                    
                    {{-- YouTube --}}
                    <a href="" target="_blank" rel="noopener"
                        class="w-9 h-9 bg-gray-900 hover:bg-red-600 rounded-lg flex items-center justify-center transition-colors duration-400 shadow-lg hover:shadow-gray-900/30 hover:-translate-y-0.5"
                        aria-label="YouTube">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                            <path d="M21.8 8s-.2-1.4-.8-2c-.8-.8-1.7-.8-2.1-.9C15.9 4.8 12 4.8 12 4.8h0s-3.9 0-6.9.3c-.4.1-1.3.1-2.1.9-.6.6-.8 2-.8 2S2 9.6 2 11.2v1.5C2 14.4 2.2 16 2.2 16s.2 1.4.8 2c.8.8 1.9.8 2.4.9 1.7.2 6.6.3 6.6.3s3.9 0 6.9-.3c.4-.1 1.3-.1 2.1-.9.6-.6.8-2 .8-2s.2-1.6.2-3.3v-1.5C22 9.6 21.8 8 21.8 8ZM10 15.3V8.7l5.7 3.3L10 15.3Z"/>
                        </svg>
                    </a>

                    {{-- WhatsApp --}}
                    <a href="" target="_blank" rel="noopener"
                        class="w-9 h-9 bg-gray-900 hover:bg-green-600 rounded-lg flex items-center justify-center transition-colors duration-400 shadow-lg hover:shadow-gray-900/30 hover:-translate-y-0.5"
                        aria-label="WhatsApp">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                    </a>

                </div>
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