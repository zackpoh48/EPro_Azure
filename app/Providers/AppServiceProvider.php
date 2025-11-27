<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (!$this->app->environment("production")) {
            $this->app->register(
                \Laravel\Telescope\TelescopeServiceProvider::class
            );
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend("recaptcha", "App\\Validators\\ReCaptcha@validate");
        DB::statement("SET time_zone = '+08:00'");
    }
}
