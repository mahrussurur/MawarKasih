<?php

use App\Models\ArsipDokumen;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function (): void {
    Storage::fake('local');
});

it('allows admin to view archive list, upload, view detail, update, download, and delete a private document', function () {
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);

    // 1. Admin melihat index arsip dokumen
    $this->actingAs($admin)
        ->get(route('admin.arsip-dokumen.index'))
        ->assertOk()
        ->assertSee('Kelola Arsip Dokumen Administrasi')
        ->assertSee('Unggah Dokumen Baru');

    // 2. Admin mengunggah dokumen baru
    $file = UploadedFile::fake()->create('akta_pendirian.pdf', 500, 'application/pdf');

    $response = $this->actingAs($admin)->post(route('admin.arsip-dokumen.store'), [
        'judul' => 'Akta Notaris Pendirian Yayasan',
        'nomor_dokumen' => 'AHU-001/2026',
        'kategori' => 'Legalitas',
        'tanggal_dokumen' => '2026-01-15',
        'deskripsi' => 'Salinan resmi akta notaris yayasan',
        'file' => $file,
    ]);

    $response->assertRedirect(route('admin.arsip-dokumen.index'))
        ->assertSessionHas('success');

    $arsip = ArsipDokumen::where('nomor_dokumen', 'AHU-001/2026')->firstOrFail();
    expect($arsip->judul)->toBe('Akta Notaris Pendirian Yayasan')
        ->and($arsip->uploaded_by)->toBe($admin->id)
        ->and($arsip->file_name_asli)->toBe('akta_pendirian.pdf');

    Storage::disk('local')->assertExists($arsip->file_path);

    // 3. Admin melihat detail dokumen
    $this->actingAs($admin)
        ->get(route('admin.arsip-dokumen.show', $arsip))
        ->assertOk()
        ->assertSee('Akta Notaris Pendirian Yayasan')
        ->assertSee('Unduh Berkas')
        ->assertSee('Edit')
        ->assertSee('Hapus');

    // 4. Admin memperbarui metadata dokumen
    $this->actingAs($admin)
        ->put(route('admin.arsip-dokumen.update', $arsip), [
            'judul' => 'Akta Notaris Pendirian Yayasan Revisi',
            'nomor_dokumen' => 'AHU-001/2026-REV',
            'kategori' => 'Legalitas',
            'tanggal_dokumen' => '2026-01-16',
            'deskripsi' => 'Revisi deskripsi akta notaris',
        ])
        ->assertRedirect(route('admin.arsip-dokumen.index'))
        ->assertSessionHas('success');

    $arsip->refresh();
    expect($arsip->judul)->toBe('Akta Notaris Pendirian Yayasan Revisi')
        ->and($arsip->nomor_dokumen)->toBe('AHU-001/2026-REV');

    // 5. Admin mengunduh dokumen
    $downloadResponse = $this->actingAs($admin)
        ->get(route('admin.arsip-dokumen.download', $arsip));

    $downloadResponse->assertOk();
    $downloadResponse->assertDownload('akta_pendirian.pdf');

    // 6. Admin menghapus dokumen dan berkas fisik
    $filePath = $arsip->file_path;
    $deleteResponse = $this->actingAs($admin)
        ->delete(route('admin.arsip-dokumen.destroy', $arsip));

    $deleteResponse->assertRedirect(route('admin.arsip-dokumen.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('arsip_dokumens', ['id' => $arsip->id]);
    Storage::disk('local')->assertMissing($filePath);
});

it('validates file mime types and maximum file size for document archive on admin upload', function () {
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);

    // File terlarang (.exe / .sh)
    $invalidFile = UploadedFile::fake()->create('malicious.exe', 100);

    $this->actingAs($admin)
        ->post(route('admin.arsip-dokumen.store'), [
            'judul' => 'File Terlarang',
            'kategori' => 'Legalitas',
            'file' => $invalidFile,
        ])
        ->assertSessionHasErrors('file');

    // File melebihi batas 10 MB (10240 KB)
    $oversizedFile = UploadedFile::fake()->create('huge_file.pdf', 12000, 'application/pdf');

    $this->actingAs($admin)
        ->post(route('admin.arsip-dokumen.store'), [
            'judul' => 'File Terlalu Besar',
            'kategori' => 'Legalitas',
            'file' => $oversizedFile,
        ])
        ->assertSessionHasErrors('file');
});

it('allows ketua to view archive list, view metadata detail, and download private document without management actions', function () {
    $ketua = User::factory()->create(['role' => 'ketua', 'status' => 'aktif']);
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);

    $file = UploadedFile::fake()->create('sk_pengurus.pdf', 300, 'application/pdf');
    $path = $file->store('arsip-dokumen', 'local');

    $arsip = ArsipDokumen::create([
        'judul' => 'SK Pengurus Yayasan 2026',
        'nomor_dokumen' => 'SK-01/MK/2026',
        'kategori' => 'Legalitas',
        'tanggal_dokumen' => '2026-02-01',
        'file_path' => $path,
        'file_name_asli' => 'sk_pengurus.pdf',
        'file_size' => 300 * 1024,
        'mime_type' => 'application/pdf',
        'uploaded_by' => $admin->id,
    ]);

    // Ketua melihat daftar arsip (read-only, tidak ada tombol unggah)
    $this->actingAs($ketua)
        ->get(route('ketua.arsip-dokumen.index'))
        ->assertOk()
        ->assertSee('Arsip Dokumen Administrasi Panti')
        ->assertSee('Akses Ketua: Lihat & Unduh')
        ->assertSee('SK Pengurus Yayasan 2026')
        ->assertDontSee('Unggah Dokumen Baru');

    // Ketua melihat rincian detail (tidak ada tombol edit atau hapus)
    $this->actingAs($ketua)
        ->get(route('ketua.arsip-dokumen.show', $arsip))
        ->assertOk()
        ->assertSee('SK Pengurus Yayasan 2026')
        ->assertSee('SK-01/MK/2026')
        ->assertSee('Unduh Berkas')
        ->assertDontSee('formDelete');

    // Ketua mengunduh berkas
    $downloadResponse = $this->actingAs($ketua)
        ->get(route('ketua.arsip-dokumen.download', $arsip));

    $downloadResponse->assertOk();
    $downloadResponse->assertDownload('sk_pengurus.pdf');
});

it('prohibits ketua from mutating or managing documents', function () {
    $ketua = User::factory()->create(['role' => 'ketua', 'status' => 'aktif']);
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);

    $file = UploadedFile::fake()->create('surat.pdf', 100, 'application/pdf');
    $path = $file->store('arsip-dokumen', 'local');

    $arsip = ArsipDokumen::create([
        'judul' => 'Surat Resmi Yayasan',
        'kategori' => 'Surat Masuk',
        'file_path' => $path,
        'file_name_asli' => 'surat.pdf',
        'file_size' => 100 * 1024,
        'mime_type' => 'application/pdf',
        'uploaded_by' => $admin->id,
    ]);

    // Ketua dilarang mengakses route pengelolaan Admin (store / update / destroy)
    $this->actingAs($ketua)
        ->post(route('admin.arsip-dokumen.store'), [
            'judul' => 'Dokumen Liar',
            'kategori' => 'Legalitas',
            'file' => $file,
        ])
        ->assertForbidden();

    $this->actingAs($ketua)
        ->delete(route('admin.arsip-dokumen.destroy', $arsip))
        ->assertForbidden();

    // Route store dan destroy pada prefix ketua sudah dihapus (tidak tersedia)
    expect(Route::has('ketua.arsip-dokumen.store'))->toBeFalse()
        ->and(Route::has('ketua.arsip-dokumen.destroy'))->toBeFalse();
});

it('denies guests, bendahara, and donatur from accessing document archives', function () {
    $bendahara = User::factory()->create(['role' => 'bendahara', 'status' => 'aktif']);
    $donatur = User::factory()->create(['role' => 'donatur', 'status' => 'aktif']);

    // Tamu (unauthenticated) diarahkan ke login
    $this->get(route('admin.arsip-dokumen.index'))->assertRedirect(route('login'));
    $this->get(route('ketua.arsip-dokumen.index'))->assertRedirect(route('login'));

    // Bendahara ditolak
    $this->actingAs($bendahara)
        ->get(route('admin.arsip-dokumen.index'))
        ->assertForbidden();

    $this->actingAs($bendahara)
        ->get(route('ketua.arsip-dokumen.index'))
        ->assertForbidden();

    // Donatur ditolak
    $this->actingAs($donatur)
        ->get(route('admin.arsip-dokumen.index'))
        ->assertForbidden();

    $this->actingAs($donatur)
        ->get(route('ketua.arsip-dokumen.index'))
        ->assertForbidden();
});
