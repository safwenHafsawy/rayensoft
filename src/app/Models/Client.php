<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;

    // Specify that the primary key is a string (UUID)
    protected $keyType = 'string';

    // Indicate that the primary key is not auto-incrementing
    public $incrementing = false;

    // Specify the fields that are mass-assignable
    protected $fillable = [
        'lead_id',
        'engagement_date',
        'address',
        'country',
        'city',
        'type'
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

    /**
     * Define a one-to-many relationship with the Project model.
     *
     * @return HasMany
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Define a one-to-one relationship with the Lead model
     *
     * @return BelongsTo
     * */
    public function lead(): BelongsTo
    {
        return $this->belongsTo(Leads::class);
    }

    /**
     * Scope a query to group clients by country, ordered by the number of clients in descending order.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeClientsByCountry(Builder $query): Builder
    {
        return $query->selectRaw('country as country, count(*) as numberOfClients')
            ->orderBy('numberOfClients', 'desc')
            ->groupBy('country')
            ->limit(10);
    }

    /**
     * Scope a query to group clients by their satisfaction type, ordered by the number of clients in descending order.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeClientSatisfaction(Builder $query): Builder
    {
        return $query->selectRaw('type as type, count(*) as numberOfClients')
            ->orderBy('numberOfClients', 'desc')
            ->groupBy('type');
    }

    /**
     * Scope a query to group clients by industry, ordered by the number of clients in ascending order.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeClientsByIndustry(Builder $query): Builder
    {
        return $query->join('leads', 'clients.lead_id', '=', 'leads.id')
            ->where('leads.status', 'Won')
            ->selectRaw('leads.industry as industry, count(clients.id) as numberOfClients')
            ->orderBy('numberOfClients')
            ->groupBy('leads.industry');
    }


    /**
     * Scope a query to group clients by acquisition channel, ordered by the number of clients in ascending order.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeClientsByChannel(Builder $query): Builder
    {
        return $query->join('leads', 'clients.lead_id', '=', 'leads.id')
            ->where('leads.status', 'Won')
            ->selectRaw('leads.lead_source as lead_source, count(clients.id) as numberOfClients')
            ->orderBy('numberOfClients', 'desc')
            ->groupBy('leads.lead_source');
    }
}

