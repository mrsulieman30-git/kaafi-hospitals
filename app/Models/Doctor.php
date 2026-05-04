<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Doctor extends Model
{
    use HasTranslations;

    protected $guarded = [];
    public $translatable = ['name', 'title', 'bio'];

    public function user() { return $this->belongsTo(User::class); }
    public function department() { return $this->belongsTo(Department::class); }
    public function schedules() { return $this->hasMany(DoctorSchedule::class); }
    public function appointmentSlots() { return $this->hasMany(AppointmentSlot::class); }
    public function appointments() { return $this->hasMany(Appointment::class); }
}