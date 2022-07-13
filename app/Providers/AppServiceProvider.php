<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $header= \URL::getRequest()->header('HOST');
        if ($header)
            if ($header=='vcards.cybercorra.org')
        \URL::forceScheme('https'); // Force HTTPS
    }
}
