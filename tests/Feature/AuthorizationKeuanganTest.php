<?php

use App\Models\User;
use App\Models\TransaksiKeuangan;
use App\Models\LaporanKeuanganBulanan;

it('ketua ditolak akses menu keuangan langsung bendahara (Test 6)', function () {
    $ketua = User::factory()->create(['role' => 'ketua', 'status' => 'aktif']);

    // Ketua mencoba mengakses index transaksi keuangan bendahara
    $this->actingAs($ketua)
        ->get(route('bendahara.keuangan.index'))
        ->assertForbidden();
});

it('admin dapat view keuangan tapi ditolak create (Test 7)', function () {
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);

    // View index
    $this->actingAs($admin)
        ->get(route('admin.keuangan.index'))
        ->assertOk();

    // Create (harus gagal, rute store/create tidak ada di admin)
    $this->actingAs($admin)
        ->post('admin/keuangan', [
            'tanggal' => '2026-10-15',
            'jenis' => 'pemasukan',
            'nominal' => 100000,
            'keterangan' => 'Test',
            'kategori' => 'DONASI'
        ])
        ->assertStatus(405); // Route tidak didefinisikan untuk POST di admin
});

it('admin tidak dapat delete transaksi (Test 8)', function () {
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);
    $transaksi = TransaksiKeuangan::factory()->create();

    $this->actingAs($admin)
        ->delete("admin/keuangan/{$transaksi->id}")
        ->assertNotFound();
        
    $this->assertDatabaseHas('transaksi_keuangans', ['id' => $transaksi->id]);
});

it('bendahara dapat create transaksi (Test 9)', function () {
    $bendahara = User::factory()->create(['role' => 'bendahara', 'status' => 'aktif']);

    $this->actingAs($bendahara)
        ->post(route('bendahara.keuangan.store'), [
            'tanggal' => '2026-10-15',
            'jenis' => 'pemasukan',
            'kategori' => 'DONASI',
            'nominal' => 150000,
            'keterangan' => 'Test input bendahara',
        ])
        ->assertSessionHas('success');

    $this->assertDatabaseHas('transaksi_keuangans', [
        'jenis' => 'pemasukan',
        'kategori' => 'DONASI',
        'nominal' => 150000,
        'dicatat_oleh' => $bendahara->id,
    ]);
});

it('bendahara tidak dapat approve laporan (Test 10)', function () {
    $bendahara = User::factory()->create(['role' => 'bendahara', 'status' => 'aktif']);
    $laporan = LaporanKeuanganBulanan::factory()->create([
        'status' => 'diajukan'
    ]);

    $this->actingAs($bendahara)
        ->post(route('ketua.laporan-bulanan.approve', $laporan))
        ->assertForbidden();

    $this->assertDatabaseHas('laporan_keuangan_bulanans', [
        'id' => $laporan->id,
        'status' => 'diajukan',
    ]);
});

it('admin tidak dapat approve atau return laporan (Test 10b - eksklusif ketua)', function () {
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);
    $laporan = LaporanKeuanganBulanan::factory()->create([
        'status' => 'diajukan'
    ]);

    // Admin mencoba approve via rute ketua -> forbidden
    $this->actingAs($admin)
        ->post(route('ketua.laporan-bulanan.approve', $laporan))
        ->assertForbidden();

    // Rute approve di admin sudah dicabut -> 404 / 405
    $this->actingAs($admin)
        ->post("admin/laporan-bulanan/{$laporan->id}/approve")
        ->assertNotFound();

    $this->assertDatabaseHas('laporan_keuangan_bulanans', [
        'id' => $laporan->id,
        'status' => 'diajukan',
    ]);
});
