<?php

use App\Models\User;
use App\Models\TransaksiKeuangan;
use App\Models\LaporanKeuanganBulanan;

it('sekretaris ditolak akses menu keuangan (Test 6)', function () {
    $sekretaris = User::factory()->create(['role' => 'sekretaris']);

    // Sekretaris mencoba mengakses index keuangan admin/bendahara
    $this->actingAs($sekretaris)
        ->get(route('bendahara.keuangan.index'))
        ->assertForbidden(); // atau redirect, tergantung middleware. Kita gunakan assertForbidden karena role:bendahara.
});

it('admin dapat view keuangan tapi ditolak create (Test 7)', function () {
    $admin = User::factory()->create(['role' => 'admin']);

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
        ->assertStatus(405); // Karena route-nya memang tidak didefinisikan untuk POST (hanya `index` pada resource).
});

it('admin tidak dapat delete transaksi (Test 8)', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $transaksi = TransaksiKeuangan::factory()->create();

    $this->actingAs($admin)
        ->delete("admin/keuangan/{$transaksi->id}")
        ->assertNotFound(); // Route tidak ada.
        
    $this->assertDatabaseHas('transaksi_keuangans', ['id' => $transaksi->id]);
});

it('bendahara dapat create transaksi (Test 9)', function () {
    $bendahara = User::factory()->create(['role' => 'bendahara']);

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
    $bendahara = User::factory()->create(['role' => 'bendahara']);
    $laporan = LaporanKeuanganBulanan::factory()->create([
        'status' => 'diajukan'
    ]);

    $this->actingAs($bendahara)
        ->post("admin/laporan-bulanan/{$laporan->id}/approve")
        ->assertForbidden(); // Middleware role:admin akan menolak

    $this->assertDatabaseHas('laporan_keuangan_bulanans', [
        'id' => $laporan->id,
        'status' => 'diajukan', // Tidak berubah
    ]);
});
