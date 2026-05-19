<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Donatur</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
        }

        .container {
            padding: 20px;
            max-width: 100%;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }

        .header h1 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 11px;
            margin: 3px 0;
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

        .status-aktif {
            background-color: #d4edda;
            padding: 3px 8px;
            border-radius: 3px;
            display: inline-block;
        }

        .status-tidak_aktif {
            background-color: #f8d7da;
            padding: 3px 8px;
            border-radius: 3px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>LAPORAN DATA DONATUR</h1>
            <p>Panti Asuhan Mawar Kasih</p>
            <p>Jl. Mawarkasih No. 123, Kota</p>
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
                    <th style="width: 20%;">Nama</th>
                    <th style="width: 20%;">Email</th>
                    <th style="width: 15%;">No. HP</th>
                    <th style="width: 25%;">Alamat</th>
                    <th class="text-center" style="width: 15%;">Status</th>
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
                        <td class="text-center">
                            <span class="status-{{ $item->status }}">
                                {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data donatur</td>
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
