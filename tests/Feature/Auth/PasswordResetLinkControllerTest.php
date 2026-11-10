<?php

use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;

describe('Auth PasswordResetLinkController: Create & Store (Items 29 & 30)', function () {
    it('test_password_reset_create: dapat menampilkan halaman form lupa password', function () {
        $response = $this->get(route('password.request'));

        $response->assertOk();
        $response->assertViewIs('auth.forgot-password');
    });

    it('test_password_reset_store: berhasil mengirim link reset password jika email terdaftar', function () {
        Notification::fake();

        $user = User::factory()->create([
            'email' => 'donatur@mawarkasih.test',
            'status' => 'aktif',
        ]);

        $response = $this->post(route('password.email'), [
            'email' => 'donatur@mawarkasih.test',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('status', __(Password::RESET_LINK_SENT));
    });

    it('test_password_reset_store_invalid_email: gagal dan mengembalikan error jika email tidak terdaftar', function () {
        $response = $this->post(route('password.email'), [
            'email' => 'tidak_ada@mawarkasih.test',
        ]);

        $response->assertSessionHasErrors(['email']);
    });

    it('test_password_reset_store_validation: validasi gagal jika field email kosong atau bukan format email', function () {
        $response = $this->post(route('password.email'), [
            'email' => 'bukan-email',
        ]);

        $response->assertSessionHasErrors(['email']);
    });
});
