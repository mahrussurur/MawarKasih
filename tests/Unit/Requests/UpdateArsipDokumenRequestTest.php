<?php

use App\Http\Requests\Admin\UpdateArsipDokumenRequest;
use App\Models\User;

describe('Unit Test: Http/Requests/Admin/UpdateArsipDokumenRequest.php (Items 36, 37, 38)', function () {
    // Item 36: authorize() with CFG & Independent Paths (V(G) = 2)
    describe('test_update_arsip_dokumen_request_authorize: CFG + V(G) = 2 Independent Paths', function () {
        it('Path 1 (True): mengembalikan true jika user login dan memiliki role admin', function () {
            $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);

            $request = new UpdateArsipDokumenRequest();
            $request->setUserResolver(fn () => $admin);

            expect($request->authorize())->toBeTrue();
        });

        it('Path 2 (False): mengembalikan false jika user bukan admin atau belum login', function () {
            $donatur = User::factory()->create(['role' => 'donatur', 'status' => 'aktif']);

            $requestNonAdmin = new UpdateArsipDokumenRequest();
            $requestNonAdmin->setUserResolver(fn () => $donatur);
            expect($requestNonAdmin->authorize())->toBeFalse();

            $requestGuest = new UpdateArsipDokumenRequest();
            $requestGuest->setUserResolver(fn () => null);
            expect($requestGuest->authorize())->toBeFalse();
        });
    });

    // Item 37: rules()
    it('test_update_arsip_dokumen_request_rules: mengembalikan struktur aturan validasi update (file bersifat nullable)', function () {
        $request = new UpdateArsipDokumenRequest();
        $rules = $request->rules();

        expect($rules)->toBeArray();
        expect($rules)->toHaveKeys(['judul', 'nomor_dokumen', 'kategori', 'tanggal_dokumen', 'deskripsi', 'file']);
        expect($rules['judul'])->toContain('required');
        expect($rules['file'])->toContain('nullable'); // Berbeda dengan store, saat update file boleh kosong
    });

    // Item 38: messages()
    it('test_update_arsip_dokumen_request_messages: mengembalikan pesan kustom validasi dalam bahasa Indonesia', function () {
        $request = new UpdateArsipDokumenRequest();
        $messages = $request->messages();

        expect($messages)->toBeArray();
        expect($messages)->toHaveKey('judul.required');
        expect($messages)->toHaveKey('file.mimes');
        expect($messages['judul.required'])->toBe('Judul dokumen wajib diisi.');
        expect($messages['file.max'])->toBe('Ukuran berkas maksimal adalah 10 MB.');
    });
});
