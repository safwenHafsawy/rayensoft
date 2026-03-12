<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;
    protected $keyType = 'string';
    public $incrementing = false;

         /**
     * Boot the model and set the ID to a UUID when creating a new instance.
     */
    public static function booted() {
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }
}

