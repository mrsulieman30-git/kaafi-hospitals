<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BlogPost;
use Livewire\WithPagination;

class BlogIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedCategory = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function selectCategory($categoryId)
    {
        $this->selectedCategory = $categoryId;
        $this->resetPage();
    }

    public function render()
    {
        // Get all categories that have posts
        $categories = \App\Models\BlogCategory::has('posts')->get();

        // Get the latest 3 featured posts for the auto-slider
        $featuredPosts = BlogPost::where('is_published', true)->latest()->take(3)->get();
        $featuredIds = $featuredPosts->pluck('id')->toArray();

        // Get the rest of the posts, excluding the featured ones, or search all if searching
        $posts = BlogPost::where('is_published', true)
            ->with('category')
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('excerpt', 'like', '%' . $this->search . '%');
            })
            ->when($this->selectedCategory, function ($query) {
                $query->where('blog_category_id', $this->selectedCategory);
            })
            ->when(empty($this->search), function ($query) use ($featuredIds) {
                // Only exclude featured posts from the grid if the user isn't actively searching
                $query->whereNotIn('id', $featuredIds);
            })
            ->latest()
            ->paginate(12);

        return view('livewire.blog-index', [
            'featuredPosts' => $featuredPosts,
            'posts' => $posts,
            'categories' => $categories,
        ])->layout('layouts.app');
    }
}
