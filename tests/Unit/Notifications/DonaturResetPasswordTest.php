<?php

use App\Models\User;
use App\Notifications\DonaturResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Route;

describe('Unit Test: Notifications/DonaturResetPassword.php (Item 39)', function () {
    beforeEach(function () {
        if (! Route::has('public.donasi.password.reset')) {
            Route::get('/donasi/reset-password/{token}', fn () => '')->name('public.donasi.password.reset');
        }
    });

    it('test_donatur_reset_password_reset_url: menghasilkan URL reset password yang memuat token dan email donatur', function () {
        $user = User::factory()->make([
            'email' => 'donatur@mawarkasih.test',
        ]);

        $token = 'sample-test-token-12345';
        $notification = new DonaturResetPassword($token);

        // Menguji protected method resetUrl menggunakan reflection / closure binding
        $reflection = new ReflectionClass($notification);
        $method = $reflection->getMethod('resetUrl');
        $method->setAccessible(true);

        $url = $method->invoke($notification, $user);

        expect($url)->toBeString();
        expect($url)->toContain('sample-test-token-12345');
        expect($url)->toContain(urlencode('donatur@mawarkasih.test'));
    });

    it('test_donatur_reset_password_to_mail: method toMail memanggil resetUrl dan memuat tombol aksi reset password', function () {
        $user = User::factory()->make([
            'email' => 'donatur@mawarkasih.test',
        ]);

        $token = 'sample-test-token-12345';
        $notification = new DonaturResetPassword($token);

        $mailMessage = $notification->toMail($user);

        expect($mailMessage)->toBeInstanceOf(MailMessage::class);
        expect($mailMessage->actionUrl)->toContain('sample-test-token-12345');
        expect($mailMessage->actionUrl)->toContain(urlencode('donatur@mawarkasih.test'));
    });
});
