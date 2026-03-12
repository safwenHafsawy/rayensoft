<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TelegramBotSession extends Model
{
    protected $fillable = [
        'chat_id',
        'step',
        'data'
    ];

    protected $casts = [
        'data' => 'array',
    ];
}
