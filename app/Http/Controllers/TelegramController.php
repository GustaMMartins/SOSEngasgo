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

        if ($message->getReplyToMessage()) {
            $repliedMessageId = $message->getReplyToMessage()->getMessageId();
            $texto = strtolower($message->getText());
            
            if(str_contains($texto, 'recebido') || str_contains($texto, 'ok')) {
            
                $$atendimento = Atendimento::where('telegram_message_id', $repliedMessageId)->first();

                if (!$atendimento) {
                    return response('Atendimento não encontrado para esta resposta.', 200);
                }

                if ($atendimento->status === 'confirmado') {
                    return response('Atendimento já confirmado.', 200);
                }

                $atendimento->update([
                    'status' => 'confirmado',
                    'dataConfirmado' => now(),
                ]);

                // Mensagem de feedback no grupo
                $bot->sendMessage([
                    'chat_id' => $message->getChat()->getId(),
                    'text' => "Atendimento ID {$atendimento->id} confirmado com sucesso!",
                ]);
            }
        }

        return response('Webhook recebido.', 200);
    }
}











}
