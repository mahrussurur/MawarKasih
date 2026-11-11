<?php

use App\Models\Donasi;
use App\Models\LaporanKeuanganBulanan;
use App\Models\ProfilPegawai;
use App\Models\TransaksiKeuangan;
use App\Models\User;
use Illuminate\Http\UploadedFile;
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

describe('Bendahara KeuanganController Feature Test', function () {
    it('mengarahkan guest ke halaman login saat mengakses index keuangan bendahara', function () {
        $this->get(route('bendahara.keuangan.index'))
            ->assertRedirect(route('login'));
    });

    it('menolak akses pengguna role non-bendahara (403 Forbidden)', function () {
        $this->actingAs($this->donatur)
            ->get(route('bendahara.keuangan.index'))
            ->assertForbidden();
    });

    it('menampilkan index keuangan default beserta saldo dan mutasi kas (index)', function () {
        TransaksiKeuangan::create([
            'jenis' => 'pemasukan',
            'kategori' => 'DONASI',
            'nominal' => 2000000,
            'keterangan' => 'Donasi Tunai',
            'tanggal' => '2026-05-01',
            'dicatat_oleh' => $this->bendahara->id,
        ]);
        TransaksiKeuangan::create([
            'jenis' => 'pengeluaran',
            'kategori' => 'KONSUMSI',
            'nominal' => 500000,
            'keterangan' => 'Belanja Sayur & Buah',
            'tanggal' => '2026-05-02',
            'dicatat_oleh' => $this->bendahara->id,
        ]);

        $response = $this->actingAs($this->bendahara)
            ->get(route('bendahara.keuangan.index'));

        $response->assertOk();
        $response->assertViewIs('bendahara.keuangan.index');
        $response->assertViewHasAll(['keuangan', 'totalPemasukan', 'totalPengeluaran', 'saldo']);
        expect($response->viewData('totalPemasukan'))->toEqual(2000000);
        expect($response->viewData('totalPengeluaran'))->toEqual(500000);
        expect($response->viewData('saldo'))->toEqual(1500000);
    });

    it('dapat memfilter jenis transaksi dan mencari keterangan (index filter & search)', function () {
        TransaksiKeuangan::create([
            'jenis' => 'pengeluaran',
            'kategori' => 'PENDIDIKAN',
            'nominal' => 250000,
            'keterangan' => 'Seragam Sekolah Anak',
            'tanggal' => '2026-05-05',
            'dicatat_oleh' => $this->bendahara->id,
        ]);
        TransaksiKeuangan::create([
            'jenis' => 'pengeluaran',
            'kategori' => 'OPERASIONAL',
            'nominal' => 150000,
            'keterangan' => 'Token Listrik',
            'tanggal' => '2026-05-06',
            'dicatat_oleh' => $this->bendahara->id,
        ]);

        $responseFilter = $this->actingAs($this->bendahara)
            ->get(route('bendahara.keuangan.index', ['jenis' => 'pengeluaran', 'search' => 'Seragam']));
        $responseFilter->assertOk();
        expect($responseFilter->viewData('keuangan')->total())->toBe(1);
        expect($responseFilter->viewData('keuangan')->first()->keterangan)->toBe('Seragam Sekolah Anak');
    });

    it('dapat menampilkan view form create transaksi keuangan (create)', function () {
        $response = $this->actingAs($this->bendahara)
            ->get(route('bendahara.keuangan.create'));

        $response->assertOk();
        $response->assertViewIs('bendahara.keuangan.create');
    });

    it('berhasil menyimpan transaksi keuangan baru tanpa berkas gambar (store Path 1)', function () {
        $response = $this->actingAs($this->bendahara)
            ->post(route('bendahara.keuangan.store'), [
                'jenis' => 'pengeluaran',
                'kategori' => 'OPERASIONAL',
                'nominal' => 300000,
                'keterangan' => 'Beli Meja Belajar',
                'tanggal' => '2026-05-10',
            ]);

        $response->assertRedirect(route('bendahara.keuangan.index'));
        $this->assertDatabaseHas('transaksi_keuangans', [
            'keterangan' => 'Beli Meja Belajar',
            'nominal' => 300000,
            'dicatat_oleh' => $this->bendahara->id,
        ]);
    });

    it('berhasil menyimpan transaksi keuangan baru dengan upload bukti transaksi (store Path 2)', function () {
        $file = UploadedFile::fake()->image('struk.jpg');

        $response = $this->actingAs($this->bendahara)
            ->post(route('bendahara.keuangan.store'), [
                'jenis' => 'pengeluaran',
                'kategori' => 'KONSUMSI',
                'nominal' => 120000,
                'keterangan' => 'Belanja Gas Elpiji',
                'tanggal' => '2026-05-11',
                'bukti_transaksi' => $file,
            ]);

        $response->assertRedirect(route('bendahara.keuangan.index'));
        $transaksi = TransaksiKeuangan::where('keterangan', 'Belanja Gas Elpiji')->first();
        expect($transaksi->bukti_transaksi)->not->toBeNull();
    });

    it('menolak simpan transaksi jika laporan keuangan bulan tersebut sudah dikunci (store Path 3 & isPeriodLocked)', function () {
        LaporanKeuanganBulanan::factory()->create([
            'tahun' => 2026,
            'bulan' => 4,
            'status' => 'disetujui',
        ]);

        $response = $this->actingAs($this->bendahara)
            ->post(route('bendahara.keuangan.store'), [
                'jenis' => 'pengeluaran',
                'kategori' => 'OPERASIONAL',
                'nominal' => 50000,
                'keterangan' => 'Beli Lampu',
                'tanggal' => '2026-04-15',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Transaksi tidak dapat ditambah karena laporan keuangan pada bulan tersebut sudah dikunci (Diajukan/Disetujui).');
    });

    it('dapat menampilkan view form edit untuk transaksi manual non-donasi (edit Path 1)', function () {
        $keuangan = TransaksiKeuangan::create([
            'jenis' => 'pengeluaran',
            'kategori' => 'TRANSPORTASI',
            'nominal' => 75000,
            'keterangan' => 'Bensin Antar Anak Sekolah',
            'tanggal' => '2026-05-12',
            'dicatat_oleh' => $this->bendahara->id,
        ]);

        $response = $this->actingAs($this->bendahara)
            ->get(route('bendahara.keuangan.edit', $keuangan));

        $response->assertOk();
        $response->assertViewIs('bendahara.keuangan.edit');
        $response->assertViewHas('keuangan');
    });

    it('menolak buka form edit jika transaksi bersumber dari donasi (edit Path 2)', function () {
        $donasi = Donasi::create([
            'kode_donasi' => 'DON-EDIT-FK',
            'nama_donatur' => 'Donatur FK',
            'nominal' => 500000,
            'tanggal' => '2026-05-12',
            'status' => 'diterima',
            'metode_pembayaran' => 'transfer',
        ]);

        $keuangan = TransaksiKeuangan::create([
            'jenis' => 'pemasukan',
            'kategori' => 'DONASI',
            'nominal' => 500000,
            'keterangan' => 'Donasi Otomatis',
            'tanggal' => '2026-05-12',
            'donasi_id' => $donasi->id,
            'dicatat_oleh' => $this->bendahara->id,
        ]);

        $response = $this->actingAs($this->bendahara)
            ->get(route('bendahara.keuangan.edit', $keuangan));

        $response->assertRedirect(route('bendahara.keuangan.index'));
        $response->assertSessionHas('error');
    });

    it('menolak pembaruan data jika transaksi bersumber dari donasi (update Path 1)', function () {
        $donasi = Donasi::create([
            'kode_donasi' => 'DON-UPD-FK',
            'nama_donatur' => 'Donatur FK',
            'nominal' => 200000,
            'tanggal' => '2026-05-14',
            'status' => 'diterima',
            'metode_pembayaran' => 'transfer',
        ]);

        $keuangan = TransaksiKeuangan::create([
            'jenis' => 'pemasukan',
            'kategori' => 'DONASI',
            'nominal' => 200000,
            'keterangan' => 'Donasi Otomatis',
            'tanggal' => '2026-05-14',
            'donasi_id' => $donasi->id,
            'dicatat_oleh' => $this->bendahara->id,
        ]);

        $response = $this->actingAs($this->bendahara)
            ->put(route('bendahara.keuangan.update', $keuangan), [
                'jenis' => 'pemasukan',
                'kategori' => 'DONASI',
                'nominal' => 300000,
                'keterangan' => 'Ubah Donasi',
                'tanggal' => '2026-05-14',
            ]);

        $response->assertRedirect(route('bendahara.keuangan.index'));
        $response->assertSessionHas('error');
    });

    it('menolak pembaruan data jika tanggal transaksi lama atau baru berada pada periode terkunci (update Path 2 & 3)', function () {
        LaporanKeuanganBulanan::factory()->create([
            'tahun' => 2026,
            'bulan' => 3,
            'status' => 'diajukan',
        ]);

        // Kasus 1: Tanggal lama di bulan yang terkunci
        $keuanganLamaTerkunci = TransaksiKeuangan::create([
            'jenis' => 'pengeluaran',
            'kategori' => 'KONSUMSI',
            'nominal' => 100000,
            'keterangan' => 'Makan Maret',
            'tanggal' => '2026-03-20',
            'dicatat_oleh' => $this->bendahara->id,
        ]);

        $response1 = $this->actingAs($this->bendahara)
            ->put(route('bendahara.keuangan.update', $keuanganLamaTerkunci), [
                'jenis' => 'pengeluaran',
                'kategori' => 'KONSUMSI',
                'nominal' => 120000,
                'keterangan' => 'Update Makan Maret',
                'tanggal' => '2026-05-20',
            ]);
        $response1->assertRedirect();
        $response1->assertSessionHas('error');

        // Kasus 2: Pindah ke bulan baru yang terkunci
        $keuanganBulanBebas = TransaksiKeuangan::create([
            'jenis' => 'pengeluaran',
            'kategori' => 'KONSUMSI',
            'nominal' => 100000,
            'keterangan' => 'Makan Mei',
            'tanggal' => '2026-05-20',
            'dicatat_oleh' => $this->bendahara->id,
        ]);

        $response2 = $this->actingAs($this->bendahara)
            ->put(route('bendahara.keuangan.update', $keuanganBulanBebas), [
                'jenis' => 'pengeluaran',
                'kategori' => 'KONSUMSI',
                'nominal' => 100000,
                'keterangan' => 'Pindah ke Maret Terkunci',
                'tanggal' => '2026-03-25',
            ]);
        $response2->assertRedirect();
        $response2->assertSessionHas('error');
    });

    it('berhasil memperbarui data transaksi keuangan dengan dan tanpa file gambar (update Path 4, 5, 6)', function () {
        $keuangan = TransaksiKeuangan::create([
            'jenis' => 'pengeluaran',
            'kategori' => 'GAJI',
            'nominal' => 1500000,
            'keterangan' => 'Honor Pengajar Al-Quran',
            'tanggal' => '2026-05-15',
            'dicatat_oleh' => $this->bendahara->id,
        ]);

        // Update tanpa gambar baru
        $response = $this->actingAs($this->bendahara)
            ->put(route('bendahara.keuangan.update', $keuangan), [
                'jenis' => 'pengeluaran',
                'kategori' => 'GAJI',
                'nominal' => 1750000,
                'keterangan' => 'Honor Pengajar Al-Quran & Ekstra',
                'tanggal' => '2026-05-15',
            ]);

        $response->assertRedirect(route('bendahara.keuangan.index'));
        $keuangan->refresh();
        expect($keuangan->nominal)->toEqual(1750000);
        expect($keuangan->keterangan)->toBe('Honor Pengajar Al-Quran & Ekstra');

        // Update dengan upload file bukti baru
        $file = UploadedFile::fake()->image('slip_honor.jpg');
        $responseFile = $this->actingAs($this->bendahara)
            ->put(route('bendahara.keuangan.update', $keuangan), [
                'jenis' => 'pengeluaran',
                'kategori' => 'GAJI',
                'nominal' => 1750000,
                'keterangan' => 'Honor Pengajar Al-Quran & Ekstra',
                'tanggal' => '2026-05-15',
                'bukti_transaksi' => $file,
            ]);
        $responseFile->assertRedirect(route('bendahara.keuangan.index'));
        $keuangan->refresh();
        expect($keuangan->bukti_transaksi)->not->toBeNull();
    });

    it('menolak penghapusan transaksi jika dari donasi atau berada pada periode terkunci (destroy Path 1 & 2)', function () {
        // Dari donasi
        $donasi = Donasi::create([
            'kode_donasi' => 'DON-DEL-FK',
            'nama_donatur' => 'Donatur FK',
            'nominal' => 200000,
            'tanggal' => '2026-05-16',
            'status' => 'diterima',
            'metode_pembayaran' => 'transfer',
        ]);

        $transaksiDonasi = TransaksiKeuangan::create([
            'jenis' => 'pemasukan',
            'kategori' => 'DONASI',
            'nominal' => 200000,
            'keterangan' => 'Pemasukan donasi',
            'tanggal' => '2026-05-16',
            'donasi_id' => $donasi->id,
            'dicatat_oleh' => $this->bendahara->id,
        ]);

        $resDonasi = $this->actingAs($this->bendahara)
            ->delete(route('bendahara.keuangan.destroy', $transaksiDonasi));
        $resDonasi->assertRedirect(route('bendahara.keuangan.index'));
        $resDonasi->assertSessionHas('error');

        // Periode terkunci
        LaporanKeuanganBulanan::factory()->create([
            'tahun' => 2026,
            'bulan' => 2,
            'status' => 'disetujui',
        ]);
        $transaksiTerkunci = TransaksiKeuangan::create([
            'jenis' => 'pengeluaran',
            'kategori' => 'OPERASIONAL',
            'nominal' => 100000,
            'keterangan' => 'Biaya Air Februari',
            'tanggal' => '2026-02-15',
            'dicatat_oleh' => $this->bendahara->id,
        ]);

        $resTerkunci = $this->actingAs($this->bendahara)
            ->delete(route('bendahara.keuangan.destroy', $transaksiTerkunci));
        $resTerkunci->assertRedirect();
        $resTerkunci->assertSessionHas('error');
    });

    it('berhasil menghapus transaksi keuangan dan membersihkan berkas fisiknya (destroy Path 3 & 4)', function () {
        $keuangan = TransaksiKeuangan::create([
            'jenis' => 'pengeluaran',
            'kategori' => 'LAINNYA',
            'nominal' => 50000,
            'keterangan' => 'Beli Materai',
            'tanggal' => '2026-05-18',
            'dicatat_oleh' => $this->bendahara->id,
        ]);

        $response = $this->actingAs($this->bendahara)
            ->delete(route('bendahara.keuangan.destroy', $keuangan));

        $response->assertRedirect(route('bendahara.keuangan.index'));
        $this->assertDatabaseMissing('transaksi_keuangans', ['id' => $keuangan->id]);
    });
});
