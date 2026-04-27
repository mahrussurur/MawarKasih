<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Anak Asuh</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
    </style>
</head>
<body onload="window.print()">
    <h2 style="text-align:center">LAPORAN DATA ANAK ASUH - YAYASAN MAWAR KASIH</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>TTL</th>
                <th>L/P</th>
            </tr>
        </thead>
        <tbody>
            @foreach($anakAsuh as $key => $anak)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $anak->nama }}</td>
                <td>{{ $anak->tempat_lahir }}, {{ $anak->tanggal_lahir }}</td>
                <td>{{ $anak->jenis_kelamin }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>