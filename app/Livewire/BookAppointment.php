<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\DoctorSchedule;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BookAppointment extends Component
{
    // Form Fields
    public $doctor_id = '';
    public $patient_name = '';
    public $patient_phone = '';
    public $patient_email = '';
    public $department_id = '';
    public $notes = '';
    public $appointment_date = '';
    public $appointment_time = '';
    
    // UI State
    public $available_times = [];
    public $allowed_days = [];
    public $successMessage = '';
    public $selectedDoctor = null;

    public function mount($doctor = null)
    {
        $doctorId = null;
        if ($doctor) {
            if ($doctor instanceof Doctor) {
                $doctorId = $doctor->id;
            } elseif (is_numeric($doctor)) {
                $doctorId = (int) $doctor;
            } else {
                $found = Doctor::where('slug', $doctor)->first();
                if ($found) $doctorId = $found->id;
            }
        }
        
        if (!$doctorId) {
            $routeParam = request()->route('doctor');
            if ($routeParam) {
                $doctorId = $routeParam instanceof Doctor ? $routeParam->id : (int) $routeParam;
            }
        }
        
        if ($doctorId) {
            $this->selectDoctor($doctorId);
        }
    }

    #[Computed]
    public function doctors()
    {
        return Doctor::where('is_active', true)->with('department')->get();
    }

    #[Computed]
    public function departments()
    {
        return Department::all();
    }

    public function selectDoctor($id)
    {
        $this->doctor_id = (string) $id;
        $this->appointment_date = '';
        $this->appointment_time = '';
        $this->available_times = [];
        
        $this->selectedDoctor = Doctor::with('department')->find($this->doctor_id);
        
        if ($this->selectedDoctor) {
            $this->department_id = (string) $this->selectedDoctor->department_id;
            $this->loadDoctorSchedule();
        }

        $this->dispatch('close-doctor-dropdown');
    }

    public function updatedDoctorId()
    {
        $this->selectDoctor($this->doctor_id);
    }

    public function selectDate($dateStr)
    {
        $this->appointment_date = $dateStr;
        $this->appointment_time = '';
        $this->loadTimeSlotsForDate();
    }

    public function selectTime($time)
    {
        $this->appointment_time = $time;
    }

    private function loadDoctorSchedule()
    {
        $this->allowed_days = [];

        if (empty($this->doctor_id) || !$this->selectedDoctor) {
            $this->dispatch('update-allowed-days', days: $this->allowed_days);
            return;
        }

        $schedules = $this->selectedDoctor->schedules()->where('is_active', true)->get();
        
        foreach ($schedules as $schedule) {
            $days = is_array($schedule->day_of_week) 
                ? $schedule->day_of_week 
                : (json_decode($schedule->day_of_week, true) ?? []);
            
            foreach ($days as $day) {
                if (!in_array($day, $this->allowed_days)) {
                    $this->allowed_days[] = $day;
                }
            }
        }

        $this->dispatch('update-allowed-days', days: $this->allowed_days);
    }

    private function loadTimeSlotsForDate()
    {
        $this->available_times = [];

        if (empty($this->doctor_id) || empty($this->appointment_date)) {
            return;
        }

        $date = Carbon::parse($this->appointment_date);
        $dayName = $date->format('l');

        $schedules = DoctorSchedule::where('doctor_id', $this->doctor_id)
            ->where('is_active', true)
            ->get();

        $activeSchedule = null;
        foreach ($schedules as $schedule) {
            $days = is_array($schedule->day_of_week) ? $schedule->day_of_week : (json_decode($schedule->day_of_week, true) ?? []);
            if (in_array($dayName, $days)) {
                $activeSchedule = $schedule;
                break;
            }
        }

        if (!$activeSchedule || !$activeSchedule->start_time || !$activeSchedule->end_time) return;

        $startTime = Carbon::parse($activeSchedule->start_time);
        $endTime = Carbon::parse($activeSchedule->end_time);

        $bookedAppointments = Appointment::where('doctor_id', $this->doctor_id)
            ->whereDate('appointment_date', $this->appointment_date)
            ->whereIn('status', ['pending', 'approved', 'confirmed'])
            ->pluck('appointment_time')
            ->map(fn($time) => Carbon::parse($time)->format('H:i'))
            ->toArray();

        while ($startTime->lessThan($endTime)) {
            $timeString = $startTime->format('H:i');
            
            if (!in_array($timeString, $bookedAppointments)) {
                if (!($date->isToday() && $startTime->isPast())) {
                    $this->available_times[] = $timeString;
                }
            }
            $startTime->addMinutes(30);
        }
    }

    public function submitAppointment()
    {
        $this->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'patient_name' => 'required|string|max:255',
            'patient_phone' => 'required|string|min:9',
            'patient_email' => 'nullable|email|max:255',
            'department_id' => 'required|exists:departments,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
        ]);

        DB::transaction(function () {
            $rawPhone = preg_replace('/[^0-9]/', '', $this->patient_phone); 
            $rawPhone = ltrim($rawPhone, '0');
            $formattedPhone = '+252' . $rawPhone;

            $patient = User::where('phone', $formattedPhone)->first();

            if (!$patient) {
                $patient = new User();
                $patient->name = $this->patient_name;
                $patient->phone = $formattedPhone;
                $patient->email = $this->patient_email ?: 'patient_' . uniqid() . '@kaafihospitals.so'; 
                $patient->password = Hash::make('0' . $rawPhone);
                $patient->save();

                if (class_exists(\Spatie\Permission\Models\Role::class)) {
                    if (\Spatie\Permission\Models\Role::where('name', 'Patient')->exists()) {
                        $patient->assignRole('Patient');
                    }
                }
            }

            $appointment = new Appointment();
            $appointment->user_id = $patient->id;
            $appointment->department_id = $this->department_id;
            $appointment->doctor_id = $this->doctor_id;
            $appointment->appointment_date = $this->appointment_date;
            $appointment->appointment_time = Carbon::parse($this->appointment_time)->format('H:i:s');
            $appointment->status = 'pending';
            $appointment->notes = empty($this->notes) ? 'Booked via Web Form' : $this->notes;
            $appointment->save();

            $this->successMessage = "Appointment requested successfully! You can track it in the Patient Portal. Username: 0{$rawPhone} | Password: 0{$rawPhone}";
            
            $this->reset(['patient_name', 'patient_phone', 'patient_email', 'department_id', 'notes', 'appointment_date', 'appointment_time', 'available_times', 'selectedDoctor', 'doctor_id']);
            $this->dispatch('reset-calendar');
        });
    }

    public function render()
    {
        return view('livewire.book-appointment')
            ->layout('layouts.app', ['title' => 'Book Appointment']);
    }
}
