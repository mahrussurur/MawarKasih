<?php

use App\Models\AnakAsuh;
use App\Models\User;
use Illuminate\Support\Facades\Route;

it('ensures legacy roles sekretaris and pengasuh routes are completely removed', function () {
    expect(Route::has('sekretaris.dashboard'))->toBeFalse()
        ->and(Route::has('sekretaris.kegiatan.index'))->toBeFalse()
        ->and(Route::has('sekretaris.galeri.index'))->toBeFalse()
        ->and(Route::has('pengasuh.dashboard'))->toBeFalse()
        ->and(Route::has('pengasuh.anak-asuh.index'))->toBeFalse()
        ->and(Route::has('pengasuh.alumni.index'))->toBeFalse();

    $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);
    $ketua = User::factory()->create(['role' => 'ketua', 'status' => 'aktif']);

    $this->actingAs($admin)->get('/sekretaris/dashboard')->assertNotFound();
    $this->actingAs($admin)->get('/pengasuh/dashboard')->assertNotFound();
    $this->actingAs($ketua)->get('/sekretaris/dashboard')->assertNotFound();
    $this->actingAs($ketua)->get('/pengasuh/dashboard')->assertNotFound();
});

it('keeps child-care data independent of legacy progress notes', function () {
    expect(method_exists(AnakAsuh::class, 'catatanPerkembangan'))->toBeFalse();
});
