<?php

namespace App\Telegram\Commands;

use Telegram\Bot\Commands\Command;

class StartCommand extends Command
{
    protected string $name = 'start';
    protected string $pattern = '{username?}';
    protected string $description = 'Comando de início do bot';

    public function handle()
    {
        # username from Update object to be used as fallback.
        $fallbackUsername = $this->getUpdate()->getMessage()->from->username;

        # Get the username argument if the user provides,
        # (optional) fallback to username from Update object as the default.
        $username = $this->argument(
            'username',
            $fallbackUsername
        );

        $this->replyWithMessage([
            'text' => "Olá {$username}! Bem-vindo :)"
        ]);
    }
}