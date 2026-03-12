<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientProfits extends Model
{
    use HasFactory;

            // Specify that the primary key is a string (UUID)
    protected $keyType = 'string';

    // Indicate that the primary key is not auto-incrementing
    public $incrementing = false;

    // Specify the fields that are mass-assignable
    protected $fillable = [
        'project_id',
        'month',
        'reported_profit',
        'calculated_cut',
        'is_paid',
    ];

    /**
     * Boot the model and set the ID to a UUID when creating a new instance.
     */
    public static function booted(): void
    {
        // Generate a UUID when a new Client instance is created
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }
}
