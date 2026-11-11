<?php

use App\Models\LaporanKeuanganBulanan;
use App\Models\User;

describe('Unit Test: Models\LaporanKeuanganBulanan', function () {
    it('menguji relasi submitter (BelongsTo ke model User via submitted_by)', function () {
        $bendahara = User::factory()->create(['role' => 'bendahara']);
        $laporan = LaporanKeuanganBulanan::factory()->create([
            'submitted_by' => $bendahara->id,
            'submitted_at' => now(),
        ]);

        expect($laporan->submitter)->toBeInstanceOf(User::class)
            ->and($laporan->submitter->id)->toBe($bendahara->id);
    });

    it('menguji relasi approver (BelongsTo ke model User via approved_by)', function () {
        $ketua = User::factory()->create(['role' => 'ketua']);
        $laporan = LaporanKeuanganBulanan::factory()->create([
            'approved_by' => $ketua->id,
            'approved_at' => now(),
        ]);

        expect($laporan->approver)->toBeInstanceOf(User::class)
            ->and($laporan->approver->id)->toBe($ketua->id);
    });

    it('menguji relasi returner (BelongsTo ke model User via returned_by)', function () {
        $ketua = User::factory()->create(['role' => 'ketua']);
        $laporan = LaporanKeuanganBulanan::factory()->create([
            'returned_by' => $ketua->id,
            'returned_at' => now(),
            'catatan_return' => 'Perbaiki rincian saldo.',
        ]);

        expect($laporan->returner)->toBeInstanceOf(User::class)
            ->and($laporan->returner->id)->toBe($ketua->id);
    });
});
