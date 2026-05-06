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
    
    public $successMessage = '';

    public function mount($doctor = null)
    {
        $this->doctors = Doctor::where('is_active', true)->with('department')->get();
        
        // Auto-select the doctor if they clicked the button from the grid!
        if ($doctor) {
            $this->doctor_id = $doctor;
        }
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
