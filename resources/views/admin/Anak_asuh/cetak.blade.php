<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil / Biodata Anak Anak - LKSA Mawar Kasih</title>

    <style>
        @page {
            size: A4 portrait;
            margin: 8mm 10mm 7mm 10mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
            color: #111;
            margin: 0;
            padding: 0;
            line-height: 1.2;
        }

        /* HEADER - HANYA HALAMAN 1 */
        .header {
            text-align: center;
            margin-bottom: 4mm;
            padding-bottom: 3mm;
            border-bottom: 1.5px solid #222;
        }

        .header h1 {
            margin: 0;
            font-size: 17px;
            font-weight: bold;
            text-transform: uppercase;
            line-height: 1.15;
        }

        .header h2,
        .header h3 {
            margin: 1px 0 0;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            line-height: 1.15;
        }

        .header .tahun {
            margin-top: 2px;
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
        }

        /* BLOK 1 DATA ANAK
        4 BLOK = 1 HALAMAN */
        .child {
            width: 100%;
            height: 57mm;
            margin: 0 0 2mm 0;
            page-break-inside: avoid;
            overflow: hidden;
        }

        /* NOMOR */
        .number {
            float: left;
            width: 6%;
            padding-top: 2px;
            text-align: center;
            font-size: 12px;
            font-weight: bold;
        }

        /* FOTO 3:4
        45 x 55 mm */
        .photo-box {
            float: left;
            width: 45mm;
            height: 55mm;
            margin-right: 3%;
            overflow: hidden;
            border: 1px solid #bbb;
            background: #f3f4f6;
            text-align: center;
        }

        .photo {
            display: block;
            width: 45mm;
            height: 55mm;
            object-fit: cover;
        }

        .photo-placeholder {
            width: 45mm;
            height: 55mm;
            background: #f3f4f6;
            color: #999;
            text-align: center;
            padding-top: 24mm;
            font-size: 9px;
        }

        /* BIODATA */
        .info {
            float: left;
            width: 66%;
        }

        .row {
            width: 100%;
            margin-bottom: 2px;
            min-height: 11px;
        }

        .label {
            display: inline-block;
            width: 120px;
            vertical-align: top;
        }

        .separator {
            display: inline-block;
            width: 7px;
            text-align: center;
            vertical-align: top;
        }

        .value {
            vertical-align: top;
        }

        .section-title {
            margin-top: 3px;
            margin-bottom: 2px;
            font-weight: bold;
            text-transform: uppercase;
        }

        /* PEMISAH DATA */
        .child:not(:last-child) {
            border-bottom: 1px solid #d0d0d0;
            padding-bottom: 1.5mm;
        }

        /* PAGE BREAK */
        .page-break {
            page-break-after: always;
            height: 0;
        }
    </style>
</head>

<body>

    @php
        $tahunSekarang = now()->year;
    @endphp

    {{-- HEADER HANYA SEKALI --}}
    <div class="header">
        <h1>PROFIL / BIODATA ANAK ANAK</h1>
        <h2>LKSA MAWAR KASIH</h2>
        <h3>BANYUWANGI</h3>
        <div class="tahun">
            TAHUN AJARAN {{ $tahunSekarang }}
        </div>
    </div>

    @foreach($data as $item)

        <div class="child">

            {{-- NOMOR --}}
            <div class="number">
                {{ $loop->iteration }}
            </div>

            {{-- FOTO --}}
            <div class="photo-box">
                @if(!empty($item->foto))
                    <img
                        class="photo"
                        src="{{ public_path('storage/' . $item->foto) }}"
                        alt="Foto {{ $item->nama }}"
                    >
                @else
                    <div class="photo-placeholder">
                        FOTO ANAK
                    </div>
                @endif
            </div>

            {{-- DATA --}}
            <div class="info">

                <div class="row">
                    <span class="label">NAMA LENGKAP</span>
                    <span class="separator">:</span>
                    <span class="value">
                        {{ $item->nama ?? '-' }}
                    </span>
                </div>

                @if(!empty($item->nama_panggilan))
                    <div class="row">
                        <span class="label">NAMA PANGGILAN</span>
                        <span class="separator">:</span>
                        <span class="value">
                            {{ $item->nama_panggilan }}
                        </span>
                    </div>
                @endif

                <div class="row">
                    <span class="label">TEMPAT LAHIR</span>
                    <span class="separator">:</span>
                    <span class="value">
                        {{ $item->tempat_lahir ?? '-' }}
                    </span>
                </div>

                <div class="row">
                    <span class="label">TANGGAL LAHIR</span>
                    <span class="separator">:</span>
                    <span class="value">
                        @if(!empty($item->tanggal_lahir))
                            {{ \Carbon\Carbon::parse($item->tanggal_lahir)->locale('id')->translatedFormat('d F Y') }}
                            (UMUR {{ \Carbon\Carbon::parse($item->tanggal_lahir)->age }})
                        @else
                            -
                        @endif
                    </span>
                </div>

                <div class="section-title">
                    NAMA ORANG TUA
                </div>

                <div class="row">
                    <span class="label">AYAH</span>
                    <span class="separator">:</span>
                    <span class="value">
                        {{ $item->nama_ayah ?? '-' }}
                    </span>
                </div>

                <div class="row">
                    <span class="label">IBU</span>
                    <span class="separator">:</span>
                    <span class="value">
                        {{ $item->nama_ibu ?? '-' }}
                    </span>
                </div>

                <div class="row">
                    <span class="label">TINGGAL DI LKSA SEJAK</span>
                    <span class="separator">:</span>
                    <span class="value">
                        {{ $item->tinggal_sejak ?? $item->status_social_anak ?? '-' }}
                    </span>
                </div>

                <div class="row">
                    <span class="label">SEKOLAH</span>
                    <span class="separator">:</span>
                    <span class="value">
                        {{ $item->sekolah ?? '-' }}
                        @if(!empty($item->kelas))
                            KELAS {{ $item->kelas }}
                        @endif
                    </span>
                </div>

            </div>
        </div>

        {{-- SETIAP 4 DATA = HALAMAN BARU --}}
        @if($loop->iteration % 4 == 0 && !$loop->last)
            <div class="page-break"></div>
        @endif

    @endforeach

</body>
</html>
