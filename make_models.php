<?php

$models = [
    'User.php' => <<<'EOT'
<?php
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
EOT,

    'Doctor.php' => <<<'EOT'
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
EOT,

    'Department.php' => <<<'EOT'
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
EOT,

    'Appointment.php' => <<<'EOT'
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $guarded = [];

    public function user() { return $this->belongsTo(User::class); }
    public function department() { return $this->belongsTo(Department::class); }
    public function doctor() { return $this->belongsTo(Doctor::class); }
}
EOT,

    'BlogPost.php' => <<<'EOT'
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class BlogPost extends Model
{
    use HasTranslations;

    protected $guarded = [];
    public $translatable = ['title', 'content'];
    
    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function category() { return $this->belongsTo(BlogCategory::class, 'blog_category_id'); }
    public function user() { return $this->belongsTo(User::class); }
    public function comments() { return $this->hasMany(BlogComment::class); }
}
EOT,

    'BlogCategory.php' => <<<'EOT'
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class BlogCategory extends Model
{
    use HasTranslations;

    protected $guarded = [];
    public $translatable = ['name'];

    public function posts() { return $this->hasMany(BlogPost::class); }
}
EOT,

    'BlogComment.php' => <<<'EOT'
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    protected $guarded = [];

    public function post() { return $this->belongsTo(BlogPost::class, 'blog_post_id'); }
}
EOT,

    'Page.php' => <<<'EOT'
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Page extends Model
{
    use HasTranslations;

    protected $guarded = [];
    public $translatable = ['title', 'content'];
}
EOT,

    'Setting.php' => <<<'EOT'
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $guarded = [];
    
    protected $casts = [
        'value' => 'json',
    ];
}
EOT,

    'AiConversation.php' => <<<'EOT'
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiConversation extends Model
{
    protected $guarded = [];

    public function user() { return $this->belongsTo(User::class); }
}
EOT,

    'DoctorSchedule.php' => <<<'EOT'
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorSchedule extends Model
{
    protected $guarded = [];

    public function doctor() { return $this->belongsTo(Doctor::class); }
}
EOT,

    'AppointmentSlot.php' => <<<'EOT'
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentSlot extends Model
{
    protected $guarded = [];
    
    protected $casts = [
        'date' => 'date',
    ];

    public function doctor() { return $this->belongsTo(Doctor::class); }
}
EOT,
];

foreach ($models as $file => $content) {
    file_put_contents(__DIR__ . '/app/Models/' . $file, $content);
}
echo "Models updated successfully.\n";
