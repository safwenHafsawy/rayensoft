<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Visitor extends Model
{
        
    use HasFactory;

    protected $fillable = [
        'ip_address',
        'session_id',
        'user_agent',
        'location',
        'visited_pages_count',
        'last_page',
        'visited_at',
    ];
    protected $casts = [
        'visited_at' => 'datetime',
    ];

    public static function booted() {
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();

        });
    }

    public function scopeVisitsPerMonth(Builder $query)
    {
        return $query->selectRaw('YEAR(visited_at) as year, MONTH(visited_at) as month, COUNT(*) as total')
            ->groupByRaw('YEAR(visited_at), MONTH(visited_at)')
            ->orderBy('year')
            ->orderBy('month');
    }
    public function scopeVisitsPerHourToday(Builder $query)
    {
        return $query->selectRaw('HOUR(visited_at) as hour, COUNT(*) as total')
            ->whereDate('visited_at', now()->format('Y-m-d'))
            ->groupByRaw('HOUR(visited_at)')
            ->orderBy('hour');
    }

    public function scopeVisitsPerHourYesterday(Builder $query)
    {
        return $query->selectRaw('HOUR(visited_at) as hour, COUNT(*) as total')
            ->whereDate('visited_at', now()->subDay()->format('Y-m-d'))
            ->groupByRaw('HOUR(visited_at)')
            ->orderBy('hour');
    }
      public function scopeVisitorsByLocation(Builder $query) {
        return $query->selectRaw('location as location, count(*) as numberOfVisitors')
                    ->orderBy('numberOfVisitors', 'desc')
                    ->groupBy('location')
                    ->limit(5);
    }
    public function scopeVisitorsAllLocation(Builder $query) {
        return $query->selectRaw('location as location, count(*) as numberOfVisitors')
                    ->orderBy('numberOfVisitors', 'desc')
                    ->groupBy('location');
                    
    }
    
     public function scopeAverageNbVisitedPages(Builder $query) {
        return $query->selectRaw('AVG(visited_pages_count) as average');
    }

}

