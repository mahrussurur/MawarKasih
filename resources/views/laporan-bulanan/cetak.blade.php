<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan Bulanan - {{ \Carbon\Carbon::create()->month($laporan->bulan)->translatedFormat('F') }} {{ $laporan->tahun }}</title>
    <style>
        @page { size: A4 portrait; margin: 8mm 10mm 7mm 10mm; }
        * { box-sizing: border-box; }

        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 12px; color: #333; line-height: 1.5; }
        .header { text-align: center; margin-bottom: 4mm; padding-bottom: 3mm; border-bottom: 1.5px solid #222; }
        .header h1 { margin: 0; font-size: 17px; font-weight: bold; text-transform: uppercase; line-height: 1.15; }
        .header h2, .header h3 { margin: 1px 0 0; font-size: 14px; font-weight: bold; text-transform: uppercase; line-height: 1.15; }
        .header p { margin: 1px 0 0; font-size: 13px; font-weight: medium; line-height: 1.15; }
        .draft-watermark { color: red; font-size: 24px; font-weight: bold; text-align: center; border: 2px solid red; padding: 10px; margin-bottom: 20px; }
        
        .section-title { font-weight: bold; font-size: 14px; margin-bottom: 8px; margin-top: 20px; border-bottom: 1px solid #ddd; padding-bottom: 4px; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 6px 8px; text-align: left; }
        th { background-color: #f5f5f5; font-weight: bold; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        
        .summary-box { width: 48%; float: left; margin-bottom: 20px; }
        .summary-box.right { float: right; }
        .summary-table th { width: 60%; }
        .clearfix::after { content: ""; clear: both; display: table; }

        .signature { margin-top: 40px; }
        .signature table { border: none; }
        .signature td { border: none; text-align: center; width: 50%; padding-top: 40px; }
        .signature .name { font-weight: bold; text-decoration: underline; }
    </style>
</head>
<body>

    @if(in_array($laporan->status, ['draft', 'returned']))
    <div class="draft-watermark">
        DRAFT / BELUM DISETUJUI
    </div>
    @endif

    <div class="header">
        <h1>LAPORAN KEUANGAN BULANAN</h1>
        <h2>LKSA Mawar Kasih</h2>
        <h3>Banyuwangi</h3>
        <p>Periode: {{ \Carbon\Carbon::create()->month($laporan->bulan)->translatedFormat('F') }} {{ $laporan->tahun }}</p>
    </div>

    <div class="section-title">Ringkasan Keuangan</div>
    <table>
        <tr>
            <th>Saldo Awal</th>
            <td class="text-right">Rp {{ number_format($laporan->saldo_awal, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Total Pemasukan</th>
            <td class="text-right">+ Rp {{ number_format($laporan->total_pemasukan, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Total Pengeluaran</th>
            <td class="text-right">- Rp {{ number_format($laporan->total_pengeluaran, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Saldo Akhir</th>
            <td class="text-right font-bold" style="font-weight: bold;">Rp {{ number_format($laporan->saldo_akhir, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="section-title">Daftar Transaksi Detail</div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Keterangan</th>
                <th class="text-right">Pemasukan</th>
                <th class="text-right">Pengeluaran</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksis as $index => $trx)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td style="white-space: nowrap;">{{ \Carbon\Carbon::parse($trx->tanggal)->format('d/m/Y') }}</td>
                <td>{{ $trx->kategori }}</td>
                <td>{{ $trx->keterangan }}</td>
                <td class="text-right">{{ $trx->jenis === 'pemasukan' ? 'Rp ' . number_format($trx->nominal, 0, ',', '.') : '-' }}</td>
                <td class="text-right">{{ $trx->jenis === 'pengeluaran' ? 'Rp ' . number_format($trx->nominal, 0, ',', '.') : '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada transaksi pada bulan ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="signature">
        <table>
            <tr>
                <td>
                    <p>Status Laporan:</p>
                    <p style="font-weight: bold; font-size: 14px;">{{ strtoupper($laporan->status) }}</p>
                </td>
                <td>
                    @if($laporan->status === 'approved')
                        <p>Disetujui oleh:</p>
                        <p class="name" style="margin-top: 50px;">{{ $laporan->approver->name ?? '(Admin)' }}</p>
                        <p>Tanggal: {{ $laporan->approved_at ? $laporan->approved_at->format('d/m/Y') : '-' }}</p>
                    @elseif($laporan->status === 'submitted')
                        <p>Disubmit oleh:</p>
                        <p class="name" style="margin-top: 50px;">{{ $laporan->submitter->name ?? '(Bendahara)' }}</p>
                        <p>Tanggal: {{ $laporan->submitted_at ? $laporan->submitted_at->format('d/m/Y') : '-' }}</p>
                    @endif
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
