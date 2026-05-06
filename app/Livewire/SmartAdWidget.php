<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BlogPost;

class SmartAdWidget extends Component
{
    public $latestAd;

    public function mount()
    {
        $this->latestAd = BlogPost::where('type', 'ad')->where('is_published', true)->latest()->first();
    }

    public function recordView()
    {
        if ($this->latestAd) {
            $this->latestAd->increment('views');
        }
    }

    public function render()
    {
        return view('livewire.smart-ad-widget');
    }
}
