<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{
    protected $guarded = [];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(DoctorSchedule::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    // SMART IMAGE HELPER: Checks for URL first, then Upload, then fallback
    public function getDisplayImageAttribute()
    {
        if (!empty($this->image_url)) {
            return $this->image_url;
        }
        
        if (!empty($this->image)) {
            return asset('storage/' . $this->image);
        }

        // Beautiful default gradient placeholder if no image exists
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=003B73&color=fff&size=400';
    }
}