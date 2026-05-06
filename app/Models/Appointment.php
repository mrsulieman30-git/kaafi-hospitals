<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentStatusUpdate;

class Appointment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * The "booted" method of the model.
     * This acts as an observer for model events.
     */
    protected static function booted(): void
    {
        static::updated(function (Appointment $appointment) {
            // Check if the 'status' column specifically was changed
            if ($appointment->isDirty('status')) {
                
                // 1. Send an in-app Database Notification to the Patient
                Notification::make()
                    ->title('Appointment ' . ucfirst($appointment->status))
                    ->body("Your consultation with {$appointment->doctor->name} has been marked as {$appointment->status}.")
                    ->icon(match($appointment->status) {
                        'approved' => 'heroicon-o-check-circle',
                        'cancelled' => 'heroicon-o-x-circle',
                        'completed' => 'heroicon-o-star',
                        default => 'heroicon-o-information-circle',
                    })
                    ->iconColor(match($appointment->status) {
                        'approved' => 'success',
                        'cancelled' => 'danger',
                        'completed' => 'info',
                        default => 'warning',
                    })
                    ->sendToDatabase($appointment->user);

                // 2. Send an Email Notification
                if (!empty($appointment->user->email)) {
                    Mail::to($appointment->user->email)->send(new AppointmentStatusUpdate($appointment));
                }
            }
        });
    }
}