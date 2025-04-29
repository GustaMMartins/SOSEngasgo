<?php

namespace App\Services;

use Telegram\Bot\Api;

class TelegramBotService
{
    protected $telegram;

    public function __construct(Api $telegram)
    {
        $this->telegram = $telegram;
    }

    public function sendMessage($chatId, $message)
    {
        return $this->telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => $message,
        ]);
    }

    // Você pode criar outros métodos conforme for expandindo o app
}
