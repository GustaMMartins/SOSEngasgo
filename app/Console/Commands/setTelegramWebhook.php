<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Telegram\Bot\Api;

class setTelegramWebhook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:set-telegram-webhook';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the Telegram webhook URL';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $url = config('app.url') . '/api/telegram/webhook';
        $bot = new Api(env('TELEGRAM_BOT_TOKEN'));
        $response = $bot->setWebhook([
            'url' => $url
        ]);

        if ($response === true) {
            $this->info('Webhook set successfully!');
        } elseif (is_object($response)) {
            $this->error('Failed to set webhook: ' . $response->getDescription());
        } else {
            $this->error('Failed to set webhook: Invalid response received.');
        }
        $this->info('Webhook URL: ' . $url);
        $this->info('Webhook response: ' . json_encode($response));
    }
}
