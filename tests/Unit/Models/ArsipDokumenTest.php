<?php

use App\Models\ArsipDokumen;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

describe('Unit Test: Models/ArsipDokumen.php (Items 31 & 32)', function () {
    // Item 31: uploader() relation
    it('test_arsip_dokumen_uploader_relation: relasi uploader mengembalikan instance BelongsTo dan mengaitkan user pengunggah', function () {
        $user = User::factory()->create([
            'role' => 'admin',
            'status' => 'aktif',
        ]);

        $arsip = ArsipDokumen::create([
            'judul' => 'Dokumen MoU',
            'nomor_dokumen' => 'MOU-01',
            'kategori' => 'Legalitas',
            'file_name_asli' => 'mou.pdf',
            'file_path' => 'arsip-dokumen/mou.pdf',
            'file_size' => 1024,
            'mime_type' => 'application/pdf',
            'uploaded_by' => $user->id,
        ]);

        expect($arsip->uploader())->toBeInstanceOf(BelongsTo::class);
        expect($arsip->uploader->id)->toBe($user->id);
    });

    // Item 32: getFormattedFileSizeAttribute() with CFG & Independent Paths (V(G) = 3)
    describe('test_get_formatted_file_size_attribute: CFG + V(G) = 3 Independent Paths', function () {
        it('Path 1: mengembalikan format MB jika ukuran berkas >= 1048576 bytes', function () {
            $arsip = new ArsipDokumen(['file_size' => 2097152]); // 2 MB
            expect($arsip->formatted_file_size)->toBe('2.00 MB');

            $arsipExact = new ArsipDokumen(['file_size' => 1048576]); // Tepat 1 MB
            expect($arsipExact->formatted_file_size)->toBe('1.00 MB');
        });

        it('Path 2: mengembalikan format KB jika ukuran berkas >= 1024 dan < 1048576 bytes', function () {
            $arsip = new ArsipDokumen(['file_size' => 5120]); // 5 KB
            expect($arsip->formatted_file_size)->toBe('5.00 KB');

            $arsipExact = new ArsipDokumen(['file_size' => 1024]); // Tepat 1 KB
            expect($arsipExact->formatted_file_size)->toBe('1.00 KB');
        });

        it('Path 3: mengembalikan format bytes jika ukuran berkas < 1024 bytes', function () {
            $arsip = new ArsipDokumen(['file_size' => 500]);
            expect($arsip->formatted_file_size)->toBe('500 bytes');

            $arsipZero = new ArsipDokumen(['file_size' => 0]);
            expect($arsipZero->formatted_file_size)->toBe('0 bytes');
        });
    });
});
