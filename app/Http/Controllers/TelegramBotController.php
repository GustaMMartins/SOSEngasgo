<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Models\Atendimento;

class TelegramBotController extends Controller

{

    public function index()
    {
        return view('telegram.atendimento');
    }

    public function iniciarAtendimento()
    {
        $atendimento = Atendimento::create([
            'status' => 'aguardando',
        ]);

        // Enviar mensagem para o grupo do Telegram
        Telegram::sendMessage([
            'chat_id' => env('CHAT_ID_TELEGRAM_GROUP'), // ID do chat,
            'text' => 'Olá Equipe! Atendimento solicitado com ID: ' . $atendimento->id . ' - envir "ok" ou "recebido" para confirmar. Ass.: Laravel.',
        ]);

        session(['atendimento_id' =>$atendimento->id]);
        return redirect()->route('telegram.aguardando');
    }

    public function aguardandoAtendimento()
    {
        $id = session('atendimento_id');
        if (!$id){
            return redirect()->route('telegram.atendimento');
        }
        $atendimento = Atendimento::findOrFail($id);

        // compact envia a variável $atendimento para a view aguardando.blade.php
        return view('telegram.aguardando', compact('atendimento'));
    }

    public function status()
    {
       //
    }

    public function VerificarConfirmacao()
    {
        $id = session('atendimento_id');
        if (!$id){
            return response()->json(['confirmado' => false]);
        }

        $atendimento = Atendimento::find($id);

        return response()->json([
            'confirmado' => $atendimento && $atendimento->status === 'confirmado',
        ]);
    }


}
