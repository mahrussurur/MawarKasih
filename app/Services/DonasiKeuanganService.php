<?php

namespace App\Services;

use App\Models\Donasi;
use App\Models\TransaksiKeuangan;

class DonasiKeuanganService
{
    /**
     * Catat donasi yang diterima sebagai pemasukan satu kali saja.
     */
    public function catatPemasukan(Donasi $donasi, ?int $dicatatOleh = null): TransaksiKeuangan
    {
        $tipeDonatur = $donasi->donatur_id ? 'Donatur Tetap' : 'Donatur Guest';

        return TransaksiKeuangan::firstOrCreate(
            ['donasi_id' => $donasi->id],
            [
                'jenis'        => 'pemasukan',
                'nominal'      => $donasi->nominal,
                'keterangan'   => "Pemasukan donasi dari {$tipeDonatur}: {$donasi->nama_donatur} ({$donasi->kode_donasi})",
                'tanggal'      => now()->toDateString(),
                'dicatat_oleh' => $dicatatOleh,
            ]
        );
    }
}
