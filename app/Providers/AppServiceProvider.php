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

        //Telegram::addCommands([
        //    Commands\StartCommand::class,
            // usar para listar chamados
            //Commands\HelpCommand::class,
            //Commands\AtendimentoCommand::class,
            //Commands\AguardandoCommand::class,
            //Commands\ConfirmarAtendimentoCommand::class,
        //]); //Opcional, caso não esteja em telegram.php

    }

}
