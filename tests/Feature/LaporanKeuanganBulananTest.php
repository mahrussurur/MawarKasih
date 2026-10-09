<?php

use App\Models\User;
use App\Models\TransaksiKeuangan;
use App\Models\LaporanKeuanganBulanan;
use Illuminate\Support\Carbon;

it('draft dapat dibuat (Test 11)', function () {
    $bendahara = User::factory()->create(['role' => 'bendahara']);
    
    $this->actingAs($bendahara)
        ->get(route('bendahara.laporan-bulanan.index', ['tahun' => 2026, 'bulan' => 10]))
        ->assertStatus(200)
        ->assertSee('Draft');

    $this->assertDatabaseHas('laporan_keuangan_bulanans', [
        'tahun' => 2026,
        'bulan' => 10,
        'status' => 'draft',
    ]);
});

it('preview tidak mengunci transaksi (Test 12)', function () {
    $bendahara = User::factory()->create(['role' => 'bendahara']);
    $laporan = LaporanKeuanganBulanan::factory()->create([
        'tahun' => 2026,
        'bulan' => 10,
        'status' => 'draft',
    ]);

    $this->actingAs($bendahara)
        ->post(route('bendahara.keuangan.store'), [
            'tanggal' => '2026-10-15',
            'jenis' => 'pemasukan',
            'kategori' => 'DONASI',
            'nominal' => 100000,
            'keterangan' => 'Test input',
        ])
        ->assertSessionHas('success');

    $this->assertDatabaseCount('transaksi_keuangans', 1);
});

it('submit mengubah status draft ke submitted (Test 13)', function () {
    $bendahara = User::factory()->create(['role' => 'bendahara']);
    $laporan = LaporanKeuanganBulanan::factory()->create([
        'tahun' => 2026,
        'bulan' => 10,
        'status' => 'draft',
    ]);

    $this->actingAs($bendahara)
        ->post(route('bendahara.laporan-bulanan.submit', $laporan))
        ->assertRedirect();

    $this->assertDatabaseHas('laporan_keuangan_bulanans', [
        'id' => $laporan->id,
        'status' => 'submitted',
        'submitted_by' => $bendahara->id,
    ]);
});

it('setelah submitted, create/update/delete transaksi periode ditolak (Test 14)', function () {
    $bendahara = User::factory()->create(['role' => 'bendahara']);
    LaporanKeuanganBulanan::factory()->create([
        'tahun' => 2026,
        'bulan' => 10,
        'status' => 'submitted',
    ]);

    $this->actingAs($bendahara)
        ->post(route('bendahara.keuangan.store'), [
            'tanggal' => '2026-10-15',
            'jenis' => 'pemasukan',
            'kategori' => 'DONASI',
            'nominal' => 100000,
            'keterangan' => 'Test input',
        ])
        ->assertSessionHas('error');

    $this->assertDatabaseCount('transaksi_keuangans', 0);
});

it('admin approve mengubah status submitted ke approved (Test 15)', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $laporan = LaporanKeuanganBulanan::factory()->create([
        'tahun' => 2026,
        'bulan' => 10,
        'status' => 'submitted',
    ]);

    $this->actingAs($admin)
        ->post(route('admin.laporan-bulanan.approve', $laporan))
        ->assertRedirect();

    $this->assertDatabaseHas('laporan_keuangan_bulanans', [
        'id' => $laporan->id,
        'status' => 'approved',
        'approved_by' => $admin->id,
    ]);
});

it('admin return mengubah status submitted ke returned (Test 17)', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $laporan = LaporanKeuanganBulanan::factory()->create([
        'tahun' => 2026,
        'bulan' => 10,
        'status' => 'submitted',
    ]);

    $this->actingAs($admin)
        ->post(route('admin.laporan-bulanan.return', $laporan), [
            'catatan_return' => 'Tolong perbaiki mutasi bank',
        ])
        ->assertRedirect();

    $this->assertDatabaseHas('laporan_keuangan_bulanans', [
        'id' => $laporan->id,
        'status' => 'returned',
        'catatan_return' => 'Tolong perbaiki mutasi bank',
        'returned_by' => $admin->id,
    ]);
});

it('returned bendahara dapat memperbaiki transaksi (Test 18)', function () {
    $bendahara = User::factory()->create(['role' => 'bendahara']);
    LaporanKeuanganBulanan::factory()->create([
        'tahun' => 2026,
        'bulan' => 10,
        'status' => 'returned',
    ]);

    $this->actingAs($bendahara)
        ->post(route('bendahara.keuangan.store'), [
            'tanggal' => '2026-10-15',
            'jenis' => 'pemasukan',
            'kategori' => 'DONASI',
            'nominal' => 100000,
            'keterangan' => 'Test input repair',
        ])
        ->assertSessionHas('success');

    $this->assertDatabaseCount('transaksi_keuangans', 1);
});

it('submit ulang returned menjadi submitted (Test 19)', function () {
    $bendahara = User::factory()->create(['role' => 'bendahara']);
    $laporan = LaporanKeuanganBulanan::factory()->create([
        'tahun' => 2026,
        'bulan' => 10,
        'status' => 'returned',
    ]);

    $this->actingAs($bendahara)
        ->post(route('bendahara.laporan-bulanan.submit', $laporan))
        ->assertRedirect();

    $this->assertDatabaseHas('laporan_keuangan_bulanans', [
        'id' => $laporan->id,
        'status' => 'submitted',
    ]);
});

it('saldo akhir = saldo awal + pemasukan - pengeluaran (Test 20)', function () {
    $bendahara = User::factory()->create(['role' => 'bendahara']);
    // We must seed transactions because calculate() aggregates from TransaksiKeuangan, not previous Laporan.
    TransaksiKeuangan::factory()->create([
        'tanggal' => '2026-09-15',
        'jenis' => 'pemasukan',
        'nominal' => 500000,
    ]);

    TransaksiKeuangan::factory()->create([
        'tanggal' => '2026-10-05',
        'jenis' => 'pemasukan',
        'nominal' => 200000,
    ]);
    
    TransaksiKeuangan::factory()->create([
        'tanggal' => '2026-10-10',
        'jenis' => 'pengeluaran',
        'nominal' => 150000,
    ]);

    $this->actingAs($bendahara)
        ->get(route('bendahara.laporan-bulanan.index', ['tahun' => 2026, 'bulan' => 10]));
        
    $this->assertDatabaseHas('laporan_keuangan_bulanans', [
        'tahun' => 2026,
        'bulan' => 10,
        'saldo_awal' => 500000,
        'total_pemasukan' => 200000,
        'total_pengeluaran' => 150000,
        'saldo_akhir' => 550000, // 500k + 200k - 150k
    ]);
});
