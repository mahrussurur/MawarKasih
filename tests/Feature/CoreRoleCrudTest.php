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
    $this->assertSoftDeleted('anak_asuh', ['id' => $anak->id]);
})->with([
    'admin' => ['admin', 'anak-asuh'],
    'pengasuh' => ['pengasuh', 'pengasuh.anak-asuh'],
]);

it('allows sekretaris to view independent kegiatan data', function () {
    $sekretaris = User::factory()->create(['role' => 'sekretaris', 'status' => 'aktif']);
    $kegiatan = Kegiatan::create([
        'nama_kegiatan' => 'Kegiatan Uji',
        'tanggal_pelaksanaan' => '2026-09-16',
        'deskripsi' => 'Deskripsi kegiatan uji.',
        'foto_dokumentasi' => 'kegiatan.jpg',
    ]);

    $this->actingAs($sekretaris)
        ->get(route('sekretaris.kegiatan.index'))
        ->assertOk();

    $this->actingAs($sekretaris)
        ->get(route('sekretaris.kegiatan.show', $kegiatan))
        ->assertOk();
});

it('allows sekretaris to view independent gallery data', function () {
    $sekretaris = User::factory()->create(['role' => 'sekretaris', 'status' => 'aktif']);
    $galeri = Galeri::create([
        'judul' => 'Galeri Uji',
        'deskripsi' => 'Deskripsi galeri uji.',
        'kategori' => 'Umum',
        'foto' => 'galeri.jpg',
    ]);

    $this->actingAs($sekretaris)
        ->get(route('sekretaris.galeri.index'))
        ->assertOk();

    $this->actingAs($sekretaris)
        ->get(route('sekretaris.galeri.show', $galeri))
        ->assertOk();
});

