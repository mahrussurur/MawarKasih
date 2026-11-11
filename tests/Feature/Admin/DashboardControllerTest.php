<?php

use App\Models\Alumni;
use App\Models\AnakAsuh;
use App\Models\Donasi;
use App\Models\ProfilPegawai;
use App\Models\TransaksiKeuangan;
use App\Models\User;
use Illuminate\Support\Carbon;

beforeEach(function () {
    $this->admin = User::factory()->create([
        'role' => 'admin',
        'status' => 'aktif',
    ]);
    ProfilPegawai::create([
        'user_id' => $this->admin->id,
        'nama' => 'Admin Utama',
        'jabatan' => 'Administrator',
    ]);

    $this->donatur = User::factory()->create([
        'role' => 'donatur',
        'status' => 'aktif',
    ]);
});

describe('Admin DashboardController: Autentikasi dan Otorisasi', function () {
    it('test_middleware_guest: mengarahkan guest ke halaman login', function () {
        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('login'));
    });

    it('test_middleware_role: menolak akses pengguna dengan role donatur (403 Forbidden)', function () {
        $this->actingAs($this->donatur)
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    });
});

describe('Admin DashboardController: Tampilan dan Agregasi Data', function () {
    it('test_dashboard_index: berhasil memuat dashboard admin dengan status HTTP 200', function () {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertViewIs('admin.dashboard');
        $response->assertViewHasAll([
            'totalAnak',
            'totalAlumni',
            'totalPegawai',
            'totalDonatur',
            'donasiTerbaru',
            'totalDonasiPending',
            'donasiPerBulan',
            'pemasukanBulanIni',
            'pengeluaranBulanIni',
            'saldoBulanIni',
            'saldoSaatIni',
        ]);
    });

    it('test_dashboard_empty_state: dapat menampilkan dashboard dengan benar saat database masih kosong', function () {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertViewHas('totalAnak', 0);
        $response->assertViewHas('totalAlumni', 0);
        $response->assertViewHas('totalDonatur', 1); // 1 donatur dari beforeEach
        $response->assertViewHas('totalDonasiPending', 0);
        $response->assertViewHas('saldoSaatIni', 0);
    });

    it('test_dashboard_aggregation: menghitung agregasi statistik anak, donatur, donasi pending, dan keuangan dengan akurat', function () {
        // Mock waktu saat ini agar konsisten
        Carbon::setTestNow('2026-05-15 10:00:00');

        // Data Anak Asuh
        AnakAsuh::create([
            'nama' => 'Budi Santoso',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '2015-01-01',
            'status_social_anak' => 'Yatim Piatu',
        ]);

        // Donatur tambahan
        User::factory()->create(['role' => 'donatur', 'status' => 'aktif']);

        // Donasi pending
        Donasi::create([
            'kode_donasi' => 'DON-PEND-01',
            'nama_donatur' => 'Donatur Dermawan',
            'nominal' => 250000,
            'tanggal' => '2026-05-10',
            'status' => 'pending',
            'metode_pembayaran' => 'transfer_bca',
        ]);

        // Donasi diterima bulan ini
        Donasi::create([
            'kode_donasi' => 'DON-OK-01',
            'nama_donatur' => 'Donatur Setia',
            'nominal' => 500000,
            'tanggal' => '2026-05-12',
            'status' => 'diterima',
            'metode_pembayaran' => 'transfer_bca',
        ]);

        // Transaksi Keuangan: Pemasukan & Pengeluaran bulan ini
        TransaksiKeuangan::create([
            'jenis' => 'pemasukan',
            'kategori' => 'DONASI',
            'nominal' => 500000,
            'tanggal' => '2026-05-12',
            'keterangan' => 'Donasi DON-OK-01',
            'dicatat_oleh' => $this->admin->id,
        ]);

        TransaksiKeuangan::create([
            'jenis' => 'pengeluaran',
            'kategori' => 'KONSUMSI',
            'nominal' => 150000,
            'tanggal' => '2026-05-14',
            'keterangan' => 'Belanja beras',
            'dicatat_oleh' => $this->admin->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertViewHas('totalAnak', 1);
        $response->assertViewHas('totalDonatur', 2);
        $response->assertViewHas('totalDonasiPending', 1);
        $response->assertViewHas('pemasukanBulanIni', 500000);
        $response->assertViewHas('pengeluaranBulanIni', 150000);
        $response->assertViewHas('saldoBulanIni', 350000);
        $response->assertViewHas('saldoSaatIni', 350000);

        // Verifikasi array grafik donasiPerBulan (indeks bulan Mei = bulan 5, index ke-4 di 0-based array)
        $donasiPerBulan = $response->viewData('donasiPerBulan');
        expect($donasiPerBulan[4])->toEqual(500000.0);

        Carbon::setTestNow(); // reset waktu
    });
});
