<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Doctor;
use App\Models\Department;

class DoctorsIndex extends Component
{
    public $search = '';
    public $department_id = '';

    public function render()
    {
        $doctors = Doctor::with('department')
            ->where('is_active', true)
            ->when($this->search, function ($query) {
                // Handle search in JSON name field for Spatie Translatable
                $query->where('name->en', 'like', '%' . $this->search . '%')
                      ->orWhere('name->so', 'like', '%' . $this->search . '%');
            })
            ->when($this->department_id, function ($query) {
                $query->where('department_id', $this->department_id);
            })
            ->get();

        $departments = Department::all();

        return view('livewire.doctors-index', [
            'doctors' => $doctors,
            'departments' => $departments,
        ])->layout('layouts.app');
    }
}
