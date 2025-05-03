<?php

namespace App\Http\Controllers;

use App\Models\Atendimento;
use Illuminate\Http\Request;
use Telegram\Bot\Api;

class TelegramController extends Controller
{
    public function webhook(Request $request)
    {
        $bot = new Api(env('TELEGRAM_BOT_TOKEN'));
        $update = $bot->getWebhookUpdate();

        $message = $update->getMessage();
        if (!$message || !$message->getText()) {
            return response('Nenhuma menssagem enviada.', 200);
        }

        $$texto = strtolower($message->getText());
            
        if(str_contains($texto, 'recebido') || str_contains($texto, 'ok')) {
            
            $id = Atendimento::where('status', 'aguardando')->first();
            if (!$id) {
                return response('Nenhum atendimento encontrado.', 200);
            }
            $atendimento = Atendimento::find($id->id);
            if (!$atendimento) {
                return response('Atendimento não encontrado.', 200);
            }
            $atendimento->status = 'confirmado';
            $atendimento->save();

            $bot->sendMessage([
                    'chat_id' => $message->getChat()->getId(),
                    'text' => 'Atendimento confirmado pela equipe do grupo Telegram!',
                ]);
            
        }
        return response('Webhook received', 200);
    }


}
