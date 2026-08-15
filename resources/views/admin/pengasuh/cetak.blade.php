<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Pengasuh</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 8mm 10mm 7mm 10mm;
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
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; text-align: center; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    @php
        $tahunSekarang = now()->year;
    @endphp

    <div class="header">
        <h1>LAPORAN DATA PENGASUH</h1>
        <h2>LKSA MAWAR KASIH</h2>
        <h3>BANYUWANGI</h3>
        <div class="tahun">
            TAHUN AJARAN {{ $tahunSekarang }}
        </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Tempat Lahir</th>
                <th>Tanggal Lahir</th>
                <th>Alamat</th>
                <th>Jabatan</th>
                <th>Jenis Kelamin</th>
                <th>No. HP</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $key => $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->tempat_lahir ?? '-' }}</td>
                <td>{{ $item->tanggal_lahir ? \Carbon\Carbon::parse($item->tanggal_lahir)->format('d - m - Y') : '-' }}</td>
                <td>{{ $item->alamat ?? '-' }}</td>
                <td>{{ $item->jabatan }}</td>
                <td>{{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                <td>{{ $item->no_hp }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
