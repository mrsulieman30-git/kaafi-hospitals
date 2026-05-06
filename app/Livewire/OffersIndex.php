<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BlogPost;

class OffersIndex extends Component
{
    public function likeAd($id)
    {
        $ad = BlogPost::find($id);
        if ($ad) {
            $ad->increment('likes');
        }
    }

    public function render()
    {
        // Fetch only ads
        $offers = BlogPost::where('type', 'ad')->where('is_published', true)->latest()->get();
        return view('livewire.offers-index', ['offers' => $offers])->layout('layouts.app');
    }
}
