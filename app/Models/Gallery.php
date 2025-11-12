<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image_path',
        'category',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $appends = [
        'image_url'
    ];

    public function getImageUrlAttribute()
    {
        // Check if image_path is a URL (starts with http)
        if (str_starts_with($this->image_path, 'http')) {
            return $this->image_path;
        }
        
        // Use the correct server URL for Laravel development server
        if (app()->environment('local') && request()->getHost() === '127.0.0.1') {
            return request()->getSchemeAndHttpHost() . '/storage/' . $this->image_path;
        }
        
        return asset('storage/' . $this->image_path);
    }

    public function likes()
    {
        return $this->hasMany(GalleryLike::class);
    }

    public function comments()
    {
        return $this->hasMany(GalleryComment::class);
    }

    public function likesCount()
    {
        return $this->likes()->where('type', 'like')->count();
    }

    public function dislikesCount()
    {
        return $this->likes()->where('type', 'dislike')->count();
    }

    public function approvedComments()
    {
        return $this->comments(); // All comments are auto-approved now
    }
}
