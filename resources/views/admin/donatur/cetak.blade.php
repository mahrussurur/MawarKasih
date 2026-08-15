<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Donatur</title>
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

        .info {
            margin-bottom: 15px;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            margin-bottom: 20px;
        }

        table th {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #333;
        }

        table td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 11px;
        }

    </style>
</head>
<body>
    @php
        $tahunSekarang = now()->year;
    @endphp

    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>LAPORAN DATA DONATUR</h1>
            <h2>LKSA MAWAR KASIH</h2>
            <h3>BANYUWANGI</h3>
            <div class="tahun">
                TAHUN AJARAN {{ $tahunSekarang }}
            </div>
        </div>

        <!-- Info -->
        <div class="info">
            <p><strong>Tanggal Laporan:</strong> {{ now()->format('d M Y H:i') }}</p>
            <p><strong>Total Donatur:</strong> {{ $data->count() }} orang</p>
        </div>

        <!-- Table -->
        <table>
            <thead>
                <tr>
                    <th class="text-center" style="width: 5%;">No</th>
                    <th style="width: 25%;">Nama</th>
                    <th style="width: 25%;">Email</th>
                    <th style="width: 15%;">No. HP</th>
                    <th style="width: 30%;">Alamat</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $index => $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->no_hp }}</td>
                        <td>{{ $item->alamat }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data donatur</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Footer -->
        <div class="footer">
            <p>Dicetak: {{ now()->format('d M Y H:i') }}</p>
        </div>
    </div>
</body>
</html>
