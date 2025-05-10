<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Telegram\Bot\Api;

class RemoveTelegramWebhook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:remove-telegram-webhook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove the Telegram webhook URL';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $bot = new Api(env('TELEGRAM_BOT_TOKEN'));
        $response = $bot->removeWebhook();

        if ($response === true) {
            $this->info('Webhook removed successfully!');
        } elseif (is_object($response)) {
            $this->error('Failed to remove webhook: ' . $response->getDescription());
        } else {
            $this->error('Failed to remove webhook: Invalid response received.');
        }
        $this->info('Webhook response: ' . json_encode($response));
    }
}
