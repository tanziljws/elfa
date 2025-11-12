<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'date',
        'category',
        'badge',
        'icon',
        'content',
        'image',
        'is_active'
    ];

    protected $casts = [
        'date' => 'date',
        'is_active' => 'boolean'
    ];

    /**
     * Scope untuk informasi aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk informasi terbaru
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('date', 'desc');
    }
}
