<?php

use App\Models\Donasi;
use App\Models\ProfilDonatur;
use App\Models\User;
use Illuminate\Support\Carbon;

beforeEach(function () {
    $this->donaturA = User::factory()->create([
        'role' => 'donatur',
        'status' => 'aktif',
    ]);
    ProfilDonatur::create([
        'user_id' => $this->donaturA->id,
        'nama' => 'Donatur Hendra',
        'no_hp' => '08111222333',
    ]);

    $this->donaturB = User::factory()->create([
        'role' => 'donatur',
        'status' => 'aktif',
    ]);
    ProfilDonatur::create([
        'user_id' => $this->donaturB->id,
        'nama' => 'Donatur Riko',
        'no_hp' => '08222333444',
    ]);
});

describe('Donatur DashboardController: Hak Akses Middleware', function () {
    it('test_middleware_guest: mengarahkan guest ke login saat mengakses dashboard donatur', function () {
        $this->get(route('donatur.dashboard'))
            ->assertRedirect(route('login'));
    });

    it('test_middleware_role: menolak akses pengguna dengan role selain donatur (403 Forbidden)', function () {
        $ketua = User::factory()->create(['role' => 'ketua', 'status' => 'aktif']);

        $this->actingAs($ketua)
            ->get(route('donatur.dashboard'))
            ->assertForbidden();
    });
});

describe('Donatur DashboardController: Tampilan dan Ringkasan Statistik', function () {
    it('test_dashboard_index: berhasil memuat halaman dashboard donatur dengan status HTTP 200', function () {
        $response = $this->actingAs($this->donaturA)
            ->get(route('donatur.dashboard'));

        $response->assertOk();
        $response->assertViewIs('donatur.dashboard');
        $response->assertViewHasAll([
            'totalDonasi',
            'totalNominal',
            'nominalBulanIni',
            'donasiTerbaru',
            'donasiPerBulan',
        ]);
    });

    it('test_dashboard_empty_state: dapat menampilkan dashboard dengan benar saat donatur belum pernah berdonasi', function () {
        $response = $this->actingAs($this->donaturA)
            ->get(route('donatur.dashboard'));

        $response->assertOk();
        expect($response->viewData('totalDonasi'))->toBe(0);
        expect($response->viewData('totalNominal'))->toBe(0);
        expect($response->viewData('nominalBulanIni'))->toBe(0);
        expect($response->viewData('donasiTerbaru')->count())->toBe(0);
        expect($response->viewData('donasiPerBulan'))->toBe(array_fill(0, 12, 0.0));
    });

    it('test_dashboard_calculation: menghitung statistik donasi secara spesifik hanya untuk donatur yang sedang login', function () {
        Carbon::setTestNow('2026-08-15 12:00:00');

        // Donasi milik Donatur A (bulan ini, status diterima)
        Donasi::factory()->create([
            'donatur_id' => $this->donaturA->id,
            'kode_donasi' => 'DON-A-01',
            'nominal' => 200000,
            'status' => 'diterima',
            'tanggal' => '2026-08-10',
        ]);

        // Donasi milik Donatur A (bulan lalu, status diterima)
        Donasi::factory()->create([
            'donatur_id' => $this->donaturA->id,
            'kode_donasi' => 'DON-A-02',
            'nominal' => 300000,
            'status' => 'diterima',
            'tanggal' => '2026-07-20',
        ]);

        // Donasi milik Donatur A (status pending, tidak masuk totalNominal)
        Donasi::factory()->create([
            'donatur_id' => $this->donaturA->id,
            'kode_donasi' => 'DON-A-03',
            'nominal' => 150000,
            'status' => 'pending',
            'tanggal' => '2026-08-12',
        ]);

        // Donasi milik Donatur A (status ditolak, masuk donasiTerbaru tapi tidak ke totalNominal)
        Donasi::factory()->create([
            'donatur_id' => $this->donaturA->id,
            'kode_donasi' => 'DON-A-04',
            'nominal' => 100000,
            'status' => 'ditolak',
            'tanggal' => '2026-08-14',
        ]);

        // Donasi milik Donatur B (tidak boleh masuk ke perhitungan A)
        Donasi::factory()->create([
            'donatur_id' => $this->donaturB->id,
            'kode_donasi' => 'DON-B-99',
            'nominal' => 1000000,
            'status' => 'diterima',
            'tanggal' => '2026-08-15',
        ]);

        $response = $this->actingAs($this->donaturA)
            ->get(route('donatur.dashboard'));

        $response->assertOk();

        // Total transaksi milik A = 4 (2 diterima + 1 pending + 1 ditolak)
        expect($response->viewData('totalDonasi'))->toBe(4);

        // Total nominal diterima milik A = 200.000 + 300.000 = 500.000
        expect($response->viewData('totalNominal'))->toBe(500000);

        // Nominal diterima bulan ini (Agustus 2026) = 200.000
        expect($response->viewData('nominalBulanIni'))->toBe(200000);

        // Riwayat donasi terbaru: hanya status diterima atau ditolak (3 item: DON-A-04, DON-A-01, DON-A-02)
        $donasiTerbaru = $response->viewData('donasiTerbaru');
        expect($donasiTerbaru->count())->toBe(3);
        expect($donasiTerbaru->pluck('kode_donasi')->toArray())->not->toContain('DON-A-03'); // pending tidak masuk
        expect($donasiTerbaru->pluck('kode_donasi')->toArray())->not->toContain('DON-B-99'); // milik B tidak masuk

        // Verifikasi grafik donasiPerBulan (Bulan Juli = index 6, Bulan Agustus = index 7)
        $donasiPerBulan = $response->viewData('donasiPerBulan');
        expect($donasiPerBulan[6])->toEqual(300000.0); // Juli
        expect($donasiPerBulan[7])->toEqual(200000.0); // Agustus

        Carbon::setTestNow();
    });
});
