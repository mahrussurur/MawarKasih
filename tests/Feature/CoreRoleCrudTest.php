<?php

use App\Models\AnakAsuh;
use App\Models\Galeri;
use App\Models\Kegiatan;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function (): void {
    Storage::fake('public');
});

it('allows admin and pengasuh to manage child-care data', function (string $role, string $prefix) {
    $user = User::factory()->create(['role' => $role, 'status' => 'aktif']);

    $payload = [
        'foto' => UploadedFile::fake()->image('anak.jpg'),
        'nama' => 'Anak Uji',
        'nama_panggilan' => 'Uji',
        'tempat_lahir' => 'Bandung',
        'tanggal_lahir' => '2015-05-10',
        'jenis_kelamin' => 'L',
        'status_social_anak' => 'Yatim',
        'nama_ayah' => 'Tidak boleh tersimpan',
        'nama_ibu' => 'Ibu Uji',
        'tinggal_di_lksa_sejak' => '2020',
        'sekolah' => 'SD Uji',
        'kelas' => '4',
    ];

    $this->actingAs($user)
        ->post(route("{$prefix}.store"), $payload)
        ->assertRedirect(route("{$prefix}.index"));

    $anak = AnakAsuh::where('nama', 'Anak Uji')->firstOrFail();
    expect($anak->nama_ayah)->toBeNull();

    $this->actingAs($user)
        ->put(route("{$prefix}.update", $anak), [
            ...collect($payload)->except('foto')->all(),
            'nama' => 'Anak Diperbarui',
            'nama_panggilan' => 'Baru',
        ])
        ->assertRedirect(route("{$prefix}.index"));

    $this->assertDatabaseHas('anak_asuh', ['id' => $anak->id, 'nama' => 'Anak Diperbarui']);

    $this->actingAs($user)
        ->delete(route("{$prefix}.destroy", $anak))
        ->assertRedirect(route("{$prefix}.index"));

    $this->assertDatabaseMissing('anak_asuh', ['id' => $anak->id]);
})->with([
    'admin' => ['admin', 'anak-asuh'],
    'pengasuh' => ['pengasuh', 'pengasuh.anak-asuh'],
]);

it('allows sekretaris to manage independent kegiatan data', function () {
    $sekretaris = User::factory()->create(['role' => 'sekretaris', 'status' => 'aktif']);

    $this->actingAs($sekretaris)
        ->post(route('sekretaris.kegiatan.store'), [
            'nama_kegiatan' => 'Kegiatan Uji',
            'tanggal_pelaksanaan' => '2026-09-16',
            'deskripsi' => 'Deskripsi kegiatan uji.',
            'foto_dokumentasi' => UploadedFile::fake()->image('kegiatan.jpg'),
        ])
        ->assertRedirect(route('sekretaris.kegiatan.index'));

    $kegiatan = Kegiatan::where('nama_kegiatan', 'Kegiatan Uji')->firstOrFail();

    $this->actingAs($sekretaris)
        ->put(route('sekretaris.kegiatan.update', $kegiatan), [
            'nama_kegiatan' => 'Kegiatan Diperbarui',
            'tanggal_pelaksanaan' => '2026-09-17',
            'deskripsi' => 'Deskripsi terbaru.',
        ])
        ->assertRedirect(route('sekretaris.kegiatan.index'));

    $this->actingAs($sekretaris)
        ->delete(route('sekretaris.kegiatan.destroy', $kegiatan))
        ->assertRedirect(route('sekretaris.kegiatan.index'));

    $this->assertDatabaseMissing('kegiatans', ['id' => $kegiatan->id]);
});

it('allows sekretaris to manage independent gallery data', function () {
    $sekretaris = User::factory()->create(['role' => 'sekretaris', 'status' => 'aktif']);

    $this->actingAs($sekretaris)
        ->post(route('sekretaris.galeri.store'), [
            'judul' => 'Galeri Uji',
            'deskripsi' => 'Deskripsi galeri uji.',
            'kategori' => 'umum',
            'foto' => UploadedFile::fake()->image('galeri.jpg'),
        ])
        ->assertRedirect(route('sekretaris.galeri.index'));

    $galeri = Galeri::where('judul', 'Galeri Uji')->firstOrFail();

    $this->actingAs($sekretaris)
        ->put(route('sekretaris.galeri.update', $galeri), [
            'judul' => 'Galeri Diperbarui',
            'deskripsi' => 'Deskripsi galeri terbaru.',
            'kategori' => 'fasilitas',
        ])
        ->assertRedirect(route('sekretaris.galeri.index'));

    $this->actingAs($sekretaris)
        ->delete(route('sekretaris.galeri.destroy', $galeri))
        ->assertRedirect(route('sekretaris.galeri.index'));

    $this->assertDatabaseMissing('galeris', ['id' => $galeri->id]);
});
