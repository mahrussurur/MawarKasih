<?php

use App\Models\Alumni;
use App\Models\AnakAsuh;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function (): void {
    Storage::fake('public');
});

it('allows admin to manage child-care data', function () {
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);

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

    $this->actingAs($admin)
        ->post(route('anak-asuh.store'), $payload)
        ->assertRedirect(route('anak-asuh.index'));

    $anak = AnakAsuh::where('nama', 'Anak Uji')->firstOrFail();
    expect($anak->nama_ayah)->toBeNull();

    $this->actingAs($admin)
        ->put(route('anak-asuh.update', $anak), [
            ...collect($payload)->except('foto')->all(),
            'nama' => 'Anak Diperbarui',
            'nama_panggilan' => 'Baru',
        ])
        ->assertRedirect(route('anak-asuh.index'));

    $this->assertDatabaseHas('anak_asuh', ['id' => $anak->id, 'nama' => 'Anak Diperbarui']);

    // Operasi hapus anak asuh ditiadakan dari sistem
    expect(\Illuminate\Support\Facades\Route::has('anak-asuh.destroy'))->toBeFalse();
    $this->actingAs($admin)
        ->delete("admin/anak-asuh/{$anak->id}")
        ->assertStatus(405);
});

it('allows ketua to view child-care data but cannot mutate', function () {
    $ketua = User::factory()->create(['role' => 'ketua', 'status' => 'aktif']);
    $anak = AnakAsuh::create([
        'nama' => 'Anak Binaan',
        'nama_panggilan' => 'Binaan',
        'tempat_lahir' => 'Bandung',
        'tanggal_lahir' => '2015-01-01',
        'jenis_kelamin' => 'L',
        'status_social_anak' => 'Yatim',
        'nama_ibu' => 'Ibu Binaan',
        'tinggal_di_lksa_sejak' => '2020',
        'sekolah' => 'SD',
        'kelas' => '3',
    ]);

    // Ketua dapat melihat daftar & detail
    $this->actingAs($ketua)
        ->get(route('ketua.anak-asuh.index'))
        ->assertOk()
        ->assertSee('Anak Binaan');

    $this->actingAs($ketua)
        ->get(route('ketua.anak-asuh.show', $anak))
        ->assertOk()
        ->assertSee('Anak Binaan');

    // Ketua ditolak melakukan mutasi data anak asuh
    $this->actingAs($ketua)
        ->post(route('anak-asuh.store'), [
            'nama' => 'Anak Ilegal',
        ])
        ->assertForbidden();

    $this->actingAs($ketua)
        ->put(route('anak-asuh.update', $anak), [
            'nama' => 'Anak Ilegal Update',
        ])
        ->assertForbidden();
});

it('allows ketua to view alumni and donatur data as read-only', function () {
    $ketua = User::factory()->create(['role' => 'ketua', 'status' => 'aktif']);
    $donatur = User::factory()->create(['role' => 'donatur', 'status' => 'aktif']);
    $donatur->profilDonatur()->create([
        'nama' => 'Donatur Dermawan',
        'no_hp' => '081299887766',
        'alamat' => 'Jl. Kebajikan No. 1',
    ]);

    $anakAlumni = AnakAsuh::create([
        'nama' => 'Alumni Sukses',
        'nama_panggilan' => 'Sukses',
        'tempat_lahir' => 'Jakarta',
        'tanggal_lahir' => '2000-01-01',
        'jenis_kelamin' => 'L',
        'status_social_anak' => 'Yatim',
        'nama_ibu' => 'Ibu Sukses',
        'tinggal_di_lksa_sejak' => '2010',
        'sekolah' => 'SMA',
        'kelas' => 'Lulus',
    ]);

    $alumni = Alumni::create([
        'anak_asuh_id' => $anakAlumni->id,
        'nama' => 'Alumni Sukses',
        'tempat_lahir' => 'Jakarta',
        'tanggal_lahir' => '2000-01-01',
        'jenis_kelamin' => 'L',
        'status_social_anak' => 'Yatim',
        'tanggal_keluar' => '2018-06-01',
        'pendidikan_terakhir' => 'SMA',
        'pekerjaan' => 'Wiraswasta',
        'no_hp' => '081234567890',
        'alamat' => 'Jakarta',
    ]);

    $this->actingAs($ketua)
        ->get(route('ketua.donatur.index'))
        ->assertOk()
        ->assertSee('Donatur Dermawan');

    $this->actingAs($ketua)
        ->get(route('ketua.donatur.show', $donatur))
        ->assertOk()
        ->assertSee('Donatur Dermawan');

    $this->actingAs($ketua)
        ->get(route('ketua.alumni.index'))
        ->assertOk()
        ->assertSee('Alumni Sukses');

    $this->actingAs($ketua)
        ->get(route('ketua.alumni.show', $alumni))
        ->assertOk()
        ->assertSee('Alumni Sukses');
});
