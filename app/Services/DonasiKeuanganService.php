<?php

namespace App\Services;

use App\Models\Donasi;
use App\Models\TransaksiKeuangan;
use App\Models\LaporanKeuanganBulanan;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

class DonasiKeuanganService
{
    private function validateNotLocked($tanggal): void
    {
        $date = Carbon::parse($tanggal);
        $laporan = LaporanKeuanganBulanan::where('tahun', $date->year)->where('bulan', $date->month)->first();
        if ($laporan && in_array($laporan->status, ['diajukan', 'disetujui'])) {
            throw ValidationException::withMessages([
                'tanggal' => 'Transaksi tidak dapat dilakukan karena laporan keuangan pada bulan tersebut sudah dikunci (Diajukan/Disetujui).'
            ]);
        }
    }

    /**
     * Catat donasi yang diterima sebagai pemasukan satu kali saja.
     */
    public function catatPemasukan(Donasi $donasi, ?int $dicatatOleh = null): TransaksiKeuangan
    {
        $this->validateNotLocked($donasi->tanggal);

        $tipeDonatur = $donasi->donatur_id ? 'Donatur Tetap' : 'Donatur Guest';

        return TransaksiKeuangan::firstOrCreate(
            ['donasi_id' => $donasi->id],
            [
                'jenis'        => 'pemasukan',
                'kategori'     => 'DONASI',
                'nominal'      => $donasi->nominal,
                'keterangan'   => "Pemasukan donasi dari {$tipeDonatur}: {$donasi->nama_donatur} ({$donasi->kode_donasi})",
                'tanggal'      => Carbon::parse($donasi->tanggal)->toDateString(),
                'dicatat_oleh' => $dicatatOleh,
            ]
        );
    }

    /**
     * Sinkronisasi data transaksi keuangan jika donasi diedit.
     */
    public function syncPemasukan(Donasi $donasi): void
    {
        if ($donasi->status === 'diterima') {
            $transaksi = TransaksiKeuangan::where('donasi_id', $donasi->id)->first();
            if ($transaksi) {
                $this->validateNotLocked($transaksi->tanggal);
                $this->validateNotLocked($donasi->tanggal);

                $tipeDonatur = $donasi->donatur_id ? 'Donatur Tetap' : 'Donatur Guest';
                $transaksi->update([
                    'kategori'   => 'DONASI',
                    'nominal'    => $donasi->nominal,
                    'tanggal'    => Carbon::parse($donasi->tanggal)->toDateString(),
                    'keterangan' => "Pemasukan donasi dari {$tipeDonatur}: {$donasi->nama_donatur} ({$donasi->kode_donasi})",
                ]);
            } else {
                $this->catatPemasukan($donasi);
            }
        }
    }

    /**
     * Hapus data transaksi keuangan yang terkait dengan donasi.
     */
    public function hapusPemasukan(Donasi $donasi): void
    {
        $transaksis = TransaksiKeuangan::where('donasi_id', $donasi->id)->get();
        foreach ($transaksis as $transaksi) {
            $this->validateNotLocked($transaksi->tanggal);
            if ($transaksi->bukti_transaksi) {
                app(\App\Services\ImageService::class)->deleteImage($transaksi->bukti_transaksi);
            }
            $transaksi->delete();
        }
    }
}
