<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\JobPost;

class JobShow extends Component
{
    public $job;

    public function mount($slug)
    {
        $this->job = JobPost::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.job-show')->layout('layouts.app');
    }
}
