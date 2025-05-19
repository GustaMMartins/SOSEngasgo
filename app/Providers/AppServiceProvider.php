<?php

namespace App\Providers;

use App\Telegram\Commands;
use Illuminate\Routing\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Telegram\Bot\Laravel\Facades\Telegram;

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

        // Force HTTPS in production
        if(env('APP_ENV') === 'production'){
            URL::forceScheme('https');
        }

    }

}
