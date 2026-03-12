<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Leads extends Model
{
    use HasFactory;

    // Set the primary key type to string (UUID)
    protected $keyType = 'string';

    // Disable auto-incrementing, since UUIDs will be used
    public $incrementing = false;

    // Define the fields that can be mass-assigned
    protected $fillable = [
        'id', 'name', 'email', 'phone', 'industry', 'status', 'lead_reason',
        'lead_source', 'follow_up_date', 'notes', 'found_by_id', 'last_contacted',
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

    /**
     * Scope a query to include the 'found_by' relationship, returning the complete query result.
     *
     * @param Builder $query
     * @return Collection
     */
    public function scopeWithFoundBy(Builder $query) : Collection {
        $query->with(['found_by']);
        return $query->get();
    }

    /**
     * Define the relationship to the User model via the 'found_by' foreign key.
     *
     * @return BelongsTo
     */
    public function found_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'found_by_id');
    }

    /**
     * Define a one-to-one relationship with the LeadSocialMediaContact model.
     *
     * @return HasOne
     */
    public function socialMedia(): HasOne
    {
        return $this->hasOne(LeadSocialMediaContact::class, 'lead_id');
    }

    /**
     * Define a one-to-one relationship with the Client model.
     *
     * @return HasOne
     */
    public function client(): HasOne {
        return $this->hasOne(Client::class, 'lead_id');
    }

    public function activities(): HasMany {
        return $this->hasMany(LeadActivity::class, 'lead_id');
    }
}


