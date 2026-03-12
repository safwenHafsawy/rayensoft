<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
/**
 * Class RecentActivities
 *
 * This model represents the recent activities of users in the application.
 * It uses a UUID as the primary key and stores user names and activity details.
 */

class RecentActivities extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_name',
        'details',
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

