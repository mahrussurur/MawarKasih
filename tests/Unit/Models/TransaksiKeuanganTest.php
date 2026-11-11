<?php

use App\Models\Donasi;
use App\Models\TransaksiKeuangan;
use App\Models\User;

describe('Unit Test: Models\TransaksiKeuangan', function () {
    it('menguji relasi donasi (BelongsTo ke model Donasi)', function () {
        $donasi = Donasi::create([
            'kode_donasi' => 'DON-TRX-01',
            'nama_donatur' => 'Donatur Transaksi',
            'nominal' => 200000,
            'tanggal' => now(),
            'status' => 'diterima',
            'metode_pembayaran' => 'transfer',
        ]);

        $transaksi = TransaksiKeuangan::create([
            'jenis' => 'pemasukan',
            'kategori' => 'DONASI',
            'nominal' => 200000,
            'tanggal' => now(),
            'keterangan' => 'Donasi Masuk',
            'donasi_id' => $donasi->id,
        ]);

        expect($transaksi->donasi)->toBeInstanceOf(Donasi::class)
            ->and($transaksi->donasi->id)->toBe($donasi->id);
    });

    it('menguji relasi pencatat (BelongsTo ke model User via dicatat_oleh)', function () {
        $user = User::factory()->create(['role' => 'bendahara']);

        $transaksi = TransaksiKeuangan::create([
            'jenis' => 'pengeluaran',
            'kategori' => 'OPERASIONAL',
            'nominal' => 150000,
            'tanggal' => now(),
            'keterangan' => 'Beli ATK',
            'dicatat_oleh' => $user->id,
        ]);

        expect($transaksi->pencatat)->toBeInstanceOf(User::class)
            ->and($transaksi->pencatat->id)->toBe($user->id);
    });
});
