<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'job_title',
        'application_date',
        'country',
        'city',
        'street_address',
        'postal_code',
        'resume',
        'experience',
        'skills',
        'status',
    ];
}

