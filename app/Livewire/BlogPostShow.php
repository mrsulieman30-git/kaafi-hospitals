<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BlogPost;
use App\Models\BlogComment;
use Illuminate\Support\Facades\Auth;

class BlogPostShow extends Component
{
    public $post;
    public $newComment = '';
    public $userHasLiked = false;
    public $likesCount = 0;

    public function mount($slug)
    {
        // Find the post by the slug in the URL. If it doesn't exist, show a 404 page.
        $this->post = BlogPost::where('slug', $slug)
            ->where('is_published', true)
            ->with(['comments' => function($query) {
                $query->where('is_approved', true)->latest();
            }])
            ->firstOrFail();

        $this->likesCount = $this->post->likes_count ?? 0;
        $this->checkUserLike();
    }

    public function checkUserLike()
    {
        // Use session for both authenticated and guest visitors
        $likedPosts = session('liked_posts', []);
        $this->userHasLiked = in_array($this->post->id, $likedPosts);
    }

    public function toggleLike()
    {
        $likedPosts = session('liked_posts', []);

        if ($this->userHasLiked) {
            // Unlike
            $likedPosts = array_values(array_diff($likedPosts, [$this->post->id]));
            $this->likesCount = max(0, $this->likesCount - 1);
            $this->userHasLiked = false;
        } else {
            // Like
            $likedPosts[] = $this->post->id;
            $likedPosts = array_values(array_unique($likedPosts));
            $this->likesCount++;
            $this->userHasLiked = true;
        }

        session(['liked_posts' => $likedPosts]);
        $this->post->likes_count = $this->likesCount;
    }

    public function addComment()
    {
        if (!Auth::check()) {
            session()->flash('message', 'Please login to comment.');
            return;
        }

        // Clean the comment to prevent code injection
        $cleanedComment = $this->sanitizeComment($this->newComment);

        // Check if comment was modified during sanitization
        if ($cleanedComment !== $this->newComment) {
            session()->flash('warning', 'Your comment contained special characters that were removed. Please use only letters, numbers, and basic punctuation.');
        }

        $this->validate([
            'newComment' => 'required|min:5|max:1000'
        ]);

        BlogComment::create([
            'blog_post_id' => $this->post->id,
            'user_id' => Auth::id(),
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'content' => $cleanedComment,
            'is_approved' => false, // Admin approval required
        ]);

        $this->newComment = '';

        session()->flash('message', 'Your comment has been submitted and is pending admin approval. It will be published once reviewed.');
    }

    private function sanitizeComment($comment)
    {
        // Remove any HTML tags
        $comment = strip_tags($comment);

        // Remove special characters and symbols, keep only letters, numbers, spaces, and basic punctuation
        $comment = preg_replace('/[^a-zA-Z0-9\s\.,!?\-\'\"]/u', '', $comment);

        // Remove multiple spaces
        $comment = preg_replace('/\s+/', ' ', $comment);

        // Trim whitespace
        return trim($comment);
    }

    public function render()
    {
        return view('livewire.blog-post-show')->layout('layouts.app');
    }
}
