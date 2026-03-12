<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'description',
        'client_id',
        'start_date',
        'status',
        'plan',
        'phase'
    ];

    public static function booted(): void
    {
        static::creating(function ($model) {
            $model->id = (string)Str::uuid();
        });
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function clientRequests(): HasMany
    {
        return $this->hasMany(ClientRequests::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function scopeProjectPerPlan(Builder $query): Builder
    {
        return $query->selectRaw('Plan,Count(*) as numberOfProjects')
            ->groupBy('Plan');

    }

}

