<?php

namespace App\Models;

use App\Models\Client;
use App\Models\Meeting;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class MeetingParticipant extends Model
{
    protected $fillable = [
        'meeting_id',
        'user_id',
        'client_id',
        'role'
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

        public function meeting(): BelongsTo
    {
        return $this->belongsTo(Meeting::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // optional if you have a clients table
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

}
