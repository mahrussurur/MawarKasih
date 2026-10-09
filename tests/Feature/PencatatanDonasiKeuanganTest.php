<?php

use App\Models\Donasi;
use App\Models\User;

function buatDonasi(array $atribut = []): Donasi
{
    return Donasi::create(array_merge([
        'kode_donasi' => Donasi::generateKode(),
        'nama_donatur' => 'Donatur Uji',
        'nominal' => 150000,
        'tanggal' => today(),
        'status' => 'pending',
        'metode_pembayaran' => 'Transfer Bank',
    ], $atribut));
}

it('mencatat donasi guest yang divalidasi admin sebagai pemasukan satu kali', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $donasi = buatDonasi([
        'nama_donatur' => 'Siti Guest',
        'donatur_id' => null,
    ]);

    $this->actingAs($admin)
        ->patch(route('donasi.validasi', $donasi), ['catatan_admin' => 'Bukti sesuai.'])
        ->assertSessionHas('success');

    $this->assertDatabaseHas('transaksi_keuangans', [
        'donasi_id' => $donasi->id,
        'jenis' => 'pemasukan',
        'nominal' => 150000,
        'keterangan' => "Pemasukan donasi dari Donatur Guest: Siti Guest ({$donasi->kode_donasi})",
    ]);

    $this->actingAs($admin)
        ->patch(route('donasi.validasi', $donasi))
        ->assertSessionHas('error');

    $this->assertDatabaseCount('transaksi_keuangans', 1);
});

it('mencatat donasi donatur tetap yang divalidasi bendahara sebagai pemasukan', function () {
    $bendahara = User::factory()->create(['role' => 'bendahara']);
    $donaturTetap = User::factory()->create(['role' => 'donatur']);
    $donasi = buatDonasi([
        'nama_donatur' => 'Andi Tetap',
        'donatur_id' => $donaturTetap->id,
    ]);

    $this->actingAs($bendahara)
        ->patch(route('bendahara.donasi.validasi', $donasi), ['catatan_admin' => 'Bukti sesuai.'])
        ->assertSessionHas('success');

    $this->assertDatabaseHas('transaksi_keuangans', [
        'donasi_id' => $donasi->id,
        'jenis' => 'pemasukan',
        'nominal' => 150000,
        'keterangan' => "Pemasukan donasi dari Donatur Tetap: Andi Tetap ({$donasi->kode_donasi})",
        'dicatat_oleh' => $bendahara->id,
    ]);
});

it('mencatat donasi manual admin sebagai pemasukan satu kali', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->post(route('donasi.store'), [
            'nama_donatur' => 'Donatur Manual',
            'no_hp' => '081234567890',
            'nominal' => 200000,
            'metode_pembayaran' => 'transfer',
            'keterangan' => 'Pencatatan donasi langsung.',
        ])
        ->assertRedirect(route('donasi.index'));

    $donasi = Donasi::where('nama_donatur', 'Donatur Manual')->firstOrFail();

    $this->assertDatabaseHas('transaksi_keuangans', [
        'donasi_id' => $donasi->id,
        'jenis' => 'pemasukan',
        'nominal' => 200000,
        'dicatat_oleh' => $admin->id,
    ]);
    $this->assertDatabaseCount('transaksi_keuangans', 1);
});

it('donasi pending tidak membuat transaksi (Test 1)', function () {
    $donasi = buatDonasi(['status' => 'pending']);
    
    $this->assertDatabaseMissing('transaksi_keuangans', [
        'donasi_id' => $donasi->id,
    ]);
});

it('donasi ditolak tidak membuat transaksi (Test 5)', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $donasi = buatDonasi(['status' => 'pending']);

    $this->actingAs($admin)
        ->patch(route('donasi.tolak', $donasi), ['catatan_admin' => 'Bukti palsu.'])
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('transaksi_keuangans', [
        'donasi_id' => $donasi->id,
    ]);
});

it('tanggal transaksi sama dengan tanggal donasi saat divalidasi (Test 4)', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $tanggalDonasi = '2026-05-15';
    
    $donasi = buatDonasi([
        'tanggal' => $tanggalDonasi,
        'status' => 'pending',
    ]);

    // Validasi dilakukan hari ini (misal 2026-10-06)
    $this->actingAs($admin)
        ->patch(route('donasi.validasi', $donasi), ['catatan_admin' => 'Ok'])
        ->assertSessionHas('success');

    $this->assertDatabaseHas('transaksi_keuangans', [
        'donasi_id' => $donasi->id,
        'tanggal' => $tanggalDonasi . ' 00:00:00',
    ]);
});
