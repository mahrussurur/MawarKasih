<?php

use App\Models\Donasi;
use App\Models\LaporanKeuanganBulanan;
use App\Models\ProfilPegawai;
use App\Models\TransaksiKeuangan;
use App\Models\User;
use Illuminate\Support\Carbon;

beforeEach(function () {
    $this->bendahara = User::factory()->create([
        'role' => 'bendahara',
        'status' => 'aktif',
    ]);
    ProfilPegawai::create([
        'user_id' => $this->bendahara->id,
        'nama' => 'Ibu Bendahara',
        'jabatan' => 'Bendahara Yayasan',
    ]);

    $this->donatur = User::factory()->create([
        'role' => 'donatur',
        'status' => 'aktif',
    ]);
});

describe('Bendahara DashboardController Feature Test', function () {
    it('mengarahkan guest ke halaman login saat mengakses dashboard bendahara', function () {
        $this->get(route('bendahara.dashboard'))
            ->assertRedirect(route('login'));
    });

    it('menolak akses pengguna non-bendahara (403 Forbidden)', function () {
        $this->actingAs($this->donatur)
            ->get(route('bendahara.dashboard'))
            ->assertForbidden();
    });

    it('berhasil memuat dashboard bendahara dalam kondisi data kosong (empty state)', function () {
        $response = $this->actingAs($this->bendahara)
            ->get(route('bendahara.dashboard'));

        $response->assertOk();
        $response->assertViewIs('bendahara.dashboard');
        $response->assertViewHasAll([
            'totalPending',
            'totalDiterima',
            'totalDitolak',
            'totalNominal',
            'donasiTerbaru',
            'nominalPerBulan',
            'saldo',
            'pemasukanBulanIni',
            'pengeluaranBulanIni',
            'saldoBulanIni',
            'laporanCounts',
        ]);
        expect($response->viewData('totalPending'))->toBe(0);
        expect($response->viewData('totalDiterima'))->toBe(0);
        expect($response->viewData('saldo'))->toEqual(0);
    });

    it('menghitung seluruh agregasi statistik donasi, keuangan, dan status laporan bulanan secara akurat', function () {
        Carbon::setTestNow('2026-05-15 10:00:00');

        Donasi::create([
            'kode_donasi' => 'DON-001',
            'nama_donatur' => 'Donatur A',
            'nominal' => 500000,
            'tanggal' => '2026-05-10',
            'status' => 'pending',
            'metode_pembayaran' => 'transfer',
        ]);
        Donasi::create([
            'kode_donasi' => 'DON-002',
            'nama_donatur' => 'Donatur B',
            'nominal' => 1000000,
            'tanggal' => '2026-05-12',
            'status' => 'diterima',
            'metode_pembayaran' => 'transfer',
        ]);
        Donasi::create([
            'kode_donasi' => 'DON-003',
            'nama_donatur' => 'Donatur C',
            'nominal' => 200000,
            'tanggal' => '2026-05-14',
            'status' => 'ditolak',
            'metode_pembayaran' => 'transfer',
        ]);

        TransaksiKeuangan::create([
            'jenis' => 'pemasukan',
            'kategori' => 'DONASI',
            'nominal' => 1000000,
            'keterangan' => 'Donasi Diterima',
            'tanggal' => '2026-05-12',
            'dicatat_oleh' => $this->bendahara->id,
        ]);
        TransaksiKeuangan::create([
            'jenis' => 'pengeluaran',
            'kategori' => 'OPERASIONAL',
            'nominal' => 400000,
            'keterangan' => 'Belanja Operasional',
            'tanggal' => '2026-05-13',
            'dicatat_oleh' => $this->bendahara->id,
        ]);

        LaporanKeuanganBulanan::factory()->create(['tahun' => 2026, 'bulan' => 1, 'status' => 'draft']);
        LaporanKeuanganBulanan::factory()->create(['tahun' => 2026, 'bulan' => 2, 'status' => 'diajukan']);

        $response = $this->actingAs($this->bendahara)
            ->get(route('bendahara.dashboard'));

        $response->assertOk();
        expect($response->viewData('totalPending'))->toBe(1);
        expect($response->viewData('totalDiterima'))->toBe(1);
        expect($response->viewData('totalDitolak'))->toBe(1);
        expect($response->viewData('totalNominal'))->toEqual(1000000);
        expect($response->viewData('saldo'))->toEqual(600000);
        expect($response->viewData('pemasukanBulanIni'))->toEqual(1000000);
        expect($response->viewData('pengeluaranBulanIni'))->toEqual(400000);
        expect($response->viewData('saldoBulanIni'))->toEqual(600000);
        expect($response->viewData('laporanCounts')['draft'])->toBe(1);
        expect($response->viewData('laporanCounts')['diajukan'])->toBe(1);

        Carbon::setTestNow();
    });
});
