<?php

use App\Models\ArsipDokumen;
use App\Models\ProfilPegawai;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('local');

    $this->admin = User::factory()->create([
        'role' => 'admin',
        'status' => 'aktif',
    ]);
    ProfilPegawai::create([
        'user_id' => $this->admin->id,
        'nama' => 'Admin Pengelola',
        'jabatan' => 'Administrator',
    ]);

    $this->donatur = User::factory()->create([
        'role' => 'donatur',
        'status' => 'aktif',
    ]);
});

describe('Admin ArsipDokumenController: Hak Akses Middleware', function () {
    it('test_middleware_guest: mengarahkan guest ke halaman login saat mengakses arsip dokumen', function () {
        $this->get(route('admin.arsip-dokumen.index'))
            ->assertRedirect(route('login'));

        $this->get(route('admin.arsip-dokumen.create'))
            ->assertRedirect(route('login'));
    });

    it('test_middleware_role: menolak akses pengguna non-admin (403 Forbidden)', function () {
        $this->actingAs($this->donatur)
            ->get(route('admin.arsip-dokumen.index'))
            ->assertForbidden();
    });
});

describe('Admin ArsipDokumenController: Index & Filter', function () {
    it('test_index_admin: menampilkan daftar arsip dokumen untuk admin', function () {
        $arsip = ArsipDokumen::create([
            'judul' => 'Surat Keputusan Legalitas',
            'nomor_dokumen' => 'SK-001/2026',
            'kategori' => 'Legalitas',
            'tanggal_dokumen' => '2026-01-10',
            'deskripsi' => 'Dokumen resmi pendirian',
            'file_name_asli' => 'sk_legalitas.pdf',
            'file_path' => 'arsip-dokumen/sample.pdf',
            'file_size' => 2048,
            'mime_type' => 'application/pdf',
            'uploaded_by' => $this->admin->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.arsip-dokumen.index'));

        $response->assertOk();
        $response->assertViewIs('admin.arsip-dokumen.index');
        $response->assertViewHas('arsips');
        $response->assertSee('Surat Keputusan Legalitas');
    });

    it('test_index_filter: dapat memfilter arsip berdasarkan kategori dan kata kunci pencarian', function () {
        ArsipDokumen::create([
            'judul' => 'Notula Rapat Yayasan 2026',
            'nomor_dokumen' => 'NOT-01',
            'kategori' => 'Notula Rapat',
            'tanggal_dokumen' => '2026-02-01',
            'file_name_asli' => 'notula.pdf',
            'file_path' => 'arsip-dokumen/notula.pdf',
            'file_size' => 1024,
            'mime_type' => 'application/pdf',
            'uploaded_by' => $this->admin->id,
        ]);

        ArsipDokumen::create([
            'judul' => 'Surat Izin Operasional',
            'nomor_dokumen' => 'LEG-02',
            'kategori' => 'Legalitas',
            'tanggal_dokumen' => '2026-02-05',
            'file_name_asli' => 'izin.pdf',
            'file_path' => 'arsip-dokumen/izin.pdf',
            'file_size' => 1024,
            'mime_type' => 'application/pdf',
            'uploaded_by' => $this->admin->id,
        ]);

        // Filter kategori Legalitas
        $responseKategori = $this->actingAs($this->admin)
            ->get(route('admin.arsip-dokumen.index', ['kategori' => 'Legalitas']));
        $responseKategori->assertSee('Surat Izin Operasional');
        $responseKategori->assertDontSee('Notula Rapat Yayasan 2026');

        // Pencarian dengan search keyword
        $responseSearch = $this->actingAs($this->admin)
            ->get(route('admin.arsip-dokumen.index', ['search' => 'Notula']));
        $responseSearch->assertSee('Notula Rapat Yayasan 2026');
        $responseSearch->assertDontSee('Surat Izin Operasional');
    });
});

describe('Admin ArsipDokumenController: Create & Store', function () {
    it('test_create_admin: dapat menampilkan form create arsip dokumen', function () {
        $this->actingAs($this->admin)
            ->get(route('admin.arsip-dokumen.create'))
            ->assertOk()
            ->assertViewIs('admin.arsip-dokumen.create');
    });

    it('test_store_admin: berhasil menyimpan berkas arsip dokumen baru ke storage local', function () {
        $file = UploadedFile::fake()->create('anggaran_dasar.pdf', 500, 'application/pdf');

        $payload = [
            'judul' => 'Anggaran Dasar Panti Asuhan',
            'nomor_dokumen' => 'AD-ART/01/2026',
            'kategori' => 'Legalitas',
            'tanggal_dokumen' => '2026-03-01',
            'deskripsi' => 'Dokumen AD ART resmi.',
            'file' => $file,
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.arsip-dokumen.store'), $payload);

        $response->assertRedirect(route('admin.arsip-dokumen.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('arsip_dokumens', [
            'judul' => 'Anggaran Dasar Panti Asuhan',
            'nomor_dokumen' => 'AD-ART/01/2026',
            'kategori' => 'Legalitas',
            'file_name_asli' => 'anggaran_dasar.pdf',
            'uploaded_by' => $this->admin->id,
        ]);

        $arsip = ArsipDokumen::where('nomor_dokumen', 'AD-ART/01/2026')->first();
        Storage::disk('local')->assertExists($arsip->file_path);
    });

    it('test_store_validation: gagal menyimpan jika data wajib atau file kosong / tidak valid', function () {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.arsip-dokumen.store'), [
                'judul' => '',
                'kategori' => '',
            ]);

        $response->assertSessionHasErrors(['judul', 'kategori', 'file']);
    });
});

describe('Admin ArsipDokumenController: Show, Edit & Update', function () {
    it('test_show_admin: dapat menampilkan detail arsip dokumen', function () {
        $arsip = ArsipDokumen::create([
            'judul' => 'Surat Pengesahan Kemenkumham',
            'nomor_dokumen' => 'AHU-001',
            'kategori' => 'Legalitas',
            'file_name_asli' => 'ahu.pdf',
            'file_path' => 'arsip-dokumen/ahu.pdf',
            'file_size' => 1200,
            'mime_type' => 'application/pdf',
            'uploaded_by' => $this->admin->id,
        ]);

        $this->actingAs($this->admin)
            ->get(route('admin.arsip-dokumen.show', $arsip))
            ->assertOk()
            ->assertViewIs('admin.arsip-dokumen.show')
            ->assertSee('Surat Pengesahan Kemenkumham');
    });

    it('test_edit_admin: dapat menampilkan halaman form edit arsip dokumen', function () {
        $arsip = ArsipDokumen::create([
            'judul' => 'Surat Pengesahan Kemenkumham',
            'nomor_dokumen' => 'AHU-001',
            'kategori' => 'Legalitas',
            'file_name_asli' => 'ahu.pdf',
            'file_path' => 'arsip-dokumen/ahu.pdf',
            'file_size' => 1200,
            'mime_type' => 'application/pdf',
            'uploaded_by' => $this->admin->id,
        ]);

        $this->actingAs($this->admin)
            ->get(route('admin.arsip-dokumen.edit', $arsip))
            ->assertOk()
            ->assertViewIs('admin.arsip-dokumen.edit')
            ->assertSee('Surat Pengesahan Kemenkumham');
    });

    it('test_update_admin: dapat memperbarui metadata arsip tanpa mengubah file', function () {
        $arsip = ArsipDokumen::create([
            'judul' => 'Judul Lama',
            'nomor_dokumen' => 'DOC-01',
            'kategori' => 'Surat Masuk',
            'file_name_asli' => 'surat.pdf',
            'file_path' => 'arsip-dokumen/surat.pdf',
            'file_size' => 1200,
            'mime_type' => 'application/pdf',
            'uploaded_by' => $this->admin->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->put(route('admin.arsip-dokumen.update', $arsip), [
                'judul' => 'Judul Baru Diperbarui',
                'nomor_dokumen' => 'DOC-01-REV',
                'kategori' => 'Surat Masuk',
            ]);

        $response->assertRedirect(route('admin.arsip-dokumen.index'));
        $this->assertDatabaseHas('arsip_dokumens', [
            'id' => $arsip->id,
            'judul' => 'Judul Baru Diperbarui',
            'nomor_dokumen' => 'DOC-01-REV',
            'file_name_asli' => 'surat.pdf',
        ]);
    });

    it('test_update_file_admin: dapat memperbarui file arsip dan menghapus file lama dari storage', function () {
        // Simpan dummy file lama
        $oldPath = 'arsip-dokumen/old_file.pdf';
        Storage::disk('local')->put($oldPath, 'konten file lama');

        $arsip = ArsipDokumen::create([
            'judul' => 'Sertifikat Tanah Yayasan',
            'nomor_dokumen' => 'SERT-001',
            'kategori' => 'Legalitas',
            'file_name_asli' => 'old_file.pdf',
            'file_path' => $oldPath,
            'file_size' => 100,
            'mime_type' => 'application/pdf',
            'uploaded_by' => $this->admin->id,
        ]);

        $newFile = UploadedFile::fake()->create('sertifikat_baru.pdf', 300, 'application/pdf');

        $response = $this->actingAs($this->admin)
            ->put(route('admin.arsip-dokumen.update', $arsip), [
                'judul' => 'Sertifikat Tanah Yayasan (Terbaru)',
                'kategori' => 'Legalitas',
                'file' => $newFile,
            ]);

        $response->assertRedirect(route('admin.arsip-dokumen.index'));

        // File lama harus terhapus
        Storage::disk('local')->assertMissing($oldPath);

        $arsip->refresh();
        $this->assertEquals('sertifikat_baru.pdf', $arsip->file_name_asli);
        Storage::disk('local')->assertExists($arsip->file_path);
    });
});

describe('Admin ArsipDokumenController: Download & Destroy', function () {
    it('test_download_admin: dapat mengunduh berkas dokumen yang tersimpan', function () {
        $filePath = 'arsip-dokumen/legalitas.pdf';
        Storage::disk('local')->put($filePath, 'konten berkas pdf');

        $arsip = ArsipDokumen::create([
            'judul' => 'Akta Notaris Pendirian',
            'nomor_dokumen' => 'AKTA-01',
            'kategori' => 'Legalitas',
            'file_name_asli' => 'legalitas.pdf',
            'file_path' => $filePath,
            'file_size' => 100,
            'mime_type' => 'application/pdf',
            'uploaded_by' => $this->admin->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.arsip-dokumen.download', $arsip));

        $response->assertOk();
    });

    it('test_download_missing_file: memberikan pesan error saat mengunduh berkas fisik yang hilang di server', function () {
        $arsip = ArsipDokumen::create([
            'judul' => 'Berkas Hilang',
            'nomor_dokumen' => 'HLG-01',
            'kategori' => 'Lainnya',
            'file_name_asli' => 'missing.pdf',
            'file_path' => 'arsip-dokumen/missing.pdf',
            'file_size' => 100,
            'mime_type' => 'application/pdf',
            'uploaded_by' => $this->admin->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.arsip-dokumen.download', $arsip));

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Berkas fisik dokumen tidak ditemukan di penyimpanan server.');
    });

    it('test_destroy_admin: dapat menghapus arsip dokumen dan berkas fisik dari storage', function () {
        $filePath = 'arsip-dokumen/hapus_target.pdf';
        Storage::disk('local')->put($filePath, 'konten file yang akan dihapus');

        $arsip = ArsipDokumen::create([
            'judul' => 'Dokumen Hapus',
            'nomor_dokumen' => 'DEL-01',
            'kategori' => 'Lainnya',
            'file_name_asli' => 'hapus_target.pdf',
            'file_path' => $filePath,
            'file_size' => 100,
            'mime_type' => 'application/pdf',
            'uploaded_by' => $this->admin->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.arsip-dokumen.destroy', $arsip));

        $response->assertRedirect(route('admin.arsip-dokumen.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('arsip_dokumens', ['id' => $arsip->id]);
        Storage::disk('local')->assertMissing($filePath);
    });
});
