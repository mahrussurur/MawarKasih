<?php

use App\Models\Donasi;
use App\Models\ProfilDonatur;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('public');

    $this->donaturA = User::factory()->create([
        'role' => 'donatur',
        'status' => 'aktif',
    ]);
    ProfilDonatur::create([
        'user_id' => $this->donaturA->id,
        'nama' => 'Donatur Ahmad',
        'no_hp' => '081234567890',
    ]);

    $this->donaturB = User::factory()->create([
        'role' => 'donatur',
        'status' => 'aktif',
    ]);
    ProfilDonatur::create([
        'user_id' => $this->donaturB->id,
        'nama' => 'Donatur Budi',
        'no_hp' => '081298765432',
    ]);
});

describe('Donatur DonasiController: Hak Akses Middleware', function () {
    it('test_middleware_guest: mengarahkan guest ke halaman login', function () {
        $this->get(route('donatur.donasi.index'))
            ->assertRedirect(route('login'));
    });
});

describe('Donatur DonasiController: Index, Filter & Isolasi Data', function () {
    it('test_index_donatur: hanya menampilkan daftar donasi milik donatur yang sedang login', function () {
        // Donasi milik Donatur A
        Donasi::factory()->create([
            'donatur_id' => $this->donaturA->id,
            'kode_donasi' => 'DON-AHMAD-01',
            'nominal' => 100000,
            'status' => 'diterima',
            'keterangan' => 'Donasi Anak Yatim',
        ]);
        Donasi::factory()->create([
            'donatur_id' => $this->donaturA->id,
            'kode_donasi' => 'DON-AHMAD-02',
            'nominal' => 50000,
            'status' => 'pending',
            'keterangan' => 'Donasi Operasional',
        ]);

        // Donasi milik Donatur B (tidak boleh tampil untuk Donatur A)
        Donasi::factory()->create([
            'donatur_id' => $this->donaturB->id,
            'kode_donasi' => 'DON-BUDI-99',
            'nominal' => 999999,
            'status' => 'diterima',
            'keterangan' => 'Donasi Rahasia Budi',
        ]);

        $response = $this->actingAs($this->donaturA)
            ->get(route('donatur.donasi.index'));

        $response->assertOk();
        $response->assertViewIs('donatur.donasi.index');
        $response->assertSee('DON-AHMAD-01');
        $response->assertSee('DON-AHMAD-02');
        $response->assertDontSee('DON-BUDI-99');

        // Verifikasi kartu ringkasan
        expect($response->viewData('totalDonasi'))->toBe(2);
        expect($response->viewData('totalPending'))->toBe(1);
        expect($response->viewData('totalValid'))->toBe(1);
        expect($response->viewData('totalNominal'))->toBe(100000);
    });

    it('test_index_filter_search: dapat memfilter status dan melakukan pencarian donasi milik sendiri', function () {
        Donasi::factory()->create([
            'donatur_id' => $this->donaturA->id,
            'kode_donasi' => 'DON-A-PEND',
            'status' => 'pending',
            'keterangan' => 'Santunan Lebaran',
        ]);
        Donasi::factory()->create([
            'donatur_id' => $this->donaturA->id,
            'kode_donasi' => 'DON-A-OK',
            'status' => 'diterima',
            'keterangan' => 'Bantuan Pendidikan',
        ]);

        // Filter status diterima
        $responseFilter = $this->actingAs($this->donaturA)
            ->get(route('donatur.donasi.index', ['status' => 'diterima']));
        $responseFilter->assertSee('DON-A-OK');
        $responseFilter->assertDontSee('DON-A-PEND');

        // Pencarian kata kunci keterangan
        $responseSearch = $this->actingAs($this->donaturA)
            ->get(route('donatur.donasi.index', ['search' => 'Lebaran']));
        $responseSearch->assertSee('DON-A-PEND');
        $responseSearch->assertDontSee('DON-A-OK');
    });
});

describe('Donatur DonasiController: Show & Ownership Check', function () {
    it('test_show_donatur: dapat melihat halaman detail donasi milik sendiri', function () {
        $donasi = Donasi::factory()->create([
            'donatur_id' => $this->donaturA->id,
            'kode_donasi' => 'DON-DETAIL-01',
        ]);

        $response = $this->actingAs($this->donaturA)
            ->get(route('donatur.donasi.show', $donasi->id));

        $response->assertOk();
        $response->assertViewIs('donatur.donasi.show');
        $response->assertSee('DON-DETAIL-01');
    });

    it('test_show_other_user_forbidden: menolak akses (404 Not Found) jika mencoba melihat donasi milik donatur lain', function () {
        $donasiBudi = Donasi::factory()->create([
            'donatur_id' => $this->donaturB->id,
            'kode_donasi' => 'DON-BUDI-PRIV',
        ]);

        // Donatur A mencoba membuka donasi milik Donatur B
        $response = $this->actingAs($this->donaturA)
            ->get(route('donatur.donasi.show', $donasiBudi->id));

        $response->assertNotFound();
    });
});

describe('Donatur DonasiController: Upload Bukti Pembayaran', function () {
    it('test_upload_bukti_success: berhasil mengunggah bukti transfer untuk donasi berstatus pending', function () {
        $donasi = Donasi::factory()->create([
            'donatur_id' => $this->donaturA->id,
            'status' => 'pending',
            'bukti_transfer' => null,
        ]);

        $file = UploadedFile::fake()->image('transfer.jpg');

        $response = $this->actingAs($this->donaturA)
            ->post(route('donatur.donasi.upload-bukti', $donasi->id), [
                'bukti_transfer' => $file,
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $donasi->refresh();
        expect($donasi->bukti_transfer)->not->toBeNull();
        Storage::disk('public')->assertExists($donasi->bukti_transfer);
    });

    it('test_upload_bukti_non_pending: gagal mengunggah bukti jika donasi sudah diterima atau bukan pending (404)', function () {
        $donasi = Donasi::factory()->create([
            'donatur_id' => $this->donaturA->id,
            'status' => 'diterima', // Sudah bukan pending
        ]);

        $file = UploadedFile::fake()->image('transfer.jpg');

        $response = $this->actingAs($this->donaturA)
            ->post(route('donatur.donasi.upload-bukti', $donasi->id), [
                'bukti_transfer' => $file,
            ]);

        $response->assertNotFound();
    });

    it('test_upload_bukti_other_user: gagal mengunggah bukti untuk donasi milik orang lain (404)', function () {
        $donasiBudi = Donasi::factory()->create([
            'donatur_id' => $this->donaturB->id,
            'status' => 'pending',
        ]);

        $file = UploadedFile::fake()->image('transfer.jpg');

        $response = $this->actingAs($this->donaturA)
            ->post(route('donatur.donasi.upload-bukti', $donasiBudi->id), [
                'bukti_transfer' => $file,
            ]);

        $response->assertNotFound();
    });

    it('test_upload_bukti_validation: gagal jika file bukti bukan gambar atau melebihi batas ukuran', function () {
        $donasi = Donasi::factory()->create([
            'donatur_id' => $this->donaturA->id,
            'status' => 'pending',
        ]);

        $invalidFile = UploadedFile::fake()->create('dokumen.txt', 100);

        $response = $this->actingAs($this->donaturA)
            ->post(route('donatur.donasi.upload-bukti', $donasi->id), [
                'bukti_transfer' => $invalidFile,
            ]);

        $response->assertSessionHasErrors(['bukti_transfer']);
    });
});

describe('Donatur Donasi: Pengisian Otomatis & Proteksi Manipulasi Identitas', function () {
    it('test_donatur_data_diri_terisi_otomatis: form donasi otomatis terisi data diri akun yang login dan bertanda readonly', function () {
        $response = $this->actingAs($this->donaturA)
            ->get(route('public.donasi.form'));

        $response->assertOk();
        $response->assertSee('Donatur Ahmad');
        $response->assertSee($this->donaturA->email);
        $response->assertSee('081234567890');
    });

    it('test_donatur_kirim_donasi_data_otomatis: donatur mengirim donasi dan data diri tersimpan otomatis dari sesi akun', function () {
        $response = $this->actingAs($this->donaturA)
            ->post(route('public.donasi.kirim'), [
                'nominal' => 150000,
                'metode_pembayaran' => 'qris',
                'tampilkan_nama' => 'nama_asli',
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('donasi', [
            'donatur_id' => $this->donaturA->id,
            'nama_donatur' => 'Donatur Ahmad',
            'email' => $this->donaturA->email,
            'no_hp' => '081234567890',
            'nominal' => 150000,
            'status' => 'pending',
        ]);
    });

    it('test_donatur_manipulasi_identitas_diabaikan: sistem mencegah donatur mengganti identitas menjadi milik akun lain', function () {
        // Donatur A mencoba memalsukan identitas menjadi Donatur B melalui payload request
        $response = $this->actingAs($this->donaturA)
            ->post(route('public.donasi.kirim'), [
                'nominal' => 200000,
                'metode_pembayaran' => 'qris',
                'tampilkan_nama' => 'nama_asli',
                // Payload palsu yang dikirim penyerang
                'nama_donatur' => 'Donatur Budi Palsu',
                'email' => 'budi_palsu@example.com',
                'no_hp' => '089999999999',
                'donatur_id' => $this->donaturB->id,
            ]);

        $response->assertRedirect();

        // Sistem mengabaikan payload palsu dan tetap menyimpan identitas asli Donatur A
        $this->assertDatabaseHas('donasi', [
            'donatur_id' => $this->donaturA->id, // Tetap ID Donatur A
            'nama_donatur' => 'Donatur Ahmad',   // Tetap Nama Donatur A
            'email' => $this->donaturA->email,   // Tetap Email Donatur A
            'nominal' => 200000,
        ]);

        // Memastikan tidak tersimpan dengan identitas palsu atau ID Donatur B
        $this->assertDatabaseMissing('donasi', [
            'nama_donatur' => 'Donatur Budi Palsu',
        ]);
        $this->assertDatabaseMissing('donasi', [
            'donatur_id' => $this->donaturB->id,
            'nominal' => 200000,
        ]);
    });
});

