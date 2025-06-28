<?php

use App\Http\Controllers\AtendimentoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TelegramBotController; 
use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Facades\Artisan; 


Route::get('/', function () {
    return view('home');
});

Route::get('/aprender', function () {
    return view('aprender');
});

Route::get('/simular', function () {
    return view('simular');
});


Route::get('/emergencia', function () {
    return view('telegram_emergencia');
});


Route::post('/api/telegram/webhook', [TelegramBotController::class, 'webhook']);


Route::middleware(['auth'])->group(function () {

    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    
    Route::get('/dashboard', [TelegramBotController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

    
    Route::delete('/dashboard/{atendimento}', [AtendimentoController::class, 'destroy'])->name('destroy');


    
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

    
    Route::get('/atendimento', [TelegramBotController::class, 'index'])->name('telegram.atendimento');
    Route::post('/atendimento', [TelegramBotController::class, 'iniciarAtendimento'])->name('telegram.atendimento.iniciar');

    Route::get('/aguardando/{id}', [TelegramBotController::class, 'aguardandoAtendimento'])->name('telegram.aguardando');
    Route::get('/verificar/{id}', [TelegramBotController::class, 'verificarConfirmacao'])->name('telegram.verificar');

    
    Route::get('/confirmacao/{id}', [TelegramBotController::class, 'confirmarAtendimento'])->name('telegram.confirmado');

    
    Route::get('/limpar-cache', function () {
        Artisan::call('optimize:clear');
        return 'Cache limpo!';
    });

});

require __DIR__.'/auth.php';