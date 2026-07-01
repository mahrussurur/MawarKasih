@extends('public.layouts.app')
@section('title', 'Kontak — Panti Asuhan Mawar Kasih')

@section('content')
<div class="bg-gray-50 py-20 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 md:p-12">
            <!-- Peta Lokasi (Tetap Full Width di Atas) -->
            <div class="w-full h-[400px] md:h-[500px] rounded-2xl overflow-hidden shadow-md mb-12 border border-gray-200">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3947.6756857106093!2d114.31072737583626!3d-8.49132609154944!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd3fbf2a718c7cb%3A0xc856a6741baaf690!2sPanti%20Asuhan%20Mawar%20Kasih!5e0!3m2!1id!2sid!4v1700000000000!5m2!1sid!2sid" 
                    width="100%" 
                    height="100%" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>

            <!-- Detail Kontak (PERBAIKAN: Diperkecil & Lebih Rapat) -->
            <div class="max-w-2xl flex flex-col space-y-7">
                
                <!-- Alamat -->
                <div class="flex items-start gap-4">
                    <!-- Ukuran lingkaran ikon dikecilkan dari w-14 h-14 ke w-11 h-11 -->
                    <div class="w-11 h-11 bg-gray-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <i data-lucide="map-pin" class="w-5 h-5 text-gray-600"></i>
                    </div>
                    <div>
                        <!-- Judul turun ke text-lg, teks deskripsi turun ke text-sm -->
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">Panti Asuhan Mawar Kasih</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">
                            G857+F87, Unnamed Road, Bayatrejo, Kedunggebang, Kec. Tegaldlimo, Kabupaten Banyuwangi, Jawa Timur 68484
                        </p>
                    </div>
                </div>

                <!-- Email -->
                <div class="flex items-start gap-4">
                    <div class="w-11 h-11 bg-gray-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <i data-lucide="mail" class="w-5 h-5 text-gray-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">Email</h3>
                        <a href="mailto:pantimawarkasih@gmail.com" class="text-gray-500 hover:text-brand-600 text-sm transition-colors">
                            pantimawarkasih@gmail.com
                        </a>
                    </div>
                </div>

                <!-- WhatsApp -->
                <div class="flex items-start gap-4">
                    <div class="w-11 h-11 bg-gray-100 rounded-full flex-shrink-0 flex items-center justify-center">
                        <i data-lucide="phone" class="w-5 h-5 text-gray-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">WhatsApp</h3>
                        <div class="flex items-center gap-1.5 text-sm">
                            <a href="https://wa.me/6282334208165" target="_blank" rel="noopener noreferrer" class="text-green-600 hover:text-green-700 transition-colors font-medium">
                                +6282334208165
                            </a>
                            <p class="text-gray-500">(Bpk. Masduki)</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection