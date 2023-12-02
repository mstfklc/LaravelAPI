<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

class AppServiceProvider extends ServiceProvider
{

    public function register()
    {
        Config::set('rate_limiting.throttle', [
            'enabled' => true,
            'decay_minutes' => 1,
            'max_attempts' => 30,
        ]);
    }
    public function boot(): void
    {
        //
    }
}
