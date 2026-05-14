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
    public $guestName = '';
    public $guestEmail = '';
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
        $ip = request()->ip();
        $userId = Auth::id();

        $this->userHasLiked = \App\Models\BlogPostLike::where('blog_post_id', $this->post->id)
            ->where(function ($query) use ($userId, $ip) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('ip_address', $ip);
                }
            })->exists();
    }

    public function toggleLike()
    {
        $ip = request()->ip();
        $userId = Auth::id();

        if ($this->userHasLiked) {
            // Unlike: Remove from DB
            \App\Models\BlogPostLike::where('blog_post_id', $this->post->id)
                ->where(function ($query) use ($userId, $ip) {
                    if ($userId) {
                        $query->where('user_id', $userId);
                    } else {
                        $query->where('ip_address', $ip);
                    }
                })->delete();

            $this->likesCount = max(0, $this->likesCount - 1);
            $this->userHasLiked = false;
        } else {
            // Like: Add to DB
            try {
                \App\Models\BlogPostLike::create([
                    'blog_post_id' => $this->post->id,
                    'user_id' => $userId,
                    'ip_address' => $ip,
                ]);
                $this->likesCount++;
                $this->userHasLiked = true;
            } catch (\Exception $e) {
                // Duplicate like handled by unique index or other error
                return;
            }
        }

        $this->post->likes_count = $this->likesCount;
        $this->post->save();
    }

    public function addComment()
    {
        // Clean the comment to prevent code injection
        $cleanedComment = $this->sanitizeComment($this->newComment);

        // Check if comment was modified during sanitization
        if ($cleanedComment !== $this->newComment) {
            session()->flash('warning', 'Your comment contained special characters that were removed. Please use only letters, numbers, and basic punctuation.');
        }

        $rules = [
            'newComment' => 'required|min:5|max:1000',
        ];

        if (!Auth::check()) {
            $rules['guestName'] = 'required|min:2|max:50';
            $rules['guestEmail'] = 'required|email';
        }

        $this->validate($rules);

        BlogComment::create([
            'blog_post_id' => $this->post->id,
            'user_id' => Auth::id(),
            'ip_address' => request()->ip(),
            'name' => Auth::check() ? Auth::user()->name : $this->guestName,
            'email' => Auth::check() ? Auth::user()->email : $this->guestEmail,
            'content' => $cleanedComment,
            'is_approved' => false, // Admin approval required
        ]);

        $this->newComment = '';
        $this->guestName = '';
        $this->guestEmail = '';

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
        $ip = request()->ip();
        $userId = Auth::id();

        // Get approved comments for everyone to see
        $approvedComments = BlogComment::where('blog_post_id', $this->post->id)
            ->where('is_approved', true)
            ->latest()
            ->get();

        // Get pending comments for the CURRENT user only
        $pendingComments = BlogComment::where('blog_post_id', $this->post->id)
            ->where('is_approved', false)
            ->where(function($query) use ($userId, $ip) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('ip_address', $ip);
                }
            })
            ->latest()
            ->get();

        return view('livewire.blog-post-show', [
            'approvedComments' => $approvedComments,
            'pendingComments' => $pendingComments
        ])->layout('layouts.app');
    }
}
