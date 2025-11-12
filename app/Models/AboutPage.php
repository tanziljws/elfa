<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutPage extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'image_path',
        'history_title',
        'history_content',
        'development_title',
        'development_content',
        'vision_title',
        'vision_content',
        'mission_title',
        'mission_items',
        'profile_image',
        'address',
        'phone',
        'email',
        'website',
        'competencies'
    ];

    protected $casts = [
        'mission_items' => 'array',
        'competencies' => 'array',
    ];

    public function getImageUrlAttribute()
    {
        if (!$this->image_path) {
            return asset('images/smk4 bogor 6.jpg');
        }
        
        if (str_starts_with($this->image_path, 'http')) {
            return $this->image_path;
        }
        
        return asset('storage/' . $this->image_path);
    }

    public function getProfileImageUrlAttribute()
    {
        if (!$this->profile_image) {
            return asset('images/smk4 bogor 3.webp');
        }
        
        if (str_starts_with($this->profile_image, 'http')) {
            return $this->profile_image;
        }
        
        return asset('storage/' . $this->profile_image);
    }
}
