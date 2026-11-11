<?php

use App\Http\Requests\Admin\StoreArsipDokumenRequest;
use App\Models\User;

describe('Unit Test: Http/Requests/Admin/StoreArsipDokumenRequest.php (Items 33, 34, 35)', function () {
    // Item 33: authorize() with CFG & Independent Paths (V(G) = 2)
    describe('test_store_arsip_dokumen_request_authorize: CFG + V(G) = 2 Independent Paths', function () {
        it('Path 1 (True): mengembalikan true jika user login dan memiliki role admin', function () {
            $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);

            $request = new StoreArsipDokumenRequest();
            $request->setUserResolver(fn () => $admin);

            expect($request->authorize())->toBeTrue();
        });

        it('Path 2 (False): mengembalikan false jika user bukan admin atau belum login', function () {
            $donatur = User::factory()->create(['role' => 'donatur', 'status' => 'aktif']);

            $requestNonAdmin = new StoreArsipDokumenRequest();
            $requestNonAdmin->setUserResolver(fn () => $donatur);
            expect($requestNonAdmin->authorize())->toBeFalse();

            $requestGuest = new StoreArsipDokumenRequest();
            $requestGuest->setUserResolver(fn () => null);
            expect($requestGuest->authorize())->toBeFalse();
        });
    });

    // Item 34: rules()
    it('test_store_arsip_dokumen_request_rules: mengembalikan struktur aturan validasi yang sesuai', function () {
        $request = new StoreArsipDokumenRequest();
        $rules = $request->rules();

        expect($rules)->toBeArray();
        expect($rules)->toHaveKeys(['judul', 'nomor_dokumen', 'kategori', 'tanggal_dokumen', 'deskripsi', 'file']);
        expect($rules['judul'])->toContain('required');
        expect($rules['kategori'])->toContain('required');
        expect($rules['file'])->toContain('required');
    });

    // Item 35: messages()
    it('test_store_arsip_dokumen_request_messages: mengembalikan pesan kustom validasi dalam bahasa Indonesia', function () {
        $request = new StoreArsipDokumenRequest();
        $messages = $request->messages();

        expect($messages)->toBeArray();
        expect($messages)->toHaveKey('judul.required');
        expect($messages)->toHaveKey('file.required');
        expect($messages['judul.required'])->toBe('Judul dokumen wajib diisi.');
        expect($messages['file.required'])->toBe('Berkas dokumen wajib diunggah.');
    });
});
