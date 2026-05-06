<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Exception;

class AppointmentService
{
    /**
     * Book a new appointment safely using database transactions.
     *
     * @param array $data
     * @return Appointment
     * @throws Exception
     */
    public function bookAppointment(array $data): Appointment
    {
        return DB::transaction(function () use ($data) {
            // 1. Format the phone number to ensure the country code is linked
            $rawPhone = $data['phone'];
            $formattedPhone = $rawPhone;
            
            if (str_starts_with($rawPhone, '0')) {
                // Assuming +249 for the local country code configuration
                $formattedPhone = '+249' . substr($rawPhone, 1);
            }

            // 2. Find or create the Patient User Account
            $patient = User::where('phone', $formattedPhone)->orWhere('email', $data['email'])->first();

            if (!$patient) {
                // Auto-generate password using the raw phone number (e.g., 0908854328)
                $patient = User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'phone' => $formattedPhone,
                    'password' => Hash::make($rawPhone),
                ]);
                
                // Assign a patient role if you are using Spatie Permission
                if (class_exists(\Spatie\Permission\Models\Role::class)) {
                    // Updated to capitalized 'Patient' to match the database records
                    $patient->assignRole('Patient');
                }
            }

            // 3. Prevent Double Booking
            $existingAppointment = Appointment::where('doctor_id', $data['doctor_id'])
                ->where('appointment_date', $data['appointment_date'])
                ->where('appointment_time', $data['appointment_time'])
                ->whereIn('status', ['pending', 'confirmed'])
                ->lockForUpdate() // Locks the row during this transaction
                ->first();

            if ($existingAppointment) {
                throw new Exception('This time slot has just been booked by someone else. Please select another time.');
            }

            // 4. Create the Appointment
            $appointment = Appointment::create([
                'user_id' => $patient->id,
                'department_id' => $data['department_id'],
                'doctor_id' => $data['doctor_id'],
                'appointment_date' => $data['appointment_date'],
                'appointment_time' => $data['appointment_time'],
                'status' => 'pending',
                'notes' => $data['notes'] ?? null,
            ]);

            return $appointment;
        });
    }

    /**
     * Get available time slots for a specific doctor on a specific date.
     *
     * @param int $doctorId
     * @param string $date
     * @return array
     */
    public function getAvailableSlots(int $doctorId, string $date): array
    {
        // This is a placeholder for your specific schedule logic.
        // You would typically query the DoctorSchedule model here and subtract booked Appointments.
        
        $bookedTimes = Appointment::where('doctor_id', $doctorId)
            ->where('appointment_date', $date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->pluck('appointment_time')
            ->toArray();

        // Example slots (you will replace this with DoctorSchedule logic)
        $allSlots = ['09:00:00', '09:30:00', '10:00:00', '10:30:00', '11:00:00', '14:00:00', '14:30:00'];

        return array_diff($allSlots, $bookedTimes);
    }
}
