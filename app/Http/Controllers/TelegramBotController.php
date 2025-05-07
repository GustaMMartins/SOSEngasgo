<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Facades\Auth;
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
            'user_id' => Auth::id(), // ID do usuário autenticado
        ]);
        
        // Enviar mensagem para o grupo do Telegram
        $response = Telegram::sendMessage([
            'chat_id' => env('CHAT_ID_TELEGRAM_GROUP'), // ID do chat,
            'text' => 'Olá Equipe! Atendimento solicitado pelo ' .$atendimento->user_id .' com ID: ' . $atendimento->id . ' - responder ao bot com "ok" ou "recebido" para confirmar. Ass.: Laravel.',
        ]);

        //message_id do atendimento para que o "ok" possa ser direcionado ao chamado de emergência corretamente
        $atendimento->telegram_message_id = $response->getMessageId(); 
        $atendimento->save();

        session(['atendimento_id'=>$atendimento->id, 'message_id'=>$atendimento->telegram_message_id]);
        return redirect()->route('telegram.aguardando', compact('atendimento'));
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

    public function VerificarConfirmacao()
    {
        $id = session('atendimento_id');
        $message_id = session('message_id');
        echo "message_id: " .$message_id;
        echo "e atendimento_id: " .$id;
        echo "<br>";
        echo "<hr>";
        if (!$id){
            return response()->json(['confirmado' => false]);
        }

        //$atendimento = Atendimento::find($id);
        $atendimento = Atendimento::where('telegram_message_id', $message_id && 'id', $id)
        ->latest()
        ->first();

        return response()->json([
            //'confirmado' => $atendimento && $atendimento->status === 'confirmado',
            'confirmado' => $atendimento->status === 'confirmado',
        ]);
    }

    public function ConfirmarAtendimento()
    {
        $id = session('atendimento_id');
        if (!$id){
            return redirect()->route('telegram.atendimento');
        }

        $atendimento = Atendimento::findOrFail($id);
        $atendimento->status = 'confirmado';
        $atendimento->save();

        return view('telegram.confirmado', compact('atendimento'));
    }

}
