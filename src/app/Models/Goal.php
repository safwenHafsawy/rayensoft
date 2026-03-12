<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Goal extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'status',
        'user_id',
        'area'
    ];

    // Set the primary key type to string (UUID)
    protected $keyType = 'string';

    // Disable auto-incrementing, since UUIDs will be used
    public $incrementing = false;

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

    public function user () {
        return $this->belongsTo(User::class);
    }

    public function workSessions() {
        return $this->belongsToMany(WorkSession::class, 'goal_work_session', 'goal_id', 'work_session_id');
    }
}
