<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BlogPost;
use App\Models\BlogComment;

class BlogEngagement extends Component
{
    public BlogPost $post;
    public string $commentName = '';
    public string $commentEmail = '';
    public string $commentContent = '';
    public bool $showCommentForm = false;
    public bool $commentSubmitted = false;
    public bool $hasLiked = false;

    public function mount(BlogPost $post)
    {
        $this->post = $post;
        // Check if user already liked (using session)
        $this->hasLiked = session()->has('liked_post_' . $post->id);
    }

    public function toggleLike()
    {
        if ($this->hasLiked) {
            $this->post->decrement('likes_count');
            session()->forget('liked_post_' . $this->post->id);
            $this->hasLiked = false;
        } else {
            $this->post->increment('likes_count');
            session()->put('liked_post_' . $this->post->id, true);
            $this->hasLiked = true;
        }
        $this->post->refresh();
    }

    public function toggleCommentForm()
    {
        $this->showCommentForm = !$this->showCommentForm;
    }

    public function submitComment()
    {
        $this->validate([
            'commentName' => 'required|min:2|max:100',
            'commentEmail' => 'required|email|max:255',
            'commentContent' => 'required|min:5|max:2000',
        ]);

        BlogComment::create([
            'blog_post_id' => $this->post->id,
            'name' => $this->commentName,
            'email' => $this->commentEmail,
            'content' => $this->commentContent,
            'is_approved' => false,
        ]);

        $this->commentName = '';
        $this->commentEmail = '';
        $this->commentContent = '';
        $this->commentSubmitted = true;
        $this->showCommentForm = false;
    }

    public function render()
    {
        $approvedComments = BlogComment::where('blog_post_id', $this->post->id)
            ->where('is_approved', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.blog-engagement', [
            'comments' => $approvedComments,
        ]);
    }
}
