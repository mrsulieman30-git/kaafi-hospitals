<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\Translatable\HasTranslations;

class JobPost extends Model
{
    use HasTranslations;

    protected $guarded = [];

    public $translatable = ['title', 'description', 'requirements', 'benefits', 'location'];

    public function getDisplayImageAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : asset('images/job-default.jpg');
    }
}
