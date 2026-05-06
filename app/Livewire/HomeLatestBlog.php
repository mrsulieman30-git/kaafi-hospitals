<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BlogPost;

class HomeLatestBlog extends Component
{
    public function render()
    {
        $posts = BlogPost::where('is_published', true)
            ->latest()
            ->take(8) // INCREASED FOR THE SLIDER
            ->get();

        return view('livewire.home-latest-blog', [
            'posts' => $posts,
        ]);
    }
}
