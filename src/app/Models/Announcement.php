<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Announcement extends Model
{
    use HasFactory;
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'title',
        'content',
        'publish_date',
        'expiry_date',
        'status',
    ];

    /**
     * Boot the model and set the ID to a UUID when creating a new instance.
     */
    public static function booted() {
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }
}

