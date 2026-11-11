<?php

use App\Models\LaporanKeuanganBulanan;
use App\Models\ProfilPegawai;
use App\Models\TransaksiKeuangan;
use App\Models\User;

beforeEach(function () {
    $this->admin = User::factory()->create([
        'role' => 'admin',
        'status' => 'aktif',
    ]);
    ProfilPegawai::create([
        'user_id' => $this->admin->id,
        'nama' => 'Bapak Admin',
        'jabatan' => 'Admin Utama',
    ]);

    $this->donatur = User::factory()->create([
        'role' => 'donatur',
        'status' => 'aktif',
    ]);
});

describe('Admin LaporanKeuanganBulananController Feature Test', function () {
    it('mengarahkan guest ke halaman login saat mengakses laporan bulanan admin', function () {
        $this->get(route('admin.laporan-bulanan.index'))
            ->assertRedirect(route('login'));
    });

    it('menolak akses pengguna non-admin (403 Forbidden)', function () {
        $this->actingAs($this->donatur)
            ->get(route('admin.laporan-bulanan.index'))
            ->assertForbidden();
    });

    it('menampilkan index laporan keuangan bulanan default tanpa filter status', function () {
        LaporanKeuanganBulanan::factory()->create([
            'tahun' => 2026,
            'bulan' => 1,
            'status' => 'disetujui',
        ]);
        LaporanKeuanganBulanan::factory()->create([
            'tahun' => 2026,
            'bulan' => 2,
            'status' => 'diajukan',
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.laporan-bulanan.index'));

        $response->assertOk();
        $response->assertViewIs('admin.laporan-bulanan.index');
        $response->assertViewHas('laporans');
        expect($response->viewData('laporans')->total())->toBe(2);
    });

    it('dapat memfilter laporan bulanan berdasarkan status', function () {
        LaporanKeuanganBulanan::factory()->create([
            'tahun' => 2026,
            'bulan' => 3,
            'status' => 'disetujui',
        ]);
        LaporanKeuanganBulanan::factory()->create([
            'tahun' => 2026,
            'bulan' => 4,
            'status' => 'draft',
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.laporan-bulanan.index', ['status' => 'disetujui']));

        $response->assertOk();
        expect($response->viewData('laporans')->total())->toBe(1);
        expect($response->viewData('laporans')->first()->status)->toBe('disetujui');
    });

    it('menampilkan detail laporan bulanan beserta transaksi dan ringkasan', function () {
        $laporan = LaporanKeuanganBulanan::factory()->create([
            'tahun' => 2026,
            'bulan' => 5,
            'status' => 'diajukan',
        ]);

        TransaksiKeuangan::create([
            'jenis' => 'pemasukan',
            'kategori' => 'DONASI',
            'nominal' => 2500000,
            'keterangan' => 'Donasi Rutin Mei',
            'tanggal' => '2026-05-10',
            'dicatat_oleh' => $this->admin->id,
        ]);
        TransaksiKeuangan::create([
            'jenis' => 'pengeluaran',
            'kategori' => 'KONSUMSI',
            'nominal' => 500000,
            'keterangan' => 'Konsumsi Mei',
            'tanggal' => '2026-05-12',
            'dicatat_oleh' => $this->admin->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.laporan-bulanan.show', $laporan));

        $response->assertOk();
        $response->assertViewIs('admin.laporan-bulanan.show');
        $response->assertViewHasAll(['laporan', 'transaksis', 'ringkasan']);
        expect($response->viewData('transaksis'))->toHaveCount(2);
        expect($response->viewData('ringkasan'))->toHaveCount(2);
    });

    it('dapat mencetak laporan keuangan bulanan dalam format pdf', function () {
        $laporan = LaporanKeuanganBulanan::factory()->create([
            'tahun' => 2026,
            'bulan' => 5,
            'status' => 'disetujui',
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.laporan-bulanan.cetak', $laporan));

        $response->assertOk();
        expect($response->headers->get('content-type'))->toContain('application/pdf');
    });
});
