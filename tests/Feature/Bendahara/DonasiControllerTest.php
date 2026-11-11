<?php

use App\Models\Donasi;
use App\Models\ProfilPegawai;
use App\Models\TransaksiKeuangan;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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

describe('Bendahara DonasiController Feature Test', function () {
    it('mengarahkan guest ke halaman login saat mengakses index donasi bendahara', function () {
        $this->get(route('bendahara.donasi.index'))
            ->assertRedirect(route('login'));
    });

    it('menolak akses pengguna non-bendahara (403 Forbidden)', function () {
        $this->actingAs($this->donatur)
            ->get(route('bendahara.donasi.index'))
            ->assertForbidden();
    });

    it('menampilkan index donasi dengan seluruh ringkasan statistik (Path 1 default index)', function () {
        Donasi::create([
            'kode_donasi' => 'DON-TETAP01',
            'nama_donatur' => 'Donatur Tetap 1',
            'nominal' => 1000000,
            'tanggal' => '2026-05-01',
            'status' => 'diterima',
            'metode_pembayaran' => 'transfer',
            'donatur_id' => $this->donatur->id,
        ]);
        Donasi::create([
            'kode_donasi' => 'DON-UMUM01',
            'nama_donatur' => 'Donatur Umum 1',
            'nominal' => 500000,
            'tanggal' => '2026-05-02',
            'status' => 'diterima',
            'metode_pembayaran' => 'tunai',
            'donatur_id' => null,
        ]);
        Donasi::create([
            'kode_donasi' => 'DON-PEND01',
            'nama_donatur' => 'Donatur Pending',
            'nominal' => 200000,
            'tanggal' => '2026-05-03',
            'status' => 'pending',
            'metode_pembayaran' => 'transfer',
        ]);

        $response = $this->actingAs($this->bendahara)
            ->get(route('bendahara.donasi.index'));

        $response->assertOk();
        $response->assertViewIs('bendahara.donasi.index');
        $response->assertViewHasAll([
            'donasi', 'totalDonasi', 'totalPending', 'totalValid', 'totalDitolak',
            'totalNominal', 'nominalDonaturTetap', 'nominalDonaturUmum'
        ]);
        expect($response->viewData('totalDonasi'))->toBe(3);
        expect($response->viewData('totalPending'))->toBe(1);
        expect($response->viewData('totalValid'))->toBe(2);
        expect($response->viewData('totalNominal'))->toEqual(1500000);
        expect($response->viewData('nominalDonaturTetap'))->toEqual(1000000);
        expect($response->viewData('nominalDonaturUmum'))->toEqual(500000);
    });

    it('dapat memfilter donasi berdasarkan status dan kata kunci pencarian (Path 2, 3, 4 index)', function () {
        Donasi::create([
            'kode_donasi' => 'DON-ALPHA',
            'nama_donatur' => 'Budi Santoso',
            'nominal' => 300000,
            'tanggal' => '2026-05-05',
            'status' => 'pending',
            'metode_pembayaran' => 'transfer',
        ]);
        Donasi::create([
            'kode_donasi' => 'DON-BETA',
            'nama_donatur' => 'Siti Rahma',
            'nominal' => 400000,
            'tanggal' => '2026-05-06',
            'status' => 'diterima',
            'metode_pembayaran' => 'transfer',
        ]);

        // Filter status
        $resStatus = $this->actingAs($this->bendahara)
            ->get(route('bendahara.donasi.index', ['status' => 'pending']));
        $resStatus->assertOk();
        expect($resStatus->viewData('donasi')->total())->toBe(1);
        expect($resStatus->viewData('donasi')->first()->kode_donasi)->toBe('DON-ALPHA');

        // Filter search nama / kode
        $resSearch = $this->actingAs($this->bendahara)
            ->get(route('bendahara.donasi.index', ['search' => 'Budi']));
        $resSearch->assertOk();
        expect($resSearch->viewData('donasi')->total())->toBe(1);
        expect($resSearch->viewData('donasi')->first()->nama_donatur)->toBe('Budi Santoso');

        // Kombinasi status + search
        $resKombinasi = $this->actingAs($this->bendahara)
            ->get(route('bendahara.donasi.index', ['status' => 'diterima', 'search' => 'DON-BETA']));
        $resKombinasi->assertOk();
        expect($resKombinasi->viewData('donasi')->total())->toBe(1);
        expect($resKombinasi->viewData('donasi')->first()->kode_donasi)->toBe('DON-BETA');
    });

    it('dapat menampilkan view form create donasi', function () {
        $response = $this->actingAs($this->bendahara)
            ->get(route('bendahara.donasi.create'));

        $response->assertOk();
        $response->assertViewIs('bendahara.donasi.create');
    });

    it('dapat menampilkan view detail show donasi', function () {
        $donasi = Donasi::create([
            'kode_donasi' => 'DON-SHOW-01',
            'nama_donatur' => 'Hamba Allah',
            'nominal' => 250000,
            'tanggal' => '2026-05-08',
            'status' => 'pending',
            'metode_pembayaran' => 'transfer',
        ]);

        $response = $this->actingAs($this->bendahara)
            ->get(route('bendahara.donasi.show', $donasi));

        $response->assertOk();
        $response->assertViewIs('bendahara.donasi.show');
        $response->assertViewHas('donasi');
    });

    it('dapat menyimpan donasi manual baru tanpa bukti transfer dan otomatis catat kas masuk (Path 1 store)', function () {
        $response = $this->actingAs($this->bendahara)
            ->post(route('bendahara.donasi.store'), [
                'nama_donatur' => 'Ahmad Fauzi',
                'no_hp' => '081234567890',
                'nominal' => 750000,
                'metode_pembayaran' => 'tunai',
                'keterangan' => 'Donasi Tunai Kantor',
            ]);

        $response->assertRedirect(route('bendahara.donasi.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('donasi', [
            'nama_donatur' => 'Ahmad Fauzi',
            'nominal' => 750000,
            'status' => 'diterima',
        ]);

        $donasi = Donasi::where('nama_donatur', 'Ahmad Fauzi')->first();
        $this->assertDatabaseHas('transaksi_keuangans', [
            'donasi_id' => $donasi->id,
            'jenis' => 'pemasukan',
            'kategori' => 'DONASI',
            'nominal' => 750000,
        ]);
    });

    it('dapat menyimpan donasi baru dengan upload berkas gambar bukti transfer (Path 2 store)', function () {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('bukti_transfer.jpg');

        $response = $this->actingAs($this->bendahara)
            ->post(route('bendahara.donasi.store'), [
                'nama_donatur' => 'Dewi Lestari',
                'no_hp' => '089876543210',
                'nominal' => 500000,
                'metode_pembayaran' => 'transfer',
                'keterangan' => 'Donasi Via M-Banking',
                'bukti_transfer' => $file,
            ]);

        $response->assertRedirect(route('bendahara.donasi.index'));
        $this->assertDatabaseHas('donasi', [
            'nama_donatur' => 'Dewi Lestari',
            'nominal' => 500000,
        ]);

        $donasi = Donasi::where('nama_donatur', 'Dewi Lestari')->first();
        expect($donasi->bukti_transfer)->not->toBeNull();
    });

    it('dapat menampilkan view form edit donasi', function () {
        $donasi = Donasi::create([
            'kode_donasi' => 'DON-EDIT-01',
            'nama_donatur' => 'Donatur Edit',
            'nominal' => 300000,
            'tanggal' => '2026-05-10',
            'status' => 'diterima',
            'metode_pembayaran' => 'transfer',
        ]);

        $response = $this->actingAs($this->bendahara)
            ->get(route('bendahara.donasi.edit', $donasi));

        $response->assertOk();
        $response->assertViewIs('bendahara.donasi.edit');
        $response->assertViewHas('donasi');
    });

    it('dapat memperbarui data donasi dan sinkronisasi nominal ke transaksi keuangan (Path 1 & 2 update)', function () {
        $donasi = Donasi::create([
            'kode_donasi' => 'DON-UPD-01',
            'nama_donatur' => 'Donatur Lama',
            'nominal' => 100000,
            'tanggal' => '2026-05-10',
            'status' => 'diterima',
            'metode_pembayaran' => 'transfer',
        ]);
        TransaksiKeuangan::create([
            'jenis' => 'pemasukan',
            'kategori' => 'DONASI',
            'nominal' => 100000,
            'tanggal' => '2026-05-10',
            'keterangan' => 'Pemasukan donasi',
            'donasi_id' => $donasi->id,
            'dicatat_oleh' => $this->bendahara->id,
        ]);

        $response = $this->actingAs($this->bendahara)
            ->put(route('bendahara.donasi.update', $donasi), [
                'nama_donatur' => 'Donatur Baru',
                'nominal' => 200000,
                'metode_pembayaran' => 'transfer',
                'tanggal' => '2026-05-10',
                'keterangan' => 'Update nominal',
            ]);

        $response->assertRedirect(route('bendahara.donasi.index'));
        $donasi->refresh();
        expect($donasi->nama_donatur)->toBe('Donatur Baru');
        expect($donasi->nominal)->toBe(200000);

        $this->assertDatabaseHas('transaksi_keuangans', [
            'donasi_id' => $donasi->id,
            'nominal' => 200000,
        ]);
    });

    it('dapat menghapus donasi dan otomatis menghapus transaksi keuangan terkait (destroy)', function () {
        $donasi = Donasi::create([
            'kode_donasi' => 'DON-DEL-01',
            'nama_donatur' => 'Donatur Hapus',
            'nominal' => 150000,
            'tanggal' => '2026-05-10',
            'status' => 'diterima',
            'metode_pembayaran' => 'transfer',
        ]);
        TransaksiKeuangan::create([
            'jenis' => 'pemasukan',
            'kategori' => 'DONASI',
            'nominal' => 150000,
            'tanggal' => '2026-05-10',
            'keterangan' => 'Donasi Hapus',
            'donasi_id' => $donasi->id,
            'dicatat_oleh' => $this->bendahara->id,
        ]);

        $response = $this->actingAs($this->bendahara)
            ->delete(route('bendahara.donasi.destroy', $donasi));

        $response->assertRedirect(route('bendahara.donasi.index'));
        $this->assertDatabaseMissing('donasi', ['id' => $donasi->id]);
        $this->assertDatabaseMissing('transaksi_keuangans', ['donasi_id' => $donasi->id]);
    });

    it('dapat memvalidasi donasi berstatus pending menjadi diterima (Path 1 validasi)', function () {
        $donasi = Donasi::create([
            'kode_donasi' => 'DON-VAL-01',
            'nama_donatur' => 'Donatur Valid',
            'nominal' => 800000,
            'tanggal' => '2026-05-12',
            'status' => 'pending',
            'metode_pembayaran' => 'transfer',
        ]);

        $response = $this->actingAs($this->bendahara)
            ->patch(route('bendahara.donasi.validasi', $donasi), [
                'catatan_admin' => 'Terverifikasi mutasi rekening.',
            ]);

        $response->assertRedirect();
        $donasi->refresh();
        expect($donasi->status)->toBe('diterima');
        expect($donasi->catatan_admin)->toBe('Terverifikasi mutasi rekening.');

        $this->assertDatabaseHas('transaksi_keuangans', [
            'donasi_id' => $donasi->id,
            'nominal' => 800000,
        ]);
    });

    it('menolak validasi pada donasi yang statusnya bukan pending (Path 2 validasi)', function () {
        $donasi = Donasi::create([
            'kode_donasi' => 'DON-NONPEND-01',
            'nama_donatur' => 'Donatur Selesai',
            'nominal' => 500000,
            'tanggal' => '2026-05-12',
            'status' => 'diterima',
            'metode_pembayaran' => 'transfer',
        ]);

        $response = $this->actingAs($this->bendahara)
            ->patch(route('bendahara.donasi.validasi', $donasi));

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Hanya donasi berstatus pending yang bisa divalidasi.');
    });

    it('dapat menolak donasi pending dengan mengisi catatan admin (Path 1 tolak)', function () {
        $donasi = Donasi::create([
            'kode_donasi' => 'DON-REJ-01',
            'nama_donatur' => 'Donatur Bodong',
            'nominal' => 300000,
            'tanggal' => '2026-05-12',
            'status' => 'pending',
            'metode_pembayaran' => 'transfer',
        ]);

        $response = $this->actingAs($this->bendahara)
            ->patch(route('bendahara.donasi.tolak', $donasi), [
                'catatan_admin' => 'Bukti transfer buram/palsu.',
            ]);

        $response->assertRedirect();
        $donasi->refresh();
        expect($donasi->status)->toBe('ditolak');
        expect($donasi->catatan_admin)->toBe('Bukti transfer buram/palsu.');
    });

    it('menolak aksi tolak pada donasi yang statusnya bukan pending (Path 2 tolak)', function () {
        $donasi = Donasi::create([
            'kode_donasi' => 'DON-REJFAIL-01',
            'nama_donatur' => 'Donatur Sukses',
            'nominal' => 300000,
            'tanggal' => '2026-05-12',
            'status' => 'diterima',
            'metode_pembayaran' => 'transfer',
        ]);

        $response = $this->actingAs($this->bendahara)
            ->patch(route('bendahara.donasi.tolak', $donasi));

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Hanya donasi berstatus pending yang bisa ditolak.');
    });
});
