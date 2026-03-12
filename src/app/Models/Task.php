<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Task extends Model
{
    use HasFactory;

    // Set the primary key type to string (UUID)
    protected $keyType = 'string';

    // Disable auto-incrementing, since UUIDs will be used
    public $incrementing = false;

    protected $fillable = [
        'title',
        'description',
        'status',
        'assigned_to',
        'due_date',
        'priority',
        'completion_note',
        'status'
    ];

    /**
     * Automatically generate a UUID for the model's ID when creating a new instance.
     */
    protected static function booted(): void
    {
        // Use a UUID for the primary key when a new Lead is created
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    public function assignedToUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
