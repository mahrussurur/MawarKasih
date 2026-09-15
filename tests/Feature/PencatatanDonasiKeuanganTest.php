<?php

use App\Models\Donasi;
use App\Models\User;

function buatDonasi(array $atribut = []): Donasi
{
    return Donasi::create(array_merge([
        'kode_donasi'       => Donasi::generateKode(),
        'nama_donatur'      => 'Donatur Uji',
        'nominal'           => 150000,
        'tanggal'           => today(),
        'status'            => 'pending',
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
        'donasi_id'  => $donasi->id,
        'jenis'      => 'pemasukan',
        'nominal'    => 150000,
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
        'donasi_id'  => $donasi->id,
        'jenis'      => 'pemasukan',
        'nominal'    => 150000,
        'keterangan' => "Pemasukan donasi dari Donatur Tetap: Andi Tetap ({$donasi->kode_donasi})",
        'dicatat_oleh' => $bendahara->id,
    ]);
});
