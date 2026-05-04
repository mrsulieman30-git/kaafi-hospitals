<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Department extends Model
{
    use HasTranslations;

    protected $guarded = [];
    public $translatable = ['name', 'description'];

    public function doctors() { return $this->hasMany(Doctor::class); }
    public function appointments() { return $this->hasMany(Appointment::class); }
}