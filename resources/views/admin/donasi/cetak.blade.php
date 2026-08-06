{{--
    VIEW: donasi/cetak.blade.php
    Taruh di: resources/views/donasi/cetak.blade.php
    Dirender oleh DomPDF — hanya mendukung inline CSS.
--}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Donasi — Panti Asuhan Mawar Kasih</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'DejaVu Sans', Arial, sans-serif; }
        body { background: #fff; color: #1e293b; font-size: 12px; padding: 24px 30px; }

        /* Header surat */
        .kop { display: flex; align-items: center; gap: 16px; border-bottom: 3px solid #1e2a3a; padding-bottom: 14px; margin-bottom: 20px; }
        .kop-text .org { font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: .08em; }
        .kop-text .nama { font-size: 20px; font-weight: 900; color: #1e2a3a; line-height: 1.1; }
        .kop-text .alamat { font-size: 10px; color: #94a3b8; margin-top: 3px; }

        /* Judul laporan */
        .judul-wrap { text-align: center; margin-bottom: 18px; }
        .judul-wrap h2 { font-size: 15px; font-weight: 800; color: #1e2a3a; text-transform: uppercase; letter-spacing: .06em; }
        .judul-wrap p { font-size: 11px; color: #64748b; margin-top: 4px; }

        /* Tabel */
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        thead tr { background: #1e2a3a; }
        th { padding: 9px 10px; text-align: left; font-size: 10px; font-weight: 700; color: #fff; text-transform: uppercase; letter-spacing: .05em; }
        th.center, td.center { text-align: center; }
        td { padding: 9px 10px; font-size: 11px; color: #374151; border-bottom: 1px solid #f1f5f9; }
        tbody tr:nth-child(even) td { background: #f8fafc; }

        /* Total */
        .total-row td { font-weight: 800; color: #1e2a3a; background: #f0fdf4 !important; border-top: 2px solid #22c55e; }

        /* Footer */
        .footer-cetak { margin-top: 30px; display: flex; justify-content: flex-end; }
        .ttd-box { text-align: center; width: 180px; }
        .ttd-box p { font-size: 11px; color: #374151; }
        .ttd-space { height: 55px; }
        .ttd-nama { font-weight: 800; font-size: 12px; color: #1e2a3a; border-top: 1px solid #94a3b8; padding-top: 4px; }

        .badge-valid { background: #dcfce7; color: #15803d; padding: 2px 8px; border-radius: 10px; font-size: 10px; font-weight: 700; }
        .cetak-info { font-size: 10px; color: #94a3b8; text-align: right; margin-bottom: 10px; }
    </style>
</head>
<body>

    {{-- KOP SURAT --}}
    <div class="kop">
        <div class="kop-text">
            <div class="org">Yayasan</div>
            <div class="nama">Panti Asuhan Mawar Kasih</div>
            <div class="alamat">Laporan Data Donasi — Dicetak: {{ now()->isoFormat('D MMMM Y, HH:mm') }}</div>
        </div>
    </div>

    {{-- Judul --}}
    <div class="judul-wrap">
        <h2>Laporan Donasi Terverifikasi</h2>
        <p>Periode: {{ $tahun }} &nbsp;|&nbsp; Total: {{ $donasi->count() }} data</p>
    </div>

    <div class="cetak-info">Hanya menampilkan donasi dengan status <strong>VALID / TERVERIFIKASI</strong></div>

    {{-- Tabel --}}
    <table>
        <thead>
            <tr>
                <th class="center" style="width:35px;">No</th>
                <th>Kode Donasi</th>
                <th>Nama Donatur</th>
                <th>No. HP</th>
                <th>Nominal</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th class="center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($donasi as $index => $item)
            <tr>
                <td class="center">{{ $index + 1 }}</td>
                <td style="font-family:monospace;font-weight:700;color:#3b82f6;font-size:10px;">{{ $item->kode_donasi }}</td>
                <td style="font-weight:700;">{{ $item->nama_donatur }}</td>
                <td>{{ $item->no_hp ?? '-' }}</td>
                <td style="font-weight:800;">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('D MMM Y') }}</td>
                <td>{{ $item->keterangan ?? '-' }}</td>
                <td class="center"><span class="badge-valid">Valid</span></td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center;color:#94a3b8;padding:30px;">Tidak ada data donasi valid.</td>
            </tr>
            @endforelse

            {{-- Baris Total --}}
            @if($donasi->count() > 0)
            <tr class="total-row">
                <td colspan="4" style="text-align:right;font-size:12px;">Total Nominal Diterima:</td>
                <td colspan="3" style="font-size:13px;color:#15803d;">Rp {{ number_format($totalNominal, 0, ',', '.') }}</td>
            </tr>
            @endif
        </tbody>
    </table>

    {{-- TTD --}}
    <div class="footer-cetak">
        <div class="ttd-box">
            <p>Mengetahui,</p>
            <p>Pengurus Yayasan Mawar Kasih</p>
            <div class="ttd-space"></div>
            <div class="ttd-nama">( ___________________ )</div>
        </div>
    </div>

</body>
</html>
