<?php

namespace App\Http\Controllers;

use App\Models\Atendimento;
use Illuminate\Http\Request;
use Telegram\Bot\Api;
use Illuminate\Support\Facades\Log;

class TelegramController extends Controller
{
    public function webhook(Request $request)
    {

        $bot = new Api(env('TELEGRAM_BOT_TOKEN'));

        //Registra os comandos personalizados
        $bot->addCommand([
            \App\Telegram\Commands\StartCommand::class,
        ]);
        // processar o comando
        $bot->commandsHandler(true);

        $update = $bot->getWebhookUpdate();        

        $message = $update->getMessage();
        if(!$message || !$message->getText()) {
            return response('Nenhuma mensagem enviada.', 200);
        }

        $texto = $message->getText();

        if(str_starts_with($texto, '/')) {
            return response('Comando recebido.', 200);
        }

        $replyToId = $message->getReplyToMessage()?->getMessageId();
        $bot->sendMessage([
        'chat_id' => $message->getChat()->getId(),
        'text' => "Recebido! Texto: {$texto}\nReplyTo ID: {$replyToId}",
        ]);

        // Ou retornar como resposta JSON
        //return response()->json($update->toArray());

        /* Verifica se a mensagem é uma resposta a outra mensagem
           e se o texto contém "recebido" ou "ok"
           Se sim, atualiza o status do atendimento
           e envia uma mensagem de confirmação no grupo. */
        if ($message->getReplyToMessage()) {
            $repliedMessageId = $message->getReplyToMessage()->getMessageId();
            $texto = strtolower($texto);
            
            if(str_contains($texto, 'recebido') || str_contains($texto, 'ok')) {
            
                $atendimento = Atendimento::where('telegram_message_id', $repliedMessageId)->first();

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