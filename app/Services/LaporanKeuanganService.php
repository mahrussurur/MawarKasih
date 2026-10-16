<?php

namespace App\Services;

use App\Models\LaporanKeuanganBulanan;
use App\Models\TransaksiKeuangan;
use Illuminate\Support\Carbon;

class LaporanKeuanganService
{
    /**
     * Dapatkan atau buat draft laporan untuk bulan tertentu
     */
    public function getOrCreateDraft(int $tahun, int $bulan): LaporanKeuanganBulanan
    {
        $laporan = LaporanKeuanganBulanan::firstOrCreate(
            ['tahun' => $tahun, 'bulan' => $bulan],
            ['status' => 'draft']
        );

        if (in_array($laporan->status, ['draft', 'dikembalikan'])) {
            $this->calculate($tahun, $bulan);
            $laporan->refresh();
        }

        return $laporan;
    }

    /**
     * Kalkulasi ulang angka-angka laporan berdasarkan transaksi
     */
    public function calculate(int $tahun, int $bulan): void
    {
        $laporan = LaporanKeuanganBulanan::where('tahun', $tahun)->where('bulan', $bulan)->first();
        if (!$laporan || in_array($laporan->status, ['diajukan', 'disetujui'])) {
            return;
        }

        $startDate = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        // Hitung saldo awal (semua transaksi sebelum bulan ini)
        $pemasukanLalu = TransaksiKeuangan::where('jenis', 'pemasukan')
            ->where('tanggal', '<', $startDate->toDateString())
            ->sum('nominal');
        $pengeluaranLalu = TransaksiKeuangan::where('jenis', 'pengeluaran')
            ->where('tanggal', '<', $startDate->toDateString())
            ->sum('nominal');
        
        $saldoAwal = $pemasukanLalu - $pengeluaranLalu;

        // Hitung bulan berjalan
        $pemasukanBulanIni = TransaksiKeuangan::where('jenis', 'pemasukan')
            ->whereBetween('tanggal', [$startDate->toDateString(), $endDate->toDateString()])
            ->sum('nominal');

        $pengeluaranBulanIni = TransaksiKeuangan::where('jenis', 'pengeluaran')
            ->whereBetween('tanggal', [$startDate->toDateString(), $endDate->toDateString()])
            ->sum('nominal');

        $saldoAkhir = $saldoAwal + $pemasukanBulanIni - $pengeluaranBulanIni;

        $laporan->update([
            'saldo_awal' => $saldoAwal,
            'total_pemasukan' => $pemasukanBulanIni,
            'total_pengeluaran' => $pengeluaranBulanIni,
            'saldo_akhir' => $saldoAkhir,
        ]);
    }

    public function submit(LaporanKeuanganBulanan $laporan, $user): void
    {
        if (in_array($laporan->status, ['draft', 'dikembalikan'])) {
            // Kalkulasi ulang sebelum submit untuk memastikan validitas
            $this->calculate($laporan->tahun, $laporan->bulan);
            $laporan->refresh();

            $laporan->update([
                'status' => 'diajukan',
                'submitted_at' => now(),
                'submitted_by' => $user->id,
            ]);
        }
    }

    public function approve(LaporanKeuanganBulanan $laporan, $admin): void
    {
        if ($laporan->status === 'diajukan') {
            $laporan->update([
                'status' => 'disetujui',
                'approved_at' => now(),
                'approved_by' => $admin->id,
            ]);
        }
    }

    public function return(LaporanKeuanganBulanan $laporan, $admin, string $catatan): void
    {
        if ($laporan->status === 'diajukan') {
            $laporan->update([
                'status' => 'dikembalikan',
                'returned_at' => now(),
                'returned_by' => $admin->id,
                'catatan_return' => $catatan,
            ]);
        }
    }
}
