<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Alumni - LKSA Mawar Kasih</title>

    <style>
        @page {
            size: A4 landscape;
            margin: 10mm 10mm 8mm 10mm;
        }

        * { box-sizing: border-box; }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            color: #111;
            margin: 0;
            padding: 0;
            line-height: 1.3;
        }

        .header {
            text-align: center;
            margin-bottom: 5mm;
            padding-bottom: 3mm;
            border-bottom: 1.5px solid #222;
        }

        .header h1 {
            margin: 0;
            font-size: 15px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .header h2, .header h3 {
            margin: 2px 0 0;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .meta {
            margin-top: 3px;
            font-size: 9px;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2mm;
        }

        thead th {
            background-color: #1d4ed8;
            color: #fff;
            padding: 4px 5px;
            text-align: left;
            font-size: 9px;
            border: 1px solid #1e40af;
        }

        tbody td {
            padding: 3px 5px;
            border: 1px solid #d1d5db;
            font-size: 9px;
            vertical-align: top;
        }

        tbody tr:nth-child(even) {
            background-color: #f3f4f6;
        }

        .text-center { text-align: center; }

        .footer {
            margin-top: 8mm;
            text-align: right;
            font-size: 9px;
            color: #555;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>LAPORAN DATA ALUMNI</h1>
        <h2>LKSA MAWAR KASIH</h2>
        <h3>BANYUWANGI</h3>
        <div class="meta">
            Dicetak: {{ now()->translatedFormat('d F Y, H:i') }} &nbsp;|&nbsp; Total: {{ $data->count() }} alumni
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center" style="width:4%">No</th>
                <th style="width:16%">Nama</th>
                <th style="width:8%">Nama Panggilan</th>
                <th style="width:10%">Tempat, Tgl Lahir</th>
                <th style="width:5%" class="text-center">JK</th>
                <th style="width:10%">Sekolah / Kelas Terakhir</th>
                <th style="width:11%">Pendidikan Terakhir</th>
                <th style="width:9%">Pekerjaan</th>
                <th style="width:10%">No. HP</th>
                <th style="width:9%">Tgl Keluar</th>
                <th style="width:8%">Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $item)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $item->nama ?? '-' }}</td>
                <td>{{ $item->nama_panggilan ?? '-' }}</td>
                <td>
                    {{ $item->tempat_lahir ?? '-' }},
                    @if($item->tanggal_lahir)
                        {{ \Carbon\Carbon::parse($item->tanggal_lahir)->locale('id')->translatedFormat('d F Y') }}
                    @else
                        -
                    @endif
                </td>
                <td class="text-center">{{ $item->jenis_kelamin ?? '-' }}</td>
                <td>
                    {{ $item->nama_sekolah_terakhir ?? '-' }}
                    @if($item->kelas) (Kls {{ $item->kelas }}) @endif
                </td>
                <td>{{ $item->pendidikan_terakhir ?? '-' }}</td>
                <td>{{ $item->pekerjaan ?? '-' }}</td>
                <td>{{ $item->no_hp ?? '-' }}</td>
                <td>
                    @if($item->tanggal_keluar)
                        {{ \Carbon\Carbon::parse($item->tanggal_keluar)->locale('id')->translatedFormat('d F Y') }}
                    @else
                        -
                    @endif
                </td>
                <td>{{ $item->catatan ? \Illuminate\Support\Str::limit($item->catatan, 40) : '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="11" class="text-center" style="padding: 10px; color: #888;">
                    Belum ada data alumni.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Laporan Data Alumni LKSA Mawar Kasih &mdash; {{ now()->year }}
    </div>

</body>
</html>
