<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BlogPost;

class BlogPostShow extends Component
{
    public $post;

    public function mount($slug)
    {
        // Find the post by the slug in the URL. If it doesn't exist, show a 404 page.
        $this->post = BlogPost::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.blog-post-show')->layout('layouts.app');
    }
}
