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

it('submit mengubah status draft ke diajukan (Test 13)', function () {
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
        'status' => 'diajukan',
        'submitted_by' => $bendahara->id,
    ]);
});

it('setelah diajukan, create/update/delete transaksi periode ditolak (Test 14)', function () {
    $bendahara = User::factory()->create(['role' => 'bendahara']);
    LaporanKeuanganBulanan::factory()->create([
        'tahun' => 2026,
        'bulan' => 10,
        'status' => 'diajukan',
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

it('admin approve mengubah status diajukan ke disetujui (Test 15)', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $laporan = LaporanKeuanganBulanan::factory()->create([
        'tahun' => 2026,
        'bulan' => 10,
        'status' => 'diajukan',
    ]);

    $this->actingAs($admin)
        ->post(route('admin.laporan-bulanan.approve', $laporan))
        ->assertRedirect();

    $this->assertDatabaseHas('laporan_keuangan_bulanans', [
        'id' => $laporan->id,
        'status' => 'disetujui',
        'approved_by' => $admin->id,
    ]);
});

it('admin return mengubah status diajukan ke dikembalikan (Test 17)', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $laporan = LaporanKeuanganBulanan::factory()->create([
        'tahun' => 2026,
        'bulan' => 10,
        'status' => 'diajukan',
    ]);

    $this->actingAs($admin)
        ->post(route('admin.laporan-bulanan.return', $laporan), [
            'catatan_return' => 'Tolong perbaiki mutasi bank',
        ])
        ->assertRedirect();

    $this->assertDatabaseHas('laporan_keuangan_bulanans', [
        'id' => $laporan->id,
        'status' => 'dikembalikan',
        'catatan_return' => 'Tolong perbaiki mutasi bank',
        'returned_by' => $admin->id,
    ]);
});

it('dikembalikan bendahara dapat memperbaiki transaksi (Test 18)', function () {
    $bendahara = User::factory()->create(['role' => 'bendahara']);
    LaporanKeuanganBulanan::factory()->create([
        'tahun' => 2026,
        'bulan' => 10,
        'status' => 'dikembalikan',
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

it('submit ulang dikembalikan menjadi diajukan (Test 19)', function () {
    $bendahara = User::factory()->create(['role' => 'bendahara']);
    $laporan = LaporanKeuanganBulanan::factory()->create([
        'tahun' => 2026,
        'bulan' => 10,
        'status' => 'dikembalikan',
    ]);

    $this->actingAs($bendahara)
        ->post(route('bendahara.laporan-bulanan.submit', $laporan))
        ->assertRedirect();

    $this->assertDatabaseHas('laporan_keuangan_bulanans', [
        'id' => $laporan->id,
        'status' => 'diajukan',
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

it('status database langsung bernilai draft, diajukan, dikembalikan, dan disetujui', function () {
    $lapDraft = new LaporanKeuanganBulanan(['status' => 'draft']);
    expect($lapDraft->status)->toBe('draft');

    $lapDiajukan = new LaporanKeuanganBulanan(['status' => 'diajukan']);
    expect($lapDiajukan->status)->toBe('diajukan');

    $lapDikembalikan = new LaporanKeuanganBulanan(['status' => 'dikembalikan']);
    expect($lapDikembalikan->status)->toBe('dikembalikan');

    $lapDisetujui = new LaporanKeuanganBulanan(['status' => 'disetujui']);
    expect($lapDisetujui->status)->toBe('disetujui');
});

