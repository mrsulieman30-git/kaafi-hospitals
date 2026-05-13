<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\JobPost;
use Livewire\WithPagination;

class CareerIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $type = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingType()
    {
        $this->resetPage();
    }

    public function render()
    {
        $jobs = JobPost::where('is_active', true)
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->type, function ($query) {
                $query->where('type', $this->type);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('livewire.career-index', [
            'jobs' => $jobs
        ])->layout('layouts.app');
    }
}
