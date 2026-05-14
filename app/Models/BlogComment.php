<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    protected $guarded = [];

    public function post() { return $this->belongsTo(BlogPost::class, 'blog_post_id'); }
    public function user() { return $this->belongsTo(\App\Models\User::class); }
}
