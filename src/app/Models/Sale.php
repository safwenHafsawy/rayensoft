<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{
    use HasFactory;

         /**
     * Boot the model and set the ID to a UUID when creating a new instance.
     */
    public static function booted() : void {
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    public function scopeSalesTotalPerMonth (Builder $query) : Builder {
        return $query->selectRaw('YEAR(sale_date) as year, MONTH(sale_date) as month, Sum(amount) as total')
            ->groupByRaw('YEAR(sale_date), MONTH(sale_date)')
            ->orderBy('year')
            ->orderBy('month');

    }
}

