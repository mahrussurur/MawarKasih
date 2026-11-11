<?php

use App\Models\Donasi;
use App\Models\TransaksiKeuangan;
use App\Models\User;
use Illuminate\Support\Carbon;

describe('Unit Test: Models\Donasi', function () {
    it('menguji getTanggalDisplayAttribute memformat tanggal menjadi d-m-Y dan null jika kosong', function () {
        $donasi = new Donasi(['tanggal' => '2026-05-15']);
        expect($donasi->tanggal_display)->toBe('15-05-2026');

        $donasiKosong = new Donasi(['tanggal' => null]);
        expect($donasiKosong->tanggal_display)->toBeNull();
    });

    it('menguji setTanggalInputAttribute mengubah format d-m-Y ke Y-m-d', function () {
        $donasi = new Donasi();
        $donasi->tanggal_input = '25-12-2026';
        expect($donasi->getAttributes()['tanggal'])->toBe('2026-12-25');
    });

    it('menguji generateKode menghasilkan kode berawalan DON- dengan panjang 12 karakter', function () {
        $kode1 = Donasi::generateKode();
        $kode2 = Donasi::generateKode();

        expect($kode1)->toStartWith('DON-')
            ->and(strlen($kode1))->toBe(12)
            ->and($kode1)->not->toBe($kode2);
    });

    it('menguji getNominalRupiahAttribute memformat angka ke format mata uang rupiah', function () {
        $donasi = new Donasi(['nominal' => 2500000]);
        expect($donasi->nominal_rupiah)->toBe('Rp 2.500.000');
    });

    it('menguji getStatusLabelAttribute memetakan status ke label yang tepat', function () {
        $pending = new Donasi(['status' => 'pending']);
        $diterima = new Donasi(['status' => 'diterima']);
        $ditolak = new Donasi(['status' => 'ditolak']);
        $lainnya = new Donasi(['status' => 'custom_status']);

        expect($pending->status_label)->toBe('Pending')
            ->and($diterima->status_label)->toBe('Diterima')
            ->and($ditolak->status_label)->toBe('Ditolak')
            ->and($lainnya->status_label)->toBe('custom_status');
    });

    it('menguji getStatusColorAttribute memetakan status ke warna badge bootstrap', function () {
        $pending = new Donasi(['status' => 'pending']);
        $diterima = new Donasi(['status' => 'diterima']);
        $ditolak = new Donasi(['status' => 'ditolak']);
        $lainnya = new Donasi(['status' => 'unknown']);

        expect($pending->status_color)->toBe('warning')
            ->and($diterima->status_color)->toBe('success')
            ->and($ditolak->status_color)->toBe('danger')
            ->and($lainnya->status_color)->toBe('secondary');
    });

    it('menguji relasi donatur (BelongsTo ke model User)', function () {
        $user = User::factory()->create(['role' => 'donatur']);
        $donasi = Donasi::create([
            'kode_donasi' => 'DON-REL-01',
            'nama_donatur' => 'User Donatur',
            'nominal' => 100000,
            'tanggal' => now(),
            'status' => 'diterima',
            'metode_pembayaran' => 'transfer',
            'donatur_id' => $user->id,
        ]);

        expect($donasi->donatur)->toBeInstanceOf(User::class)
            ->and($donasi->donatur->id)->toBe($user->id);
    });

    it('menguji relasi transaksiKeuangan (HasOne ke model TransaksiKeuangan)', function () {
        $donasi = Donasi::create([
            'kode_donasi' => 'DON-REL-02',
            'nama_donatur' => 'Hamba Allah',
            'nominal' => 300000,
            'tanggal' => now(),
            'status' => 'diterima',
            'metode_pembayaran' => 'tunai',
        ]);

        $transaksi = TransaksiKeuangan::create([
            'jenis' => 'pemasukan',
            'kategori' => 'DONASI',
            'nominal' => 300000,
            'tanggal' => now(),
            'keterangan' => 'Pemasukan donasi',
            'donasi_id' => $donasi->id,
        ]);

        expect($donasi->transaksiKeuangan)->toBeInstanceOf(TransaksiKeuangan::class)
            ->and($donasi->transaksiKeuangan->id)->toBe($transaksi->id);
    });

    it('menguji model event booted deleting menghapus record transaksi keuangan terkait (booted)', function () {
        $donasi = Donasi::create([
            'kode_donasi' => 'DON-BOOT-01',
            'nama_donatur' => 'Donatur Boot',
            'nominal' => 500000,
            'tanggal' => now(),
            'status' => 'diterima',
            'metode_pembayaran' => 'transfer',
        ]);

        $transaksi = TransaksiKeuangan::create([
            'jenis' => 'pemasukan',
            'kategori' => 'DONASI',
            'nominal' => 500000,
            'tanggal' => now(),
            'keterangan' => 'Donasi Boot',
            'donasi_id' => $donasi->id,
        ]);

        $donasi->delete();

        $this->assertDatabaseMissing('transaksi_keuangans', ['id' => $transaksi->id]);
    });
});
