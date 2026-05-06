<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Doctor;
use App\Models\Department;
use App\Models\Appointment;
use App\Models\DoctorSchedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AppointmentBooking extends Component
{
    public $step = 1;

    // Step 1
    public $doctor_id;

    // Step 2
    public $patient_name;
    public $patient_phone;
    public $patient_email;
    public $department_id;
    public $notes;

    // Step 3
    public $currentYear;
    public $currentMonth;
    public $daysInMonth;
    public $firstDayOfWeek;
    public $selectedDate;
    public $selectedTime;
    public $availableSlots = [];

    public function mount()
    {
        $this->currentYear = now()->year;
        $this->currentMonth = now()->month;
        $this->updateCalendar();
    }

    public function updateCalendar()
    {
        $date = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1);
        $this->daysInMonth = $date->daysInMonth;
        $this->firstDayOfWeek = $date->dayOfWeekIso; // 1 = Monday, 7 = Sunday
    }

    public function selectDoctor($id)
    {
        $this->doctor_id = $id;
        $doctor = Doctor::find($id);
        if ($doctor) {
            $this->department_id = $doctor->department_id;
        }
        $this->nextStep();
    }

    public function nextMonth()
    {
        $date = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1)->addMonth();
        $this->currentYear = $date->year;
        $this->currentMonth = $date->month;
        $this->updateCalendar();
        $this->selectedDate = null;
        $this->availableSlots = [];
    }

    public function prevMonth()
    {
        $date = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1)->subMonth();
        // Prevent navigating to past months
        if ($date->isBefore(now()->startOfMonth())) return;
        
        $this->currentYear = $date->year;
        $this->currentMonth = $date->month;
        $this->updateCalendar();
        $this->selectedDate = null;
        $this->availableSlots = [];
    }

    public function selectDate($dateStr)
    {
        $this->selectedDate = $dateStr;
        $this->selectedTime = null;
        $this->calculateSlots();
    }

    public function selectTime($timeStr)
    {
        $this->selectedTime = $timeStr;
    }

    public function calculateSlots()
    {
        $this->availableSlots = [];
        if (!$this->selectedDate || !$this->doctor_id) return;

        $date = Carbon::parse($this->selectedDate);
        $dayName = $date->format('l'); // e.g., 'Monday'

        $schedules = DoctorSchedule::where('doctor_id', $this->doctor_id)
            ->where('is_active', true)
            ->get();

        $activeSchedule = null;
        foreach ($schedules as $schedule) {
            $days = is_array($schedule->day_of_week) ? $schedule->day_of_week : [$schedule->day_of_week];
            if (in_array($dayName, $days)) {
                $activeSchedule = $schedule;
                break;
            }
        }

        // If the doctor isn't scheduled to work this day, return empty slots
        if (!$activeSchedule) return; 

        $startTime = Carbon::parse($activeSchedule->start_time);
        $endTime = Carbon::parse($activeSchedule->end_time);

        // Fetch already booked times for this doctor on this day
        $bookedAppointments = Appointment::where('doctor_id', $this->doctor_id)
            ->whereDate('appointment_date', $this->selectedDate)
            ->whereIn('status', ['pending', 'approved', 'completed'])
            ->pluck('appointment_time')
            ->map(fn($time) => Carbon::parse($time)->format('H:i'))
            ->toArray();

        $slots = [];
        while ($startTime->lessThan($endTime)) {
            $timeString = $startTime->format('H:i');
            
            // Check if the slot is available
            if (!in_array($timeString, $bookedAppointments)) {
                // If the selected date is today, hide times that have already passed
                if (!($date->isToday() && $startTime->isPast())) {
                    $slots[] = $startTime->format('h:i A'); // 12-hour format for UI
                }
            }
            $startTime->addMinutes(30); // Generate slots in 30-minute intervals
        }
        $this->availableSlots = $slots;
    }

    public function nextStep()
    {
        if ($this->step === 2) {
            $this->validate([
                'patient_name' => 'required|string|max:255',
                'patient_phone' => 'required|string|max:255',
                'department_id' => 'required|exists:departments,id',
            ]);
        }

        if ($this->step === 3) {
            $this->validate([
                'selectedDate' => 'required|date',
                'selectedTime' => 'required|string',
            ]);
            
            $this->confirmBooking();
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

    public function confirmBooking()
    {
        DB::transaction(function () {
            $rawPhone = $this->patient_phone;
            $formattedPhone = $rawPhone;
            if (str_starts_with($rawPhone, '0')) {
                $formattedPhone = '+252' . substr($rawPhone, 1);
            }

            $patient = User::where('phone', $formattedPhone)->orWhere('email', $this->patient_email)->first();

            if (!$patient) {
                $patient = User::create([
                    'name' => $this->patient_name,
                    'email' => $this->patient_email,
                    'phone' => $formattedPhone,
                    'password' => Hash::make($rawPhone),
                ]);
                if (class_exists(\Spatie\Permission\Models\Role::class)) {
                    $patient->assignRole('Patient');
                }
            }

            // Convert 12-hour AM/PM back to 24-hour for the database
            $dbTime = Carbon::parse($this->selectedTime)->format('H:i:s');

            Appointment::create([
                'user_id' => $patient->id,
                'department_id' => $this->department_id,
                'doctor_id' => $this->doctor_id,
                'appointment_date' => $this->selectedDate,
                'appointment_time' => $dbTime,
                'status' => 'pending',
                'notes' => $this->notes,
            ]);
        });

        $this->step = 4; // Move to Success Page
    }

    public function render()
    {
        return view('livewire.appointment-booking', [
            'doctors' => Doctor::where('is_active', true)->with('department')->get(),
            'departments' => Department::where('is_active', true)->get(),
        ]);
    }
}