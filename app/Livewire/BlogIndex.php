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
    public $sortBy = 'latest';
    public $selectedTag = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function selectCategory($categoryId)
    {
        $this->selectedCategory = $categoryId;
        $this->resetPage();
    }

    public function getLocalizedString($field)
    {
        $locale = app()->getLocale();

        if (is_string($field) && str_starts_with(trim($field), '{')) {
            $decoded = json_decode($field, true);
            $value = $decoded[$locale] ?? ($decoded['so'] ?? ($decoded['en'] ?? $field));
            return is_string($value) ? $value : ($decoded['en'] ?? $field);
        }

        return $field;
    }

    public function isNewPost($createdAt)
    {
        return $createdAt->diffInDays(now()) < 7;
    }

    public function getReadTime($content)
    {
        $words = str_word_count(strip_tags($content));
        $minutes = ceil($words / 200); // Average reading speed
        return $minutes;
    }

    public function render()
    {
        // Get all categories that have posts
        $categories = \App\Models\BlogCategory::has('posts')->get();

        // Get the latest 3 featured posts for the auto-slider (prioritize admin posts)
        $featuredPosts = BlogPost::where('is_published', true)
            ->with(['category', 'user'])
            ->latest()
            ->take(6) // Get more to filter
            ->get()
            ->sortByDesc(function ($post) {
                // Prioritize posts by admin users
                if ($post->user && $post->user->hasRole('admin')) {
                    return 1; // Admin posts first
                }
                return 2; // Regular posts second
            })
            ->take(3); // Take only first 3 after sorting
        $featuredIds = $featuredPosts->pluck('id')->toArray();

        // Get the rest of the posts, excluding the featured ones, or search all if searching
        $posts = BlogPost::where('is_published', true)
            ->with(['category', 'user'])
            ->when($this->search, function ($query) {
                $query->where(function($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('excerpt', 'like', '%' . $this->search . '%')
                      ->orWhere('content', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->selectedCategory, function ($query) {
                $query->where('blog_category_id', $this->selectedCategory);
            })
            ->when($this->sortBy === 'popular', function ($query) {
                $query->orderBy('likes_count', 'desc');
            })
            ->when($this->sortBy === 'oldest', function ($query) {
                $query->oldest();
            })
            ->when($this->sortBy === 'latest', function ($query) {
                $query->latest();
            })
            ->paginate(12);

        return view('livewire.blog-index', [
            'featuredPosts' => $featuredPosts,
            'posts' => $posts,
            'categories' => $categories,
        ])->layout('layouts.app');
    }
}
