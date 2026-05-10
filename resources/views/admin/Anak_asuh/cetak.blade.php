<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Anak Asuh</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h2 { margin: 0; padding: 0; }
        .header p { margin: 5px 0 0 0; font-style: italic; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; text-align: center; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

    <div class="header">
        <h2>PANTI ASUHAN MAWAR KASIH</h2>
        <p>Laporan Data Keseluruhan Anak Asuh</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Lengkap</th>
                <th>Tempat, Tgl Lahir</th>
                <th>Jenis Kelamin</th>
                <th>Status</th>
                <th>Nama Orang Tua</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->tempat_lahir }}, {{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d-m-Y') }}</td>
                <td class="text-center">{{ $item->jenis_kelamin }}</td>
                <td>{{ $item->status_social_anak }}</td>
                <td>
                    Ayah: {{ $item->nama_ayah ?? '-' }} <br>
                    Ibu: {{ $item->nama_ibu ?? '-' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>