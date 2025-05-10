<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Telegram\Bot\Api;

class GetTelegramWebhookInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-telegram-webhook-info';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the current Telegram webhook information';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $bot = new Api(env('TELEGRAM_BOT_TOKEN'));

        $info = $bot->getWebhookInfo();

        $this->info('Webhook Info:');
        $this->info('URL: ' . $info->getUrl());
        $this->line(json_encode($info, JSON_PRETTY_PRINT));
    }
}
