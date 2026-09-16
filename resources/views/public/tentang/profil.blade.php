@extends('public.layouts.app')
@section('title', 'Profil Lembaga — Panti Asuhan Mawar Kasih')

@section('content')
@include('public.components.page-header', ['title' => 'Profil Lembaga'])
<div class="bg-gray-50 py-10 lg:py-16 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 md:p-12">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                
                <!-- Kiri: Legalitas -->
                <div>
                    <h2 class="text-lg font-bold text-gray-900 mb-6 uppercase tracking-wide">Legalitas LKSA Mawar Kasih Banyuwangi</h2>
                    
                    <div class="space-y-6 text-gray-600 text-sm md:text-base leading-relaxed">
                        <p>
                            <span class="font-medium">Akte Notaris:</span> Nomor 65, tanggal 20 September 2016 oleh ENDY INDRA PERMANA, S.H., M.Kn.
                        </p>
                        <p>
                            <span class="font-medium">SK Menkumham RI:</span> Nomor AHU-0074647.AH.01.07.TAHUN 2016, tanggal 28 September 2016
                        </p>
                        <p>
                            <span class="font-medium">NPWP:</span> 03.092.999.6-627.000
                        </p>
                        <p>
                            <span class="font-medium">STP Yayasan Nomor:</span> P2T/23/07.04/02/I/2014
                        </p>
                    </div>
                </div>

                <!-- Kanan: Profil -->
                <div>
                    <h2 class="text-lg font-bold text-gray-900 mb-6 uppercase tracking-wide">Profil Lembaga</h2>
                    
                    <div class="space-y-6 text-gray-600 text-sm md:text-base leading-relaxed">
                        <p>
                            Yayasan Mawar Kasih adalah lembaga sosial kemanusiaan di Kedunggebang, Banyuwangi, yang berfokus pada pengasuhan anak yatim, piatu, dan kurang mampu. Yayasan ini menyediakan tempat tinggal layak, pemenuhan kebutuhan dasar, serta pendampingan pendidikan dan karakter agar anak-anak asuh dapat tumbuh optimal secara fisik, mental, dan spiritual.
                        </p>
                        <p>
                            Kegiatan utama yayasan meliputi pengasuhan sehari-hari, program kesehatan dan kebersihan, aktivitas rohani, serta rekreasi untuk mengembangkan kreativitas anak.
                        </p>
                        <p>
                            Yayasan Mawar Kasih juga aktif menjalin kemitraan dengan donatur, relawan, dan institusi untuk memperluas dampak sosialnya.Kini, yayasan sedang mengembangkan sistem informasi digital untuk mengelola data anak asuh, pengurus, kegiatan, dan donasi secara lebih transparan dan efisien.
                        </p>
                        <p>
                            Melalui komitmen kasih dan profesionalisme, Yayasan Mawar Kasih berupaya menjadi rumah kedua yang hangat bagi anak-anak asuh serta mitra terpercaya bagi masyarakat yang ingin berkontribusi dalam karya kemanusiaan.
                        </p>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
