<?php

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

describe('Admin KeuanganController Feature Test', function () {
    it('mengarahkan guest ke halaman login saat mengakses index keuangan admin', function () {
        $this->get(route('admin.keuangan.index'))
            ->assertRedirect(route('login'));
    });

    it('menolak akses pengguna role non-admin (403 Forbidden)', function () {
        $this->actingAs($this->donatur)
            ->get(route('admin.keuangan.index'))
            ->assertForbidden();
    });

    it('menampilkan index keuangan default tanpa filter beserta kalkulasi saldo', function () {
        TransaksiKeuangan::create([
            'jenis' => 'pemasukan',
            'kategori' => 'DONASI',
            'nominal' => 1500000,
            'keterangan' => 'Donasi Hamba Allah',
            'tanggal' => '2026-05-01',
            'dicatat_oleh' => $this->admin->id,
        ]);
        TransaksiKeuangan::create([
            'jenis' => 'pengeluaran',
            'kategori' => 'OPERASIONAL',
            'nominal' => 500000,
            'keterangan' => 'Beli Alat Kebersihan',
            'tanggal' => '2026-05-02',
            'dicatat_oleh' => $this->admin->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.keuangan.index'));

        $response->assertOk();
        $response->assertViewIs('admin.keuangan.index');
        $response->assertViewHasAll(['transaksi', 'totalPemasukan', 'totalPengeluaran', 'saldo']);
        expect($response->viewData('totalPemasukan'))->toEqual(1500000);
        expect($response->viewData('totalPengeluaran'))->toEqual(500000);
        expect($response->viewData('saldo'))->toEqual(1000000);
    });

    it('dapat memfilter transaksi berdasarkan jenis pemasukan atau pengeluaran', function () {
        TransaksiKeuangan::create([
            'jenis' => 'pemasukan',
            'kategori' => 'DONASI',
            'nominal' => 1000000,
            'keterangan' => 'Pemasukan Kas',
            'tanggal' => '2026-05-10',
            'dicatat_oleh' => $this->admin->id,
        ]);
        TransaksiKeuangan::create([
            'jenis' => 'pengeluaran',
            'kategori' => 'KONSUMSI',
            'nominal' => 200000,
            'keterangan' => 'Beli Makan Siang',
            'tanggal' => '2026-05-11',
            'dicatat_oleh' => $this->admin->id,
        ]);

        $responsePemasukan = $this->actingAs($this->admin)
            ->get(route('admin.keuangan.index', ['jenis' => 'pemasukan']));
        $responsePemasukan->assertOk();
        expect($responsePemasukan->viewData('transaksi')->total())->toBe(1);
        expect($responsePemasukan->viewData('transaksi')->first()->keterangan)->toBe('Pemasukan Kas');

        $responsePengeluaran = $this->actingAs($this->admin)
            ->get(route('admin.keuangan.index', ['jenis' => 'pengeluaran']));
        $responsePengeluaran->assertOk();
        expect($responsePengeluaran->viewData('transaksi')->total())->toBe(1);
        expect($responsePengeluaran->viewData('transaksi')->first()->keterangan)->toBe('Beli Makan Siang');
    });

    it('dapat mencari transaksi berdasarkan kata kunci keterangan', function () {
        TransaksiKeuangan::create([
            'jenis' => 'pengeluaran',
            'kategori' => 'PENDIDIKAN',
            'nominal' => 350000,
            'keterangan' => 'Beli Buku Tulis Siswa',
            'tanggal' => '2026-05-12',
            'dicatat_oleh' => $this->admin->id,
        ]);
        TransaksiKeuangan::create([
            'jenis' => 'pengeluaran',
            'kategori' => 'KESEHATAN',
            'nominal' => 150000,
            'keterangan' => 'Obat P3K',
            'tanggal' => '2026-05-13',
            'dicatat_oleh' => $this->admin->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.keuangan.index', ['search' => 'Buku Tulis']));

        $response->assertOk();
        expect($response->viewData('transaksi')->total())->toBe(1);
        expect($response->viewData('transaksi')->first()->keterangan)->toBe('Beli Buku Tulis Siswa');
    });

    it('dapat menggabungkan filter jenis dan kata kunci pencarian sekaligus', function () {
        TransaksiKeuangan::create([
            'jenis' => 'pengeluaran',
            'kategori' => 'OPERASIONAL',
            'nominal' => 400000,
            'keterangan' => 'Listrik Gedung A',
            'tanggal' => '2026-05-15',
            'dicatat_oleh' => $this->admin->id,
        ]);
        TransaksiKeuangan::create([
            'jenis' => 'pemasukan',
            'kategori' => 'LAINNYA',
            'nominal' => 400000,
            'keterangan' => 'Pengembalian Listrik',
            'tanggal' => '2026-05-16',
            'dicatat_oleh' => $this->admin->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.keuangan.index', ['jenis' => 'pengeluaran', 'search' => 'Listrik']));

        $response->assertOk();
        expect($response->viewData('transaksi')->total())->toBe(1);
        expect($response->viewData('transaksi')->first()->jenis)->toBe('pengeluaran');
    });
});
