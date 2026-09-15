<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Kegiatan</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 8mm 10mm 7mm 10mm;
        }
        * { box-sizing: border-box; }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #111;
            margin: 0;
            padding: 0;
            line-height: 1.3;
        }
        .header {
            text-align: center;
            margin-bottom: 4mm;
            padding-bottom: 3mm;
            border-bottom: 1.5px solid #222;
        }
        .header h1 { margin: 0; font-size: 16px; font-weight: bold; text-transform: uppercase; }
        .header h2 { margin: 2px 0 0; font-size: 13px; font-weight: bold; text-transform: uppercase; }
        .info { margin-bottom: 8px; font-size: 11px; color: #444; }
        table { width: 100%; border-collapse: collapse; margin-top: 4mm; margin-bottom: 5mm; }
        table th {
            background-color: #333;
            color: #fff;
            padding: 6px 8px;
            font-size: 11px;
            font-weight: bold;
            border: 1px solid #333;
            text-align: left;
        }
        table td {
            padding: 6px 8px;
            font-size: 11px;
            border: 1px solid #ccc;
        }
        tbody tr:nth-child(even) td { background-color: #f9f9f9; }
        .footer-cetak { margin-top: 10mm; text-align: right; }
        .ttd-box { display: inline-block; text-align: center; width: 180px; }
        .ttd-box p { font-size: 11px; color: #333; }
        .ttd-space { height: 55px; }
        .ttd-nama { font-weight: bold; font-size: 12px; border-top: 1px solid #888; padding-top: 4px; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

    <div class="header">
        <h1>LAPORAN DATA KEGIATAN</h1>
        <h2>LKSA MAWAR KASIH — BANYUWANGI</h2>
    </div>

    <div class="info">
        <strong>Periode:</strong> {{ $tahun }} &nbsp;|&nbsp;
        <strong>Total Data:</strong> {{ $kegiatans->count() }} kegiatan &nbsp;|&nbsp;
        <strong>Dicetak:</strong> {{ now()->translatedFormat('d F Y, H:i') }}
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:5%;">No</th>
                <th style="width:30%;">Nama Kegiatan</th>
                <th style="width:20%;">Tanggal Pelaksanaan</th>
                <th style="width:45%;">Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kegiatans as $i => $kegiatan)
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td style="font-weight:bold;">{{ $kegiatan->nama_kegiatan }}</td>
                <td>{{ \Carbon\Carbon::parse($kegiatan->tanggal_pelaksanaan)->translatedFormat('d F Y') }}</td>
                <td>{{ \Illuminate\Support\Str::limit(strip_tags($kegiatan->deskripsi), 120) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center" style="padding:20px;color:#999;">Tidak ada data kegiatan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer-cetak">
        <div class="ttd-box">
            <p>Mengetahui,</p>
            <p>Pengurus LKSA Mawar Kasih</p>
            <div class="ttd-space"></div>
            <div class="ttd-nama">( ___________________ )</div>
        </div>
    </div>

</body>
</html>
