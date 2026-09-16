<?php

use App\Models\Donasi;
use App\Models\User;

it('allows treasurers to create, update, and delete manual donations', function () {
    $bendahara = User::factory()->create(['role' => 'bendahara', 'status' => 'aktif']);

    $this->actingAs($bendahara)
        ->post(route('bendahara.donasi.store'), [
            'nama_donatur' => 'Donatur Bendahara',
            'no_hp' => '081234567890',
            'nominal' => 200000,
            'metode_pembayaran' => 'tunai',
            'keterangan' => 'Donasi dicatat oleh bendahara.',
        ])
        ->assertRedirect(route('bendahara.donasi.index'));

    $donasi = Donasi::where('nama_donatur', 'Donatur Bendahara')->firstOrFail();

    $this->assertDatabaseHas('donasi', [
        'id' => $donasi->id,
        'status' => 'diterima',
        'nominal' => 200000,
    ]);
    $this->assertDatabaseHas('transaksi_keuangans', [
        'donasi_id' => $donasi->id,
        'jenis' => 'pemasukan',
        'nominal' => 200000,
        'dicatat_oleh' => $bendahara->id,
    ]);

    $this->actingAs($bendahara)
        ->get(route('bendahara.donasi.show', $donasi))
        ->assertOk();

    $this->actingAs($bendahara)
        ->get(route('bendahara.donasi.edit', $donasi))
        ->assertOk();

    $indexResponse = $this->actingAs($bendahara)
        ->get(route('bendahara.donasi.index'));

    $indexResponse
        ->assertOk()
        ->assertSee(route('bendahara.donasi.edit', $donasi), false)
        ->assertSee(route('bendahara.donasi.destroy', $donasi), false);

    $this->actingAs($bendahara)
        ->patch(route('bendahara.donasi.update', $donasi), [
            'nama_donatur' => 'Donatur Bendahara Diperbarui',
            'no_hp' => '081234567890',
            'nominal' => 225000,
            'metode_pembayaran' => 'qris',
            'tanggal' => '2026-09-16',
            'keterangan' => 'Data donasi diperbarui.',
        ])
        ->assertRedirect(route('bendahara.donasi.index'));

    $this->assertDatabaseHas('donasi', [
        'id' => $donasi->id,
        'nama_donatur' => 'Donatur Bendahara Diperbarui',
        'nominal' => 225000,
    ]);

    $this->actingAs($bendahara)
        ->delete(route('bendahara.donasi.destroy', $donasi))
        ->assertRedirect(route('bendahara.donasi.index'));

    $this->assertDatabaseMissing('donasi', ['id' => $donasi->id]);
});
