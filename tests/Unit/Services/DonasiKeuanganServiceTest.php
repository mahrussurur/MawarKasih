<?php

use App\Models\Donasi;
use App\Models\LaporanKeuanganBulanan;
use App\Models\TransaksiKeuangan;
use App\Models\User;
use App\Services\DonasiKeuanganService;
use Illuminate\Validation\ValidationException;

beforeEach(function () {
    $this->service = app(DonasiKeuanganService::class);
    $this->bendahara = User::factory()->create(['role' => 'bendahara']);
});

describe('Unit Test: Services\DonasiKeuanganService', function () {
    it('menguji validateNotLocked melempar ValidationException jika laporan status diajukan atau disetujui (validateNotLocked)', function () {
        LaporanKeuanganBulanan::factory()->create([
            'tahun' => 2026,
            'bulan' => 6,
            'status' => 'disetujui',
        ]);

        $donasi = new Donasi([
            'tanggal' => '2026-06-15',
            'nominal' => 100000,
            'nama_donatur' => 'Donatur Test',
            'kode_donasi' => 'DON-LOCK-01',
        ]);

        expect(fn () => $this->service->catatPemasukan($donasi))
            ->toThrow(ValidationException::class);
    });

    it('menguji catatPemasukan berhasil mencatat pemasukan kas untuk donatur tetap dan umum (catatPemasukan)', function () {
        $donatur = User::factory()->create(['role' => 'donatur']);
        $donasiTetap = Donasi::create([
            'kode_donasi' => 'DON-TETAP-SVC',
            'nama_donatur' => 'Donatur Tetap',
            'nominal' => 500000,
            'tanggal' => '2026-07-10',
            'status' => 'diterima',
            'metode_pembayaran' => 'transfer',
            'donatur_id' => $donatur->id,
        ]);

        $transaksi = $this->service->catatPemasukan($donasiTetap, $this->bendahara->id);

        expect($transaksi)->toBeInstanceOf(TransaksiKeuangan::class)
            ->and($transaksi->jenis)->toBe('pemasukan')
            ->and($transaksi->kategori)->toBe('DONASI')
            ->and($transaksi->nominal)->toBe(500000)
            ->and($transaksi->keterangan)->toContain('Donatur Tetap')
            ->and($transaksi->dicatat_oleh)->toBe($this->bendahara->id);
    });

    it('menguji syncPemasukan memperbarui transaksi yang sudah ada atau membuat baru jika belum ada (syncPemasukan)', function () {
        $donasi = Donasi::create([
            'kode_donasi' => 'DON-SYNC-01',
            'nama_donatur' => 'Donatur Sync',
            'nominal' => 200000,
            'tanggal' => '2026-07-12',
            'status' => 'diterima',
            'metode_pembayaran' => 'transfer',
        ]);

        // Path: belum ada transaksi -> otomatis catat
        $this->service->syncPemasukan($donasi);
        $this->assertDatabaseHas('transaksi_keuangans', [
            'donasi_id' => $donasi->id,
            'nominal' => 200000,
        ]);

        // Path: transaksi sudah ada -> sinkronisasi update nominal baru
        $donasi->nominal = 350000;
        $this->service->syncPemasukan($donasi);
        $this->assertDatabaseHas('transaksi_keuangans', [
            'donasi_id' => $donasi->id,
            'nominal' => 350000,
        ]);

        // Path: jika status bukan diterima, sync diabaikan
        $donasiPending = Donasi::create([
            'kode_donasi' => 'DON-SYNC-PEND',
            'nama_donatur' => 'Donatur Pending',
            'nominal' => 100000,
            'tanggal' => '2026-07-13',
            'status' => 'pending',
            'metode_pembayaran' => 'transfer',
        ]);
        $this->service->syncPemasukan($donasiPending);
        $this->assertDatabaseMissing('transaksi_keuangans', [
            'donasi_id' => $donasiPending->id,
        ]);
    });

    it('menguji hapusPemasukan menghapus seluruh data transaksi terkait donasi (hapusPemasukan)', function () {
        $donasi = Donasi::create([
            'kode_donasi' => 'DON-HAPUS-SVC',
            'nama_donatur' => 'Donatur Hapus Svc',
            'nominal' => 150000,
            'tanggal' => '2026-07-14',
            'status' => 'diterima',
            'metode_pembayaran' => 'transfer',
        ]);

        $transaksi = TransaksiKeuangan::create([
            'jenis' => 'pemasukan',
            'kategori' => 'DONASI',
            'nominal' => 150000,
            'tanggal' => '2026-07-14',
            'keterangan' => 'Donasi Pemasukan Hapus',
            'donasi_id' => $donasi->id,
        ]);

        $this->service->hapusPemasukan($donasi);

        $this->assertDatabaseMissing('transaksi_keuangans', [
            'id' => $transaksi->id,
        ]);
    });
});
