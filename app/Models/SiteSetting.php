<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'logo_path',
        'logo_height',
        'logo_position',
        'hero_bg_path',
        'hero_bg_opacity',
        'chatbot_avatar_path',
        'location_coordinates',
    ];

    protected $casts = [
        'location_coordinates' => 'array',
    ];
}
