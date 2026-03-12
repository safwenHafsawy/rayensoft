<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class WorkSessionBreaks extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'work_session_id',
        'started_at',
        'ended_at',
    ];

    public static function booted(): void
    {
        // Generate a UUID when a new Client instance is created
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    public function workSession(): BelongsTo
    {
        return $this->belongsTo(WorkSession::class);
    }

}
