<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class ClientRequests extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'description', 'status', 'project_id', 'priority'];

    protected $keyType = 'string';
    public $incrementing = false;

    public static function booted(): void
    {
        static::creating(function ($model) {
            $model->id = (string)Str::uuid();
        });
    }

    public function project(): BelongsTo {
        return $this->belongsTo(Project::class);
    }

}





