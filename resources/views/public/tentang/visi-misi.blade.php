@extends('layouts.public')
@section('title', 'Visi & Misi — Panti Asuhan Mawar Kasih')

@section('content')
@include('components.public.page-header', ['title' => 'Visi & Misi'])
<div class="bg-gray-50 py-10 lg:py-16 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 md:p-12">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                
                <!-- Kiri: Tujuan (Menggantikan Motto) -->
                <div>
                    <h2 class="text-lg font-bold text-gray-900 mb-6 uppercase tracking-wide">Tujuan</h2>
                    
                    <ol class="list-decimal list-outside ml-5 space-y-4 text-gray-600 text-base leading-relaxed">
                        <li>Menyiapkan Sumber Daya Manusia Menjadi Pribadi Yang Mempunyai Kompetensi Keterampilan, Khususnya Dalam Bidang Teknologi Informasi Dan Komunikasi.</li>
                        <li>Menyiapkan Pribadi-Pribadi Yang Diharapkan Mampu Membuka Lapangan Kerja.</li>
                        <li>Memberikan Pembekalan Keterampilan Dalam Bidang Teknologi Informasi Dan Komunikasi Kepada anak asuh, Alumni Dan Masyarakat, Agar Lebih Siap Dalam Menyongsong Kemandirian Atau Memasuki Dunia Kerja.</li>
                        <li>Membantu Pemerintah Dalam Bidang Ketersediaan SDM Yang Mempunyai Skill.</li>
                    </ol>
                </div>

                <!-- Kanan: Visi & Misi -->
                <div class="space-y-10">
                    
                    <!-- Visi -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-4 uppercase tracking-wide">Visi</h3>
                        <ul class="list-disc list-outside ml-5 space-y-3 text-gray-600 text-sm md:text-base leading-relaxed">
                            <li>Meningkatkan kesejahteraan dan kemakmuran masyarakat sehingga tercapai cita cita masyarakat yang adil dan sejahtera.</li>
                            <li>Meningkatkan kualitas sumber daya manusia dan mencetak generasi bangsa yang profesional dan memiliki bertanggung jawab.</li>
                        </ul>
                    </div>

                    <!-- Misi -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-4 uppercase tracking-wide">Misi</h3>
                        <ul class="list-disc list-outside ml-5 space-y-3 text-gray-600 text-sm md:text-base leading-relaxed">
                            <li>Manjaring masyarakat secara umum dan khusus untuk dididik menjadi orang yang berkualitas dibidangnya masing masing.</li>
                            <li>Memberi pendidikan formal dan non formal.</li>
                            <li>Mengadakan Pelatihan kerja untuk anak anak muda juga orang dewasa.</li>
                            <li>Menghasilkan Tenaga - Tenaga Yang Memiliki Jiwa Wirausaha Mandiri.</li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection
