<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BookAppointment extends Component
{
    // Workflow State
    public $currentStep = 1; // 1: Doctor, 2: Date, 3: Time (Popup), 4: Patient Info, 5: Summary (Popup)
    
    // Selection Data
    public $selectedDoctorId = null;
    public $selectedDate = null;
    public $selectedTime = null;
    
    // Patient Information
    public $patient_name = '';
    public $patient_phone = '';
    public $patient_email = '';
    public $notes = '';

    // UI Data
    public $showTimeModal = false;
    public $showSummaryModal = false;
    public $successMessage = '';

    protected $rules = [
        'patient_name' => 'required|string|min:3|max:255',
        'patient_phone' => 'required|string|min:8',
        'patient_email' => 'nullable|email',
    ];

    public function mount($doctor = null)
    {
        if ($doctor) {
            $found = null;
            if (is_numeric($doctor)) {
                $found = Doctor::find($doctor);
            } else {
                $found = Doctor::where('slug', $doctor)->first();
            }

            if ($found) {
                $this->selectDoctor($found->id);
            }
        }
    }

    // --- Workflow Methods ---

    public function selectDoctor($id)
    {
        $this->selectedDoctorId = $id;
        $this->selectedDate = null;
        $this->selectedTime = null;
        $this->currentStep = 2;
        
        // Reset modals
        $this->showTimeModal = false;
        $this->showSummaryModal = false;
    }

    public function selectDate($date)
    {
        $this->selectedDate = $date;
        $this->selectedTime = null;
        $this->showTimeModal = true;
    }

    public function selectTime($time)
    {
        $this->selectedTime = $time;
        $this->showTimeModal = false;
        $this->currentStep = 4;
    }

    public function proceedToSummary()
    {
        $this->validate();
        $this->showSummaryModal = true;
    }

    public function confirmAppointment()
    {
        $this->validate();

        DB::transaction(function () {
            // Find or create user based on phone
            $formattedPhone = $this->formatPhoneNumber($this->patient_phone);
            $user = User::where('phone', $formattedPhone)->first();

            if (!$user) {
                $user = User::create([
                    'name' => $this->patient_name,
                    'phone' => $formattedPhone,
                    'email' => $this->patient_email ?: 'patient_' . uniqid() . '@kaafihospitals.so',
                    'password' => Hash::make($this->patient_phone),
                ]);
                
                // Assign Patient role if exists
                if (class_exists(\Spatie\Permission\Models\Role::class)) {
                    $role = \Spatie\Permission\Models\Role::where('name', 'Patient')->first();
                    if ($role) $user->assignRole($role);
                }
            }

            $doctor = Doctor::find($this->selectedDoctorId);

            Appointment::create([
                'user_id' => $user->id,
                'doctor_id' => $this->selectedDoctorId,
                'department_id' => $doctor->department_id,
                'patient_name' => $this->patient_name,
                'patient_phone' => $formattedPhone,
                'patient_email' => $this->patient_email,
                'appointment_date' => $this->selectedDate,
                'appointment_time' => Carbon::parse($this->selectedTime)->format('H:i:s'),
                'notes' => $this->notes ?: 'Booked via simplified web form',
                'status' => 'pending',
            ]);
        });

        $this->successMessage = __('Booking Successful! Our team will contact you shortly.');
        $this->currentStep = 1;
        $this->reset(['selectedDoctorId', 'selectedDate', 'selectedTime', 'patient_name', 'patient_phone', 'patient_email', 'notes', 'showSummaryModal']);
    }

    public function goToStep($step)
    {
        $this->currentStep = $step;
        if ($step < 3) $this->showTimeModal = false;
        if ($step < 5) $this->showSummaryModal = false;
    }

    // --- Helpers ---

    private function formatPhoneNumber($phone)
    {
        $raw = preg_replace('/[^0-9]/', '', $phone);
        $raw = ltrim($raw, '0');
        if (str_starts_with($raw, '252')) return '+' . $raw;
        return '+252' . $raw;
    }

    public function getDoctorsProperty()
    {
        return Doctor::with('department')->where('is_active', true)->get()->map(function($doctor) {
            // Generate deterministic "random" rating based on ID
            $doctor->rating = 4.5 + (($doctor->id * 7) % 5) / 10;
            return $doctor;
        });
    }

    public function getSelectedDoctorProperty()
    {
        return $this->selectedDoctorId ? Doctor::with('department')->find($this->selectedDoctorId) : null;
    }

    public function getAvailableDatesProperty()
    {
        if (!$this->selectedDoctorId) return [];

        $doctor = Doctor::find($this->selectedDoctorId);
        $dates = [];
        $today = Carbon::today();

        // Get working days for this doctor
        $workingDays = [];
        foreach ($doctor->schedules()->where('is_active', true)->get() as $sch) {
            $days = is_array($sch->day_of_week) ? $sch->day_of_week : json_decode($sch->day_of_week, true) ?? [];
            foreach ($days as $d) if (!in_array($d, $workingDays)) $workingDays[] = $d;
        }

        // Check next 30 days
        for ($i = 0; $i < 30; $i++) {
            $date = $today->copy()->addDays($i);
            if (in_array($date->format('l'), $workingDays)) {
                $dates[] = [
                    'date' => $date->format('Y-m-d'),
                    'label' => $date->format('D, M d'),
                    'day' => $date->format('d'),
                    'month' => $date->format('M'),
                ];
            }
        }

        return $dates;
    }

    public function getAvailableTimesProperty()
    {
        if (!$this->selectedDoctorId || !$this->selectedDate) return [];

        $doctor = Doctor::find($this->selectedDoctorId);
        return $doctor->getAvailableTimeSlots($this->selectedDate);
    }

    public function render()
    {
        return view('livewire.book-appointment')
            ->layout('layouts.app', ['title' => __('Book Appointment')]);
    }
}
