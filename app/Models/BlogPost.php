<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class BlogPost extends Model
{
    use HasTranslations;

    protected $guarded = [];
    public $translatable = ['title', 'content', 'excerpt', 'meta_title', 'meta_description'];
    
    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function category() { return $this->belongsTo(BlogCategory::class, 'blog_category_id'); }
    public function user() { return $this->belongsTo(User::class); }
    public function comments() { return $this->hasMany(BlogComment::class); }
}