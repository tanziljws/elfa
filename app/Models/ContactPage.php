<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactPage extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'address',
        'phone',
        'phone_alt',
        'email',
        'email_alt',
        'instagram_url',
        'youtube_url',
        'whatsapp_url',
        'office_hours_weekday',
        'office_hours_saturday',
        'office_hours_sunday',
        'note'
    ];
}
