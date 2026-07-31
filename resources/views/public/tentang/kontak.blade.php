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

            <!-- Detail Kontak -->
            <div class="max-w-2xl grid grid-cols-1 gap-2">
                
                <!-- Alamat -->
                <div class="group flex items-start gap-4 p-4 rounded-2xl -ml-4">
                    <div class="w-11 h-11 bg-brand-50 text-brand-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm">
                        <i data-lucide="map-pin" class="w-5 h-5"></i>
                    </div>
                    <div class="pt-0.5">
                        <h3 class="text-[15px] font-semibold text-slate-800 mb-1.5 leading-none">Panti Asuhan Mawar Kasih</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">
                            G857+F87, Unnamed Road, Bayatrejo, Kedunggebang, Kec. Tegaldlimo, Kabupaten Banyuwangi, Jawa Timur 68484
                        </p>
                    </div>
                </div>

                <!-- Email -->
                <div class="group flex items-start gap-4 p-4 rounded-2xl -ml-4">
                    <div class="w-11 h-11 bg-brand-50 text-brand-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm">
                        <i data-lucide="mail" class="w-5 h-5"></i>
                    </div>
                    <div class="pt-0.5">
                        <h3 class="text-[15px] font-semibold text-slate-800 mb-1.5 leading-none">Email</h3>
                        <a href="mailto:pantimawarkasih@gmail.com" class="text-slate-500 hover:text-brand-600 transition-colors">
                            pantimawarkasih@gmail.com
                        </a>
                    </div>
                </div>

                <!-- WhatsApp -->
                <div class="group flex items-start gap-4 p-4 rounded-2xl -ml-4">
                    <div class="w-11 h-11 bg-green-50 text-green-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm">
                        <i data-lucide="phone" class="w-5 h-5"></i>
                    </div>
                    <div class="pt-0.5">
                        <h3 class="text-[15px] font-semibold text-slate-800 mb-1.5 leading-none">WhatsApp</h3>
                        <div class="flex items-center gap-2 mt-1">
                            <a href="https://wa.me/6282334208165" target="_blank" rel="noopener noreferrer" class="text-green-600 hover:text-green-700 transition-colors text-sm font-medium">
                                +6282334208165
                            </a>
                            <span class="text-slate-500 text-sm font-medium">(Bpk. Masduki)</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection