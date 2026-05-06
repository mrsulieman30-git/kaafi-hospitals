<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

use Illuminate\Support\Str;

class BlogPost extends Model
{
    use HasTranslations;

    protected $guarded = [];
    public $translatable = ['title', 'content', 'excerpt', 'meta_title', 'meta_description'];
    
    protected $casts = [
        'published_at' => 'datetime',
    ];

    // Automatically generate slug if not provided
    protected static function boot()
    {
        parent::boot();
        static::saving(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });
    }

    // SMART IMAGE HELPER: Checks for URL first, then Upload, then fallback
    public function getDisplayImageAttribute()
    {
        if (!empty($this->featured_image_url)) {
            return $this->featured_image_url;
        }
        
        if (!empty($this->featured_image)) {
            return asset('storage/' . $this->featured_image);
        }

        // Beautiful default gradient placeholder if no image exists
        return 'https://ui-avatars.com/api/?name=Kaafi+Hospital&background=003B73&color=fff&size=800';
    }

    public function linkedDoctor()
    {
        return $this->belongsTo(Doctor::class, 'linked_doctor_id');
    }

    public function category() { return $this->belongsTo(BlogCategory::class, 'blog_category_id'); }
    public function user() { return $this->belongsTo(User::class); }
    public function comments() { return $this->hasMany(BlogComment::class); }

    public static function getRandomPriorityAd()
    {
        return self::where('type', 'ad')
            ->where('is_published', true)
            ->where(function ($query) {
                $query->whereNull('offer_end_date')
                      ->orWhere('offer_end_date', '>=', now());
            })
            ->latest()
            ->take(5) // Get the 5 most recent
            ->get()
            ->whenNotEmpty(fn($collection) => $collection->random(1)->first());
    }
}