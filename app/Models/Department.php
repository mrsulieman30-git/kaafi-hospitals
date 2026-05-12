<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Department extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['name', 'description'];
    protected $guarded = [];

    public function doctors(): HasMany
    {
        return $this->hasMany(Doctor::class);
    }

    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Department::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Department::class, 'parent_id');
    }

    // Bulletproof Accessor for Name
    public function getLocalizedNameAttribute()
    {
        $locale = app()->getLocale();
        $raw = $this->getAttributes()['name'] ?? '';
        
        if (is_string($raw) && str_starts_with(trim($raw), '{')) {
            $decoded = json_decode($raw, true);
            $value = $decoded[$locale] ?? ($decoded['en'] ?? $raw);
            // Catch nested corrupted objects like [object Object]
            return is_string($value) ? $value : 'Unknown Department';
        }
        
        return $this->name ?? 'Unknown Department';
    }
}