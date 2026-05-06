<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Doctor;
use App\Models\DoctorSchedule;

class DoctorProfile extends Component
{
    public $doctor;
    public $workingDays = [];
    public $seoTitle;
    public $seoDescription;

    public function mount(Doctor $doctor)
    {
        $this->doctor = $doctor;

        // Fetch the doctor's active schedule days
        $schedules = DoctorSchedule::where('doctor_id', $doctor->id)->where('is_active', true)->get();
        $days = [];
        foreach ($schedules as $sched) {
            $schedDays = is_array($sched->day_of_week) ? $sched->day_of_week : [$sched->day_of_week];
            $days = array_merge($days, $schedDays);
        }
        $this->workingDays = array_unique($days);

        // Generate the dynamic SEO strings
        $this->generateSeoData();
    }

    private function getLocalizedString($field)
    {
        if (empty($field)) return '';
        if (is_array($field)) return $field['en'] ?? ($field['so'] ?? 'Unknown');
        if (is_string($field) && str_starts_with(trim($field), '{')) {
            $decoded = json_decode($field, true);
            return $decoded['en'] ?? ($decoded['so'] ?? $field);
        }
        return $field;
    }

    private function generateSeoData()
    {
        $docName = $this->getLocalizedString($this->doctor->name);
        $deptName = $this->doctor->department ? $this->getLocalizedString($this->doctor->department->name) : 'General Medicine';
        $speciality = $this->doctor->specialization ? $this->getLocalizedString($this->doctor->specialization) : $deptName;
        $hospitalName = 'KAAFI Hospitals';

        // Title format: Doctor's Name + Hospital Name + Department
        $this->seoTitle = "{$docName} | {$hospitalName} | {$deptName}";

        // Format the working days nicely
        $daysText = empty($this->workingDays) ? 'Please contact us for availability' : implode(', ', $this->workingDays);

        // Excerpt format: Name + is one of the top specialists at + Hospital + specialized in + Speciality + Schedule days
        $this->seoDescription = "{$docName} is one of the top specialists at {$hospitalName} and is specialized in {$speciality}. Available on: {$daysText}.";
    }

    public function render()
    {
        return view('livewire.doctor-profile')->layout('layouts.app');
    }
}
