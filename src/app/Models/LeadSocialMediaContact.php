<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class LeadSocialMediaContact extends Model
{
    use HasFactory;

    // Set the primary key type to string (UUID)
    protected $keyType = 'string';

    // Disable auto-incrementing since UUIDs are used as primary keys
    public $incrementing = false;

    // Define the fields that can be mass-assigned
    protected $fillable = ['lead_id', 'instagram', 'facebook', 'linkedin'];

    /**
     * Boot the model to automatically generate a UUID for the ID when creating.
     */
    public static function booted(): void
    {
        // Generate a UUID for the ID field when a new LeadSocialMediaContact instance is created
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    /**
     * Define the relationship to the Leads model.
     *
     * @return BelongsTo
     */
    public function lead(): BelongsTo
    {
        // Establish a BelongsTo relationship with the Leads model, using 'lead_id' as the foreign key
        return $this->belongsTo(Leads::class, 'lead_id');
    }
}
