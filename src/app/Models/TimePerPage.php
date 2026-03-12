<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimePerPage extends Model
{
    use HasFactory;

    protected $fillable = ['page', 'timeSpent', 'session_id', 'number_of_visits'];

    public function scopeTimeSpentPerPage($query) {
        return $query->selectRaw('DISTINCT page as page, AVG(timeSpent) as time_spent')  
                   ->orderBy('page')
                    ->groupBy('page');   
    }
    public function scopeMostVisitedPages($query) {
        return $query->selectRaw('DISTINCT page as page, SUM(number_of_visits) as number_of_visits')  
                   ->orderBy('page') 
                    ->groupBy('page')
                    ->limit(4);   
    }
}
