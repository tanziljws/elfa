<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class News extends Model
{
    protected $table = 'news';
    
    protected $fillable = [
        'title',
        'author',
        'description',
        'content',
        'image',
        'category',
        'location',
        'published_at',
        'is_active',
    ];
    
    protected $casts = [
        'published_at' => 'datetime',
        'is_active' => 'boolean',
    ];
    
    /**
     * Scope untuk berita yang sudah dipublish
     */
    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', now())
                    ->where('is_active', true)
                    ->orderBy('published_at', 'desc');
    }
    
    /**
     * Scope untuk berita terbaru
     */
    public function scopeLatest($query)
    {
        return $query->where('is_active', true)
                    ->orderBy('published_at', 'desc');
    }
    
    /**
     * Scope berdasarkan kategori
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
    
    /**
     * Get formatted published date
     */
    public function getFormattedPublishedDateAttribute()
    {
        return $this->published_at ? $this->published_at->format('d F Y') : '-';
    }
    
    /**
     * Get excerpt from content
     */
    public function getExcerptAttribute()
    {
        return $this->description ?: substr(strip_tags($this->content), 0, 150) . '...';
    }
}
