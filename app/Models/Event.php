<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
    protected $table = 'events';
    
    protected $fillable = [
        'title',
        'description',
        'location',
        'start_date',
        'end_date',
        'is_active',
    ];
    
    protected $dates = [
        'start_date',
        'end_date',
        'created_at',
        'updated_at',
    ];
    
    public function scopeUpcoming($query)
    {
        return $query->where('end_date', '>=', now())
                    ->where('is_active', true)
                    ->orderBy('start_date', 'asc');
    }
}
