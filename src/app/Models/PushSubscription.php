<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;

class PushSubscription extends Model
{

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id', 'endpoint', 'keys'
    ];


}
