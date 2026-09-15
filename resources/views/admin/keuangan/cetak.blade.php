<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Keuangan</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 8mm 10mm 7mm 10mm;
        }
        * { box-sizing: border-box; }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
            color: #111;
            margin: 0;
            padding: 0;
            line-height: 1.2;
        }
        .header {
            text-align: center;
            margin-bottom: 4mm;
            padding-bottom: 3mm;
            border-bottom: 1.5px solid #222;
        }
        .header h1 { margin: 0; font-size: 17px; font-weight: bold; text-transform: uppercase; line-height: 1.15; }
        .header h2, .header h3 { margin: 1px 0 0; font-size: 14px; font-weight: bold; text-transform: uppercase; line-height: 1.15; }

        .info { margin-bottom: 8px; font-size: 11px; color: #444; }

        /* Summary Cards */
        .summary {
            display: table;
            width: 100%;
            margin-bottom: 6mm;
            border-collapse: separate;
            border-spacing: 4px 0;
        }
        .summary-card {
            display: table-cell;
            width: 33.33%;
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 8px 10px;
            background: #f9f9f9;
            vertical-align: middle;
        }
        .summary-card.saldo { background: #f0f4ff; border-color: #bfcfef; }
        .summary-card.masuk { background: #f0fdf4; border-color: #a7f3d0; }
        .summary-card.keluar { background: #fff1f2; border-color: #fca5a5; }
        .summary-card p { margin: 0; font-size: 10px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.05em; color: #555; }
        .summary-card .nilai { font-size: 13px; font-weight: bold; margin-top: 2px; }
        .summary-card.saldo .nilai { color: #1e3a8a; }
        .summary-card.masuk .nilai { color: #065f46; }
        .summary-card.keluar .nilai { color: #991b1b; }

        /* TABEL */
        table { width: 100%; border-collapse: collapse; margin-top: 4mm; margin-bottom: 5mm; }
        table th {
            background-color: #333;
            color: #fff;
            padding: 6px 8px;
            text-align: left;
            font-size: 11px;
            font-weight: bold;
            border: 1px solid #333;
        }
        table th.center, table td.center { text-align: center; }
        table th.right, table td.right { text-align: right; }
        table td { padding: 6px 8px; font-size: 11px; border: 1px solid #ccc; }
        tbody tr:nth-child(even) td { background-color: #f9f9f9; }

        .badge-masuk { color: #065f46; font-weight: bold; }
        .badge-keluar { color: #991b1b; font-weight: bold; }
        .badge-sistem { font-size: 10px; color: #6b7280; background: #f3f4f6; padding: 2px 6px; border-radius: 4px; }

        .total-row td {
            font-weight: bold;
            background-color: #f0f4ff !important;
            border-top: 2px solid #333;
            font-size: 12px;
        }

        .footer-cetak { margin-top: 10mm; text-align: right; }
        .ttd-box { display: inline-block; text-align: center; width: 180px; }
        .ttd-box p { font-size: 11px; color: #333; }
        .ttd-space { height: 55px; }
        .ttd-nama { font-weight: bold; font-size: 12px; color: #111; border-top: 1px solid #888; padding-top: 4px; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

    @php
        $totalPemasukan = $transaksi->where('jenis', 'pemasukan')->sum('nominal');
        $totalPengeluaran = $transaksi->where('jenis', 'pengeluaran')->sum('nominal');
        $saldo = $totalPemasukan - $totalPengeluaran;
    @endphp

    {{-- HEADER --}}
    <div class="header">
        <h1>LAPORAN DATA KEUANGAN</h1>
        <h2>LKSA MAWAR KASIH</h2>
        <h3>BANYUWANGI</h3>
    </div>

    {{-- INFO --}}
    <div class="info">
        <strong>Periode:</strong> {{ $tahun }} &nbsp;|&nbsp;
        <strong>Jenis:</strong> {{ $jenisLabel }} &nbsp;|&nbsp;
        <strong>Total Data:</strong> {{ $transaksi->count() }} transaksi &nbsp;|&nbsp;
        <strong>Dicetak:</strong> {{ now()->translatedFormat('d F Y, H:i') }}
    </div>

    {{-- TABEL --}}
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 13%;">Jenis</th>
                <th style="width: 20%;" class="right">Nominal</th>
                <th style="width: 35%;">Keterangan</th>
                <th style="width: 12%;" class="center">Sumber</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksi as $index => $item)
            <tr>
                <td class="center">{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}</td>
                <td>
                    @if($item->jenis === 'pemasukan')
                        <span class="badge-masuk">Pemasukan</span>
                    @else
                        <span class="badge-keluar">Pengeluaran</span>
                    @endif
                </td>
                <td class="right" style="font-weight: bold;">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                <td>{{ $item->keterangan }}</td>
                <td class="center">
                    @if($item->donasi_id)
                        <span class="badge-sistem">Donasi</span>
                    @else
                        <span class="badge-sistem">Manual</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center" style="padding: 20px; color: #999;">
                    Tidak ada data keuangan.
                </td>
            </tr>
            @endforelse

            {{-- Baris Total --}}
            @if($transaksi->count() > 0)
            <tr class="total-row">
                <td colspan="3" style="text-align: right;">TOTAL PEMASUKAN:</td>
                <td class="right">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
                <td colspan="2"></td>
            </tr>
            <tr class="total-row">
                <td colspan="3" style="text-align: right;">TOTAL PENGELUARAN:</td>
                <td class="right">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
                <td colspan="2"></td>
            </tr>
            <tr class="total-row">
                <td colspan="3" style="text-align: right;">SALDO AKHIR:</td>
                <td class="right" style="color: #1e3a8a;">Rp {{ number_format($saldo, 0, ',', '.') }}</td>
                <td colspan="2"></td>
            </tr>
            @endif
        </tbody>
    </table>

    {{-- TTD --}}
    <div class="footer-cetak">
        <div class="ttd-box">
            <p>Mengetahui,</p>
            <p>Bendahara LKSA Mawar Kasih</p>
            <div class="ttd-space"></div>
            <div class="ttd-nama">( ___________________ )</div>
        </div>
    </div>

</body>
</html>
