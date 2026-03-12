<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Events extends Model
{
    use HasFactory;
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'description',
        'start_time',
        'end_time',
        'location',
        'type', // e.g., 'internal', 'launch', 'campaign', 'external'
        'status' // e.g., 'planned', 'ongoing', 'completed', 'cancelled'
    ];

        /**
     * Boot the model.
     *
     * @return void
     */
    protected static function booted() : void
    {
        // When the model is being created, generate a UUID if the primary key is empty.
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }
}
