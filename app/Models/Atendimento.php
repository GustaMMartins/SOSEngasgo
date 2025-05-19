<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Testing\Fluent\Concerns\Has;

class Atendimento extends Model
{

    //use HasFactory;

   //public $incrementing = false;
    use HasUlids;

    protected $fillable = [
        'user_id',
        'status',
        'dataConfirmado',
        'localizacao',
        'telegram_message_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
