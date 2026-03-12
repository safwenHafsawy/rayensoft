<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FinancialTransaction extends Model
{

    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'type',
        'amount',
        'category',
        'method',
        'date',
        'notes',
    ];

    public static function booted(): void
    {
        static::creating(function ($model) {
            $model->id = (string)Str::uuid();
        });
    }
}
