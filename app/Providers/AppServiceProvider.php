<?php

namespace App\Providers;

use App\Models\Donatur;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        View::composer(['public.*', 'public.components.*'], function ($view) {
            $donatur = null;
            if (session()->has('donatur_id')) {
                $donatur = Donatur::find(session('donatur_id'));
                if (!$donatur) {
                    session()->forget('donatur_id');
                    $donatur = null;
                }
            }
            $view->with('currentDonatur', $donatur);
        });
    }
}
