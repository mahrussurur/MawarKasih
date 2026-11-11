<?php

use App\Models\Donasi;
use App\Models\ProfilPegawai;
use App\Models\TransaksiKeuangan;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('public');

    $this->admin = User::factory()->create([
        'role' => 'admin',
        'status' => 'aktif',
    ]);
    ProfilPegawai::create([
        'user_id' => $this->admin->id,
        'nama' => 'Admin Keuangan',
        'jabatan' => 'Admin',
    ]);

    $this->donatur = User::factory()->create([
        'role' => 'donatur',
        'status' => 'aktif',
    ]);
});

describe('Admin DonasiController: Hak Akses Middleware', function () {
    it('test_middleware_guest: mengarahkan guest ke halaman login saat mengakses menu donasi admin', function () {
        $this->get(route('donasi.index'))->assertRedirect(route('login'));
        $this->get(route('donasi.create'))->assertRedirect(route('login'));
    });

    it('test_middleware_role: menolak akses pengguna non-admin (403 Forbidden)', function () {
        $this->actingAs($this->donatur)
            ->get(route('donasi.index'))
            ->assertForbidden();
    });
});

describe('Admin DonasiController: Index, Filter & Search', function () {
    it('test_index_admin: menampilkan daftar donasi beserta kartu ringkasan statistik', function () {
        Donasi::factory()->create([
            'status' => 'pending',
            'nominal' => 100000,
        ]);
        Donasi::factory()->create([
            'status' => 'diterima',
            'nominal' => 200000,
            'donatur_id' => null, // donatur umum
        ]);
        Donasi::factory()->create([
            'status' => 'diterima',
            'nominal' => 300000,
            'donatur_id' => $this->donatur->id, // donatur tetap
        ]);

        $response = $this->actingAs($this->admin)->get(route('donasi.index'));

        $response->assertOk();
        $response->assertViewIs('admin.donasi.index');
        $response->assertViewHasAll([
            'donasi',
            'totalDonasi',
            'totalPending',
            'totalValid',
            'totalDitolak',
            'totalNominal',
            'nominalDonaturTetap',
            'nominalDonaturUmum',
        ]);
        expect($response->viewData('totalDonasi'))->toBe(3);
        expect($response->viewData('totalPending'))->toBe(1);
        expect($response->viewData('totalValid'))->toBe(2);
        expect($response->viewData('totalNominal'))->toBe(500000);
        expect($response->viewData('nominalDonaturTetap'))->toBe(300000);
        expect($response->viewData('nominalDonaturUmum'))->toBe(200000);
    });

    it('test_index_filter_search: dapat memfilter donasi berdasarkan status dan kata kunci pencarian', function () {
        $donasi1 = Donasi::factory()->create([
            'nama_donatur' => 'Siti Khadijah',
            'kode_donasi' => 'DON-SITI-01',
            'status' => 'pending',
        ]);
        $donasi2 = Donasi::factory()->create([
            'nama_donatur' => 'Ahmad Dahlan',
            'kode_donasi' => 'DON-AHMAD-02',
            'status' => 'diterima',
        ]);

        // Filter status diterima
        $responseStatus = $this->actingAs($this->admin)
            ->get(route('donasi.index', ['status' => 'diterima']));
        $responseStatus->assertSee('Ahmad Dahlan');
        $responseStatus->assertDontSee('Siti Khadijah');

        // Search nama donatur
        $responseSearch = $this->actingAs($this->admin)
            ->get(route('donasi.index', ['search' => 'Siti']));
        $responseSearch->assertSee('Siti Khadijah');
        $responseSearch->assertDontSee('Ahmad Dahlan');
    });
});

describe('Admin DonasiController: Create & Store', function () {
    it('test_create_admin: dapat menampilkan formulir tambah donasi admin', function () {
        $this->actingAs($this->admin)
            ->get(route('donasi.create'))
            ->assertOk()
            ->assertViewIs('admin.donasi.create');
    });

    it('test_store_admin: berhasil menyimpan donasi baru dari admin dan otomatis mencatat transaksi pemasukan', function () {
        $file = UploadedFile::fake()->image('bukti.jpg');

        $payload = [
            'nama_donatur' => 'Hamba Allah',
            'email' => 'hamba@example.com',
            'no_hp' => '081234567890',
            'nominal' => 250000,
            'metode_pembayaran' => 'transfer_bca',
            'keterangan' => 'Donasi langsung via kantor',
            'bukti_transfer' => $file,
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('donasi.store'), $payload);

        $response->assertRedirect(route('donasi.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('donasi', [
            'nama_donatur' => 'Hamba Allah',
            'nominal' => 250000,
            'status' => 'diterima', // Donasi dari admin langsung diterima
        ]);

        $donasi = Donasi::where('nama_donatur', 'Hamba Allah')->first();

        // Memastikan pemasukan keuangan otomatis tercatat
        $this->assertDatabaseHas('transaksi_keuangans', [
            'donasi_id' => $donasi->id,
            'jenis' => 'pemasukan',
            'kategori' => 'DONASI',
            'nominal' => 250000,
            'dicatat_oleh' => $this->admin->id,
        ]);
    });

    it('test_store_validation: gagal menyimpan jika validasi tidak terpenuhi', function () {
        $response = $this->actingAs($this->admin)
            ->post(route('donasi.store'), [
                'nama_donatur' => '',
                'nominal' => 500, // di bawah batas minimal 1000
                'metode_pembayaran' => '',
            ]);

        $response->assertSessionHasErrors(['nama_donatur', 'nominal', 'metode_pembayaran']);
    });
});

describe('Admin DonasiController: Show, Edit & Update', function () {
    it('test_show_admin: dapat menampilkan halaman detail donasi', function () {
        $donasi = Donasi::factory()->create();

        $this->actingAs($this->admin)
            ->get(route('donasi.show', $donasi))
            ->assertOk()
            ->assertViewIs('admin.donasi.show');
    });

    it('test_edit_admin: dapat menampilkan halaman form edit donasi', function () {
        $donasi = Donasi::factory()->create();

        $this->actingAs($this->admin)
            ->get(route('donasi.edit', $donasi))
            ->assertOk()
            ->assertViewIs('admin.donasi.edit');
    });

    it('test_update_admin: dapat memperbarui data donasi dan melakukan sinkronisasi dengan keuangan', function () {
        $donasi = Donasi::factory()->create([
            'status' => 'diterima',
            'nominal' => 100000,
            'tanggal' => '2026-06-01',
        ]);

        TransaksiKeuangan::create([
            'donasi_id' => $donasi->id,
            'jenis' => 'pemasukan',
            'kategori' => 'DONASI',
            'nominal' => 100000,
            'keterangan' => 'Pemasukan donasi awal',
            'tanggal' => '2026-06-01',
            'dicatat_oleh' => $this->admin->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->put(route('donasi.update', $donasi), [
                'nama_donatur' => 'Nama Baru Donatur',
                'email' => 'namabaru@example.com',
                'no_hp' => '081298765432',
                'nominal' => 350000,
                'metode_pembayaran' => 'transfer_mandiri',
                'tanggal' => '2026-06-02',
                'keterangan' => 'Donasi diperbarui',
            ]);

        $response->assertRedirect(route('donasi.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('donasi', [
            'id' => $donasi->id,
            'nama_donatur' => 'Nama Baru Donatur',
            'nominal' => 350000,
        ]);

        // Sinkronisasi ke Transaksi Keuangan
        $this->assertDatabaseHas('transaksi_keuangans', [
            'donasi_id' => $donasi->id,
            'nominal' => 350000,
        ]);
        $transaksi = TransaksiKeuangan::where('donasi_id', $donasi->id)->first();
        expect($transaksi->tanggal->format('Y-m-d'))->toBe('2026-06-02');
    });

    it('test_update_validation: gagal menyimpan perubahan jika field wajib tidak valid', function () {
        $donasi = Donasi::factory()->create([
            'nama_donatur' => 'Donatur Awal',
            'nominal' => 100000,
        ]);

        $response = $this->actingAs($this->admin)
            ->put(route('donasi.update', $donasi), [
                'nama_donatur'      => '',                      // Field wajib kosong
                'email'             => 'bukan-email-valid',      // Format email tidak valid
                'no_hp'             => '',                      // Field wajib kosong
                'nominal'           => 500,                     // Di bawah batas minimal 1000
                'metode_pembayaran' => '',                      // Field wajib kosong
                'tanggal'           => 'bukan-format-tanggal',  // Format tanggal tidak valid
            ]);

        $response->assertSessionHasErrors([
            'nama_donatur',
            'email',
            'no_hp',
            'nominal',
            'metode_pembayaran',
            'tanggal',
        ]);

        // Memastikan data di database tidak berubah
        $fresh = $donasi->fresh();
        expect($fresh->nama_donatur)->toBe('Donatur Awal');
        expect($fresh->nominal)->toBe(100000);
    });
});

describe('Admin DonasiController: Validasi & Tolak Donasi', function () {
    it('test_validasi_admin: dapat memvalidasi donasi pending menjadi diterima dan mencatat pemasukan', function () {
        $donasi = Donasi::factory()->create([
            'status' => 'pending',
            'nominal' => 150000,
            'tanggal' => '2026-07-01',
        ]);

        $response = $this->actingAs($this->admin)
            ->patch(route('donasi.validasi', $donasi), [
                'catatan_admin' => 'Bukti transfer valid dan dana telah masuk rekening.',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $donasi->refresh();
        expect($donasi->status)->toBe('diterima');
        expect($donasi->catatan_admin)->toBe('Bukti transfer valid dan dana telah masuk rekening.');

        $this->assertDatabaseHas('transaksi_keuangans', [
            'donasi_id' => $donasi->id,
            'jenis' => 'pemasukan',
            'nominal' => 150000,
        ]);
    });

    it('test_validasi_non_pending: menolak aksi validasi pada donasi yang statusnya bukan pending', function () {
        $donasi = Donasi::factory()->create([
            'status' => 'diterima',
        ]);

        $response = $this->actingAs($this->admin)
            ->patch(route('donasi.validasi', $donasi));

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Hanya donasi berstatus pending yang bisa divalidasi.');
    });

    it('test_tolak_admin: dapat menolak donasi pending dengan menyimpan alasan penolakan', function () {
        $donasi = Donasi::factory()->create([
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin)
            ->patch(route('donasi.tolak', $donasi), [
                'catatan_admin' => 'Bukti mutasi tidak ditemukan pada tanggal tersebut.',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $donasi->refresh();
        expect($donasi->status)->toBe('ditolak');
        expect($donasi->catatan_admin)->toBe('Bukti mutasi tidak ditemukan pada tanggal tersebut.');

        $this->assertDatabaseMissing('transaksi_keuangans', [
            'donasi_id' => $donasi->id,
        ]);
    });

    it('test_tolak_non_pending: menolak aksi tolak pada donasi yang statusnya bukan pending', function () {
        $donasi = Donasi::factory()->create([
            'status' => 'ditolak',
        ]);

        $response = $this->actingAs($this->admin)
            ->patch(route('donasi.tolak', $donasi));

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Hanya donasi berstatus pending yang bisa ditolak.');
    });
});

describe('Admin DonasiController: Destroy', function () {
    it('test_destroy_admin: dapat menghapus donasi beserta data pemasukan keuangannya', function () {
        $donasi = Donasi::factory()->create([
            'status' => 'diterima',
            'nominal' => 100000,
            'tanggal' => '2026-08-01',
        ]);

        TransaksiKeuangan::create([
            'donasi_id' => $donasi->id,
            'jenis' => 'pemasukan',
            'kategori' => 'DONASI',
            'nominal' => 100000,
            'keterangan' => 'Pemasukan donasi',
            'tanggal' => '2026-08-01',
            'dicatat_oleh' => $this->admin->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->delete(route('donasi.destroy', $donasi));

        $response->assertRedirect(route('donasi.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('donasi', ['id' => $donasi->id]);
        $this->assertDatabaseMissing('transaksi_keuangans', ['donasi_id' => $donasi->id]);
    });
});
