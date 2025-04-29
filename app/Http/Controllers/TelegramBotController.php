<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramBotController extends Controller
{
    public function sendMessage()
    {
        $chatId = env('CHAT_ID_TELEGRAM', 'erro'); // Get chat ID from .env file
        $message = "Olá mundo! Mensagem via Laravel!"; 
        // ID Bot = 7807867662

        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => $message,
        ]);

        return 'Message sent to Telegram!';
    }
    public function getUpdates()
    {
        $updates = Telegram::getUpdates();
        return $updates; 
    }
}
