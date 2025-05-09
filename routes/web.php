<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TelegramBotController;
use App\Http\Controllers\TelegramController;
use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Facades\File;

// Apagar depois
use Illuminate\Support\Facades\Artisan;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Telegram Bot
    Route::get('/get-updates', function () {
        $updates = Telegram::getUpdates();
        return response()->json($updates);
    })->name('telegram.get.updates');

    Route::get('/send-message', function () {
        $response = Telegram::sendMessage([
            'chat_id' => env('CHAT_ID_TELEGRAM_GROUP'), // ID do chat
            'text' => 'Olá do Laravel!'
        ]);
        return response()->json($response);
    })->name('telegram.send.message');

    Route::get('get-me', function () {
        $me = Telegram::getMe();
        return response()->json($me);
    })->name('telegram.get.me');

    // Atendimento
    Route::get('/atendimento', [TelegramBotController::class, 'index'])->name('telegram.atendimento');
    Route::post('/atendimento', [TelegramBotController::class, 'iniciarAtendimento'])->name('telegram.atendimento.iniciar'); // clique no botão "iniciar atendimento"

    // Tela aguardando
    Route::get('/aguardando', [TelegramBotController::class, 'aguardandoAtendimento'])->name('telegram.aguardando');
    // Verifica se o atendimento foi confirmado pelo webhook e atualiza o status
    Route::get('/verificar/{id}', [TelegramBotController::class, 'verificarConfirmacao'])->name('telegram.verificar');
    
    // Confirmar atendimento
    Route::get('/confirmacao', [TelegramBotController::class, 'confirmarAtendimento'])->name('telegram.confirmado');

    // Webhook (Telegram chama automaticamente)
    Route::post('/telegram/webhook', [TelegramController::class, 'webhook']); //sem view

    // Temporário
    Route::get('/limpar-cache', function () {
        Artisan::call('optimize:clear');
        return 'Cache limpo!';
    });

    $logPath = storage_path('logs/telegram.log');

    if (!File::exists($logPath)) {
        return response('Arquivo de log não encontrado.', 404);
    }

    return response('<pre>' . e(File::get($logPath)) . '</pre>');

});

require __DIR__.'/auth.php';
