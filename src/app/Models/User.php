<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Goal;
use App\Models\Leads;
use App\Models\Meeting;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $keyType = 'string';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'address', 'dob', 'gender', 'position', 'department', 'employment_status', 'doh', 'photo'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

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

    public function projects (): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function assignedTasks (): HasMany
    {
        return $this->hasMany(Task::class);
    }


    public function leads (): HasMany
    {
        return $this->hasMany(Leads::class);
    }

    public function goals () : HasMany {
        return $this->hasMany(Goal::class);
    }
}

