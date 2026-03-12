<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExternalMeeting extends Model
{

    use HasFactory;

    protected $fillable = [
        'title',
        'date',
        'hour',
        'status',
        'link',
        'lead_id',
        'notes'
    ];

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Leads::class);
    }
}
