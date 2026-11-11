<?php

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

describe('Bendahara LaporanKeuanganBulananController: Hak Akses Middleware', function () {
    it('test_middleware_guest: mengarahkan guest ke halaman login saat mengakses laporan keuangan bendahara', function () {
        $this->get(route('bendahara.laporan-bulanan.index'))
            ->assertRedirect(route('login'));
    });

    it('test_middleware_role: menolak akses pengguna dengan role donatur (403 Forbidden)', function () {
        $this->actingAs($this->donatur)
            ->get(route('bendahara.laporan-bulanan.index'))
            ->assertForbidden();
    });
});

describe('Bendahara LaporanKeuanganBulananController: Index & Draft Generation', function () {
    it('test_index_admin: dapat menampilkan halaman index dan otomatis membuat draft laporan bulanan berjalan', function () {
        Carbon::setTestNow('2026-07-15 10:00:00');

        $response = $this->actingAs($this->bendahara)
            ->get(route('bendahara.laporan-bulanan.index'));

        $response->assertOk();
        $response->assertViewIs('bendahara.laporan-bulanan.index');
        $response->assertViewHasAll(['laporan', 'tahun', 'bulan']);

        expect($response->viewData('tahun'))->toBe(2026);
        expect($response->viewData('bulan'))->toBe(7);

        // Pastikan draft tersimpan di database
        $this->assertDatabaseHas('laporan_keuangan_bulanans', [
            'tahun' => 2026,
            'bulan' => 7,
            'status' => 'draft',
        ]);

        Carbon::setTestNow();
    });

    it('test_kalkulasi_saldo: menghitung saldo awal dari bulan sebelumnya dan kalkulasi mutasi bulan berjalan', function () {
        // Transaksi bulan lalu (Juni 2026): Saldo awal = 1.000.000 - 300.000 = 700.000
        TransaksiKeuangan::create([
            'jenis' => 'pemasukan',
            'kategori' => 'DONASI',
            'nominal' => 1000000,
            'tanggal' => '2026-06-15',
            'keterangan' => 'Donasi Juni',
            'dicatat_oleh' => $this->bendahara->id,
        ]);
        TransaksiKeuangan::create([
            'jenis' => 'pengeluaran',
            'kategori' => 'KONSUMSI',
            'nominal' => 300000,
            'tanggal' => '2026-06-20',
            'keterangan' => 'Belanja Juni',
            'dicatat_oleh' => $this->bendahara->id,
        ]);

        // Transaksi bulan Juli 2026: Pemasukan 500.000, Pengeluaran 200.000 -> Saldo akhir = 700.000 + 500.000 - 200.000 = 1.000.000
        TransaksiKeuangan::create([
            'jenis' => 'pemasukan',
            'kategori' => 'DONASI',
            'nominal' => 500000,
            'tanggal' => '2026-07-05',
            'keterangan' => 'Donasi Juli',
            'dicatat_oleh' => $this->bendahara->id,
        ]);
        TransaksiKeuangan::create([
            'jenis' => 'pengeluaran',
            'kategori' => 'OPERASIONAL',
            'nominal' => 200000,
            'tanggal' => '2026-07-10',
            'keterangan' => 'Listrik Juli',
            'dicatat_oleh' => $this->bendahara->id,
        ]);

        $response = $this->actingAs($this->bendahara)
            ->get(route('bendahara.laporan-bulanan.index', ['tahun' => 2026, 'bulan' => 7]));

        $response->assertOk();

        $laporan = $response->viewData('laporan');
        expect((float) $laporan->saldo_awal)->toEqual(700000.0);
        expect((float) $laporan->total_pemasukan)->toEqual(500000.0);
        expect((float) $laporan->total_pengeluaran)->toEqual(200000.0);
        expect((float) $laporan->saldo_akhir)->toEqual(1000000.0);
    });
});

describe('Bendahara LaporanKeuanganBulananController: Submit Laporan', function () {
    it('test_submit_admin: berhasil mengajukan draft laporan bulanan ke ketua panti', function () {
        $laporan = LaporanKeuanganBulanan::create([
            'tahun' => 2026,
            'bulan' => 8,
            'status' => 'draft',
            'saldo_awal' => 0,
            'total_pemasukan' => 0,
            'total_pengeluaran' => 0,
            'saldo_akhir' => 0,
        ]);

        $response = $this->actingAs($this->bendahara)
            ->post(route('bendahara.laporan-bulanan.submit', $laporan));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $laporan->refresh();
        expect($laporan->status)->toBe('diajukan');
        expect($laporan->submitted_by)->toBe($this->bendahara->id);
        expect($laporan->submitted_at)->not->toBeNull();
    });

    it('test_submit_already_submitted: menolak pengajuan jika status laporan sudah diajukan atau disetujui', function () {
        $laporan = LaporanKeuanganBulanan::create([
            'tahun' => 2026,
            'bulan' => 8,
            'status' => 'diajukan',
            'saldo_awal' => 0,
            'total_pemasukan' => 0,
            'total_pengeluaran' => 0,
            'saldo_akhir' => 0,
            'submitted_by' => $this->bendahara->id,
            'submitted_at' => now(),
        ]);

        $response = $this->actingAs($this->bendahara)
            ->post(route('bendahara.laporan-bulanan.submit', $laporan));

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Laporan sudah diajukan atau disetujui.');
    });
});

describe('Bendahara LaporanKeuanganBulananController: Cetak PDF', function () {
    it('test_cetak_pdf: dapat mencetak dan mengunduh berkas laporan bulanan format PDF', function () {
        $laporan = LaporanKeuanganBulanan::create([
            'tahun' => 2026,
            'bulan' => 9,
            'status' => 'disetujui',
            'saldo_awal' => 500000,
            'total_pemasukan' => 200000,
            'total_pengeluaran' => 100000,
            'saldo_akhir' => 600000,
        ]);

        TransaksiKeuangan::create([
            'jenis' => 'pemasukan',
            'kategori' => 'DONASI',
            'nominal' => 200000,
            'tanggal' => '2026-09-10',
            'keterangan' => 'Donasi September',
            'dicatat_oleh' => $this->bendahara->id,
        ]);

        $response = $this->actingAs($this->bendahara)
            ->get(route('bendahara.laporan-bulanan.cetak', $laporan));

        $response->assertOk();
        $contentType = $response->headers->get('content-type');
        expect(str_contains($contentType, 'pdf'))->toBeTrue();
    });
});
