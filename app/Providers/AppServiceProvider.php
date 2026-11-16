<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        if (app()->environment('production')) {
            URL::forceRootUrl(config('app.url'));
            URL::forceScheme('https');
        }

        // Membuat URL reset password secara eksplisit
        ResetPassword::createUrlUsing(function ($user, string $token) {
            $baseUrl = rtrim(config('app.url'), '/');

            $email = urlencode($user->getEmailForPasswordReset());

            return $baseUrl . '/reset-password/' . $token . '?email=' . $email;
        });
        
        // Daftarkan folder admin/components sebagai namespace komponen default
        Blade::anonymousComponentNamespace('admin.components', '');
    }
}
