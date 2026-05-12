<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;
use Carbon\Carbon;

class Doctor extends Model
{
    use HasTranslations;

    public $translatable = ['name', 'bio', 'title'];
    protected $guarded = [];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(DoctorSchedule::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    // Bulletproof Accessor for Name
    public function getLocalizedNameAttribute()
    {
        $locale = app()->getLocale();
        $raw = $this->getAttributes()['name'] ?? '';
        
        if (is_string($raw) && str_starts_with(trim($raw), '{')) {
            $decoded = json_decode($raw, true);
            $value = $decoded[$locale] ?? ($decoded['en'] ?? $raw);
            // Catch nested corrupted objects like [object Object]
            return is_string($value) ? $value : 'Unknown Name';
        }
        
        return $this->name ?? 'Unknown Name';
    }

    // Bulletproof Accessor for Bio
    public function getLocalizedBioAttribute()
    {
        $locale = app()->getLocale();
        $raw = $this->getAttributes()['bio'] ?? '';
        
        if (is_string($raw) && str_starts_with(trim($raw), '{')) {
            $decoded = json_decode($raw, true);
            $value = $decoded[$locale] ?? ($decoded['en'] ?? $raw);
            return is_string($value) ? $value : '';
        }
        
        return $this->bio ?? '';
    }

    // Bulletproof Accessor for Title
    public function getLocalizedTitleAttribute()
    {
        $locale = app()->getLocale();
        $raw = $this->getAttributes()['title'] ?? '';
        
        if (is_string($raw) && str_starts_with(trim($raw), '{')) {
            $decoded = json_decode($raw, true);
            $value = $decoded[$locale] ?? ($decoded['en'] ?? $raw);
            return is_string($value) ? $value : 'Specialist';
        }
        
        return $this->title ?? 'Specialist';
    }

    // SMART IMAGE HELPER: Checks for URL first, then Upload, then fallback
    public function getDisplayImageAttribute()
    {
        if (!empty($this->image_url)) {
            return $this->image_url;
        }
        
        if (!empty($this->image)) {
            return asset('storage/' . $this->image);
        }

        // Beautiful default gradient placeholder if no image exists
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->localized_name) . '&background=003B73&color=fff&size=400';
    }

    /**
     * Get available time slots for this doctor on a specific date.
     * Takes into account multiple shifts and already booked appointments.
     * 
     * @param string $date Date in Y-m-d format
     * @param int $intervalMinutes Duration of each appointment slot
     * @return array Array of available time strings (e.g. ['09:00', '09:30'])
     */
    public function getAvailableTimeSlots(string $date, int $intervalMinutes = 30): array
    {
        $targetDate = Carbon::parse($date);
        $dayOfWeek = $targetDate->format('l'); // e.g. "Sunday"

        // Find all active schedules for this doctor on this day
        // Since day_of_week is a string column containing JSON, whereJsonContains might fail
        $allSchedules = $this->schedules()->where('is_active', true)->get();
        
        $schedules = $allSchedules->filter(function ($schedule) use ($dayOfWeek) {
            $days = is_array($schedule->day_of_week) ? $schedule->day_of_week : json_decode($schedule->day_of_week, true) ?? [];
            return in_array($dayOfWeek, $days);
        });

        if ($schedules->isEmpty()) {
            return []; // No shifts on this day
        }

        // Get all booked appointments for this doctor on this date (not cancelled)
        $bookedTimes = $this->appointments()
            ->whereDate('appointment_date', $targetDate->toDateString())
            ->where('status', '!=', 'cancelled')
            ->pluck('appointment_time')
            ->map(function ($time) {
                return Carbon::parse($time)->format('H:i');
            })
            ->toArray();

        $availableSlots = [];

        foreach ($schedules as $schedule) {
            $start = Carbon::parse($schedule->start_time);
            $end = Carbon::parse($schedule->end_time);

            // Handle midnight (00:00) or cases where end <= start (overnight shift)
            // Treat 00:00 end_time as 23:59 (end of day)
            if ($end->lte($start)) {
                $end = Carbon::parse('23:59');
            }

            // Generate slots every $intervalMinutes until end time
            while ($start->lt($end)) {
                $timeString = $start->format('H:i');
                
                // Only add if not already booked AND if date is today, time must be in the future
                $isFutureIfToday = true;
                if ($targetDate->isToday()) {
                    $isFutureIfToday = $start->isAfter(Carbon::now());
                }

                if (!in_array($timeString, $bookedTimes) && $isFutureIfToday) {
                    $availableSlots[$timeString] = $timeString;
                }
                
                $start->addMinutes($intervalMinutes);
            }
        }

        // Sort just in case multiple shifts were out of order
        ksort($availableSlots);

        return $availableSlots;
    }

    /**
     * Get an array of dates (Y-m-d) in the near future where the doctor is NOT working.
     * Useful for disabling calendar dates in datepickers.
     *
     * @param int $daysAhead How many days ahead to check (default 60)
     * @return array Array of disabled date strings
     */
    public function getDisabledDatesForNextDays(int $daysAhead = 60): array
    {
        $disabledDates = [];
        $today = Carbon::today();
        
        // Find all active working days for this doctor
        $workingDays = [];
        $schedules = $this->schedules()->where('is_active', true)->get();
        foreach ($schedules as $schedule) {
            $days = is_array($schedule->day_of_week) ? $schedule->day_of_week : json_decode($schedule->day_of_week, true) ?? [];
            foreach ($days as $day) {
                if (!in_array($day, $workingDays)) {
                    $workingDays[] = $day;
                }
            }
        }

        // If no schedules exist, everything is disabled
        if (empty($workingDays)) {
            for ($i = 0; $i < $daysAhead; $i++) {
                $disabledDates[] = $today->copy()->addDays($i)->format('Y-m-d');
            }
            return $disabledDates;
        }

        // Generate dates for the next X days and check if they fall on a non-working day
        for ($i = 0; $i < $daysAhead; $i++) {
            $date = $today->copy()->addDays($i);
            if (!in_array($date->format('l'), $workingDays)) {
                $disabledDates[] = $date->format('Y-m-d');
            }
        }

        return $disabledDates;
    }
}