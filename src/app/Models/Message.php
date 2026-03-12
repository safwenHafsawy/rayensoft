<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Message extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    public static function booted() {
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }
    use HasFactory;
    protected $fillable = [
        'fullname',
        'email',
        'subject',
        'message',
    ];
}

