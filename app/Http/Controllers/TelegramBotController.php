<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Facades\Log;
use App\Models\Atendimento;
use Illuminate\Support\Facades\Auth;

class TelegramBotController extends Controller
{
    public function webhook(Request $request)
    {
        Log::info('Webhook do Telegram recebido!');
        Log::info(json_encode($request->all()));

        

        return response()->json(['status' => 'success']);
    }

    public function dashboard()
    {
        
        return view('dashboard');
    }

    public function index()
    {
        
        return view('Telegram.atendimento');
    }

    public function IniciarAtendimento(Request $request)
    {
        
        return redirect('/'); 
    }

    public function aguardandoAtendimento($id)
    {
        
        return view('aguardando', ['id' => $id]);
    }

    public function verificarConfirmacao($id)
    {
        
        return response()->json(['confirmado' => false]);
    }

    public function confirmarAtendimento($id)
    {
      
        return view('confirmacao', ['id' => $id]);
    }
}
