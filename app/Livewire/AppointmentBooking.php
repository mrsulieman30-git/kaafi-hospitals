<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Doctor;
use App\Models\Department;
use App\Models\Appointment;
use App\Models\AppointmentSlot;
use Carbon\Carbon;

class AppointmentBooking extends Component
{
    public $step = 1;
    
    public $department_id = null;
    public $doctor_id = null;
    
    public $patient_name = '';
    public $patient_phone = '';
    public $patient_email = '';
    public $notes = '';
    
    public $selectedDate = null;
    public $selectedTime = null;

    public $currentMonth;
    public $currentYear;
    
    public function mount()
    {
        $this->currentMonth = date('m');
        $this->currentYear = date('Y');
    }

    public function selectDoctor($id)
    {
        $this->doctor_id = $id;
        $doctor = Doctor::find($id);
        if($doctor) $this->department_id = $doctor->department_id;
    }

    public function nextStep()
    {
        if ($this->step === 1 && !$this->doctor_id) {
            $this->addError('doctor_id', 'Please select a doctor.');
            return;
        }
        
        if ($this->step === 2) {
            $this->validate([
                'patient_name' => 'required|min:3',
                'patient_phone' => 'required',
                'department_id' => 'required',
            ]);
        }
        
        if ($this->step === 3 && (!$this->selectedDate || !$this->selectedTime)) {
            $this->addError('selectedTime', 'Please select a date and time slot.');
            return;
        }
        
        if ($this->step === 3) {
            $this->submitAppointment();
            $this->step = 4;
            return;
        }
        
        $this->step++;
    }

    public function prevStep()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }
    
    public function selectDate($date)
    {
        $this->selectedDate = $date;
        $this->selectedTime = null;
    }
    
    public function selectTime($time)
    {
        $this->selectedTime = $time;
    }

    public function submitAppointment()
    {
        Appointment::create([
            'patient_name' => $this->patient_name,
            'patient_email' => $this->patient_email,
            'patient_phone' => $this->patient_phone,
            'department_id' => $this->department_id,
            'doctor_id' => $this->doctor_id,
            'appointment_date' => $this->selectedDate,
            'appointment_time' => $this->selectedTime,
            'notes' => $this->notes,
            'status' => 'pending'
        ]);
    }

    public function render()
    {
        $doctors = Doctor::with('department')->where('is_active', true)->get();
        $departments = Department::where('is_active', true)->get();
        
        // Mock calendar generation
        $daysInMonth = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1)->daysInMonth;
        $firstDayOfWeek = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1)->dayOfWeek;
        
        // Mock available slots
        $availableSlots = ['09:00 AM', '09:30 AM', '10:00 AM', '10:30 AM', '11:00 AM', '11:30 AM', '12:00 PM', '12:30 PM', '02:00 PM', '02:30 PM', '03:00 PM', '03:30 PM', '04:00 PM', '04:30 PM'];
        
        return view('livewire.appointment-booking', [
            'doctors' => $doctors,
            'departments' => $departments,
            'daysInMonth' => $daysInMonth,
            'firstDayOfWeek' => $firstDayOfWeek,
            'availableSlots' => $availableSlots
        ]);
    }
}