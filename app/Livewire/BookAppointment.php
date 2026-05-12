<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BookAppointment extends Component
{
    public $doctors;
    
    // Form Fields
    public $doctor_id = '';
    public $patient_name = '';
    public $patient_phone = '';
    public $appointment_date = '';
    public $appointment_time = '';
    public $available_times = [];
    public $allowed_days = [];
    
    public $successMessage = '';

    /**
     * Mount the component.
     * The $doctor parameter comes from the route /book-appointment/{doctor?}
     */
    public function mount($doctor = null)
    {
        $this->doctors = Doctor::where('is_active', true)->with('department')->get();
        
        // Try to get the doctor ID from the route parameter
        $doctorId = null;
        
        if ($doctor) {
            if ($doctor instanceof Doctor) {
                $doctorId = $doctor->id;
            } elseif (is_numeric($doctor)) {
                $doctorId = (int) $doctor;
            } else {
                $found = Doctor::where('slug', $doctor)->first();
                if ($found) {
                    $doctorId = $found->id;
                }
            }
        }
        
        // Fallback: check the route parameter directly
        if (!$doctorId) {
            $routeParam = request()->route('doctor');
            if ($routeParam) {
                if ($routeParam instanceof Doctor) {
                    $doctorId = $routeParam->id;
                } elseif (is_numeric($routeParam)) {
                    $doctorId = (int) $routeParam;
                }
            }
        }
        
        if ($doctorId) {
            $this->doctor_id = (string) $doctorId;
            $this->loadDoctorSchedule();
        }
    }

    public function selectDate($dateStr)
    {
        $this->appointment_date = $dateStr;
        $this->appointment_time = '';
        $this->loadTimeSlotsForDate();
    }

    /**
     * When the user changes the doctor dropdown.
     */
    public function updatedDoctorId()
    {
        // Reset date and time when doctor changes
        $this->appointment_date = '';
        $this->appointment_time = '';
        $this->available_times = [];
        $this->loadDoctorSchedule();
    }


    /**
     * When the user picks a date from the calendar (fallback if set() works).
     */
    public function updatedAppointmentDate()
    {
        $this->appointment_time = '';
        $this->loadTimeSlotsForDate();
    }

    /**
     * Load the doctor's working days so the calendar knows which days to enable.
     */
    private function loadDoctorSchedule()
    {
        $this->allowed_days = [];

        if (empty($this->doctor_id)) {
            $this->dispatch('allowed-days-updated', $this->allowed_days);
            return;
        }

        $doctor = Doctor::find($this->doctor_id);
        if (!$doctor) {
            $this->dispatch('allowed-days-updated', $this->allowed_days);
            return;
        }

        $schedules = $doctor->schedules()->where('is_active', true)->get();
        
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

        $this->dispatch('allowed-days-updated', $this->allowed_days);
    }

    /**
     * Load available time slots for the selected doctor + date.
     */
    private function loadTimeSlotsForDate()
    {
        $this->available_times = [];

        if (empty($this->doctor_id) || empty($this->appointment_date)) {
            return;
        }

        $doctor = Doctor::find($this->doctor_id);
        if (!$doctor) {
            return;
        }

        $this->available_times = $doctor->getAvailableTimeSlots($this->appointment_date);
    }

    public function submitAppointment()
    {
        $this->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'patient_name' => 'required|string|max:255',
            'patient_phone' => 'required|string|min:9',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
        ]);

        DB::transaction(function () {
            // Format phone number to +252 exactly like the AI logic
            $rawPhone = preg_replace('/[^0-9]/', '', $this->patient_phone); 
            $rawPhone = ltrim($rawPhone, '0');
            $formattedPhone = '+252' . $rawPhone;

            $patient = User::where('phone', $formattedPhone)->first();

            // Create patient account if they don't exist, using phone without country code as password
            if (!$patient) {
                $patient = new User();
                $patient->name = $this->patient_name;
                $patient->phone = $formattedPhone;
                $patient->email = 'patient_' . uniqid() . '@kaafihospitals.so'; 
                $patient->password = Hash::make('0' . $rawPhone);
                $patient->save();

                if (class_exists(\Spatie\Permission\Models\Role::class)) {
                    $roleExists = \Spatie\Permission\Models\Role::where('name', 'Patient')->exists();
                    if ($roleExists) {
                        $patient->assignRole('Patient');
                    }
                }
            }

            $doctor = Doctor::find($this->doctor_id);

            // Create Appointment
            $appointment = new Appointment();
            $appointment->user_id = $patient->id;
            $appointment->department_id = $doctor->department_id ?? null;
            $appointment->doctor_id = $doctor->id;
            $appointment->appointment_date = $this->appointment_date;
            $appointment->appointment_time = Carbon::parse($this->appointment_time)->format('H:i:s');
            $appointment->status = 'pending';
            $appointment->notes = 'Booked via Web Form';
            $appointment->save();

            $this->successMessage = "Appointment requested successfully! You can track it in the Patient Portal. Username: 0{$rawPhone} | Password: 0{$rawPhone}";
            
            // Reset form
            $this->reset(['patient_name', 'patient_phone', 'appointment_date', 'appointment_time']);
        });
    }

    public function render()
    {
        return view('livewire.book-appointment')->layout('layouts.app');
    }
}
