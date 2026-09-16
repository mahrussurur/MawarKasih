<?php

use App\Models\AnakAsuh;
use App\Models\User;
use Illuminate\Support\Facades\Route;

it('does not register administrative-document routes', function () {
    expect(Route::has('admin.dokumen.index'))->toBeFalse()
        ->and(Route::has('sekretaris.dokumen.index'))->toBeFalse();

    $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);
    $sekretaris = User::factory()->create(['role' => 'sekretaris', 'status' => 'aktif']);

    $this->actingAs($admin)->get('/admin/dokumen')->assertNotFound();
    $this->actingAs($sekretaris)->get('/sekretaris/dokumen')->assertNotFound();
});

it('keeps child-care data independent of legacy progress notes', function () {
    expect(method_exists(AnakAsuh::class, 'catatanPerkembangan'))->toBeFalse();
});
