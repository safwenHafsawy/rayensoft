<?php

namespace App\Models;
use App\Models\MeetingParticipant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Meeting extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'title',
        'type',
        'date',
        'status',
        'hour',
        'link',
        'notes', // JSON field for additional metadata
    ];

    protected $casts = [
        'date' => 'date',
    ];


    public static function booted() {
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();

        });
    }

    public function userParticipants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'meeting_participants')
                    ->withPivot('role')
                    ->whereNotNull('user_id');
    }

    public function clientParticipants(): HasMany {
        return $this->hasMany(MeetingParticipant::class, 'meeting_participants')
                    ->whereNotNull('client_id');
    }

    public function leadParticipants(): HasMany
    {
        return $this->hasMany(MeetingParticipant::class, 'meeting_participants')
                    ->whereNotNull('lead_id');
    }
}

