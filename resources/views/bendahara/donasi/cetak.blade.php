<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Donasi</title>
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

        /* HEADER */
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

        /* INFO */
        .info {
            margin-bottom: 8px;
            font-size: 11px;
            color: #444;
        }

        /* TABEL */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4mm;
            margin-bottom: 5mm;
        }
        table th {
            background-color: #333;
            color: #fff;
            padding: 6px 8px;
            text-align: left;
            font-size: 11px;
            font-weight: bold;
            border: 1px solid #333;
        }
        table th.center,
        table td.center {
            text-align: center;
        }
        table td {
            padding: 6px 8px;
            font-size: 11px;
            border: 1px solid #ccc;
        }
        tbody tr:nth-child(even) td {
            background-color: #f9f9f9;
        }

        /* BARIS TOTAL */
        .total-row td {
            font-weight: bold;
            background-color: #f0fdf4 !important;
            border-top: 2px solid #333;
            font-size: 12px;
        }

        /* FOOTER TTD */
        .footer-cetak {
            margin-top: 10mm;
            text-align: right;
        }
        .ttd-box {
            display: inline-block;
            text-align: center;
            width: 180px;
        }
        .ttd-box p {
            font-size: 11px;
            color: #333;
        }
        .ttd-space {
            height: 55px;
        }
        .ttd-nama {
            font-weight: bold;
            font-size: 12px;
            color: #111;
            border-top: 1px solid #888;
            padding-top: 4px;
        }

        .text-center { text-align: center; }
    </style>
</head>
<body>

    @php
        $tahunSekarang = now()->year;
    @endphp

    {{-- HEADER --}}
    <div class="header">
        <h1>LAPORAN DATA DONASI</h1>
        <h2>LKSA MAWAR KASIH</h2>
        <h3>BANYUWANGI</h3>
    </div>

    {{-- INFO --}}
    <div class="info">
        <strong>Periode:</strong> {{ $tahun }} &nbsp;|&nbsp;
        <strong>Total Data:</strong> {{ $donasi->count() }} donasi &nbsp;|&nbsp;
        <strong>Dicetak:</strong> {{ now()->translatedFormat('d F Y, H:i') }}
    </div>

    {{-- TABEL --}}
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 13%;">Kode Donasi</th>
                <th style="width: 28%;">Nama Donatur</th>
                <th style="width: 15%;">No. HP</th>
                <th style="width: 18%;">Nominal</th>
                <th style="width: 21%;">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($donasi as $index => $item)
            <tr>
                <td class="center">{{ $index + 1 }}</td>
                <td style="font-weight: bold;">{{ $item->kode_donasi }}</td>
                <td>{{ $item->nama_donatur }}</td>
                <td>{{ $item->no_hp ?? '-' }}</td>
                <td style="font-weight: bold;">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center" style="padding: 20px; color: #999;">
                    Tidak ada data donasi valid.
                </td>
            </tr>
            @endforelse

            {{-- Baris Total --}}
            @if($donasi->count() > 0)
            <tr class="total-row">
                <td colspan="4" style="text-align: right;">TOTAL NOMINAL DITERIMA:</td>
                <td colspan="2" style="font-size: 13px;">
                    Rp {{ number_format($totalNominal, 0, ',', '.') }}
                </td>
            </tr>
            @endif
        </tbody>
    </table>

    {{-- TTD --}}
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
