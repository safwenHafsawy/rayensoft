<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class WorkSession extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'user_id',
        'check_in_time',
        'check_out_time',
        'status',
        'last_check_at',
        'notification_confirmed',
        'number_of_checks',
        'summary',
        'total_worked_time',
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


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function breaks()
    {
        return $this->hasMany(WorkSessionBreak::class);
    }

    public function goals()
    {
        return $this->belongsToMany(Goal::class, 'goal_work_session', 'work_session_id', 'goal_id');
    }
}
