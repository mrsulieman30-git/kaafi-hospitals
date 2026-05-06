<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Department extends Model
{
    use HasFactory, HasTranslations;

    protected $guarded = [];

    // This tells Laravel to automatically translate these JSON fields
    public $translatable = ['name', 'description'];

    public function doctors(): HasMany
    {
        return $this->hasMany(Doctor::class);
    }
}