<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;
    
         /**
     * Boot the model and set the ID to a UUID when creating a new instance.
     */
    public static function booted() {
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }
}

