<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use App\Services\Google\CustomGoogleProvider;


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
    public function boot()
    {
        // Extend Socialite dengan multiple Google drivers
        Socialite::extend('google_pegawai', function ($app) {
            $config = $app['config']['services.google_pegawai'];
            return Socialite::buildProvider(CustomGoogleProvider::class, $config);
        });

        Socialite::extend('google_praja', function ($app) {
            $config = $app['config']['services.google_praja'];
            return Socialite::buildProvider(CustomGoogleProvider::class, $config);
        });
    }
}
