<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Department;
use App\Models\Doctor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Roles
        $superAdmin = Role::create(['name' => 'Super Admin']);
        $receptionist = Role::create(['name' => 'Receptionist']);
        $doctorRole = Role::create(['name' => 'Doctor']);

        // 2. Users
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@kaafihospitals.so',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('Super Admin');

        // 3. Departments
        $cardiology = Department::create([
            'name' => ['en' => 'Cardiology', 'so' => 'Cudurada Wadnaha'],
            'slug' => 'cardiology',
            'description' => ['en' => 'Heart and cardiovascular care.', 'so' => 'Daryeelka wadnaha iyo xididdada dhiigga.'],
        ]);
        
        $pediatrics = Department::create([
            'name' => ['en' => 'Pediatrics', 'so' => 'Carruurta'],
            'slug' => 'pediatrics',
            'description' => ['en' => 'Child healthcare.', 'so' => 'Daryeelka caafimaadka carruurta.'],
        ]);

        $neurology = Department::create([
            'name' => ['en' => 'Neurology', 'so' => 'Neerfaha'],
            'slug' => 'neurology',
            'description' => ['en' => 'Brain and nervous system.', 'so' => 'Maskaxda iyo hab-dhiska neerfaha.'],
        ]);
        
        $general = Department::create([
            'name' => ['en' => 'General Medicine', 'so' => 'Cudurada Guud'],
            'slug' => 'general-medicine',
            'description' => ['en' => 'Primary care.', 'so' => 'Daryeelka aasaasiga ah.'],
        ]);

        $laboratory = Department::create([
            'name' => ['en' => 'Laboratory & Diagnostics', 'so' => 'Shaybaarka'],
            'slug' => 'laboratory',
            'description' => ['en' => 'Advanced diagnostics.', 'so' => 'Baaritaanada casriga ah.'],
        ]);

        // 4. Doctors
        $doctors = [
            [
                'department_id' => $cardiology->id,
                'name' => ['en' => 'Dr. Ahmed Khan', 'so' => 'Dr. Axmed Khaan'],
                'slug' => 'dr-ahmed-khan',
                'title' => ['en' => 'Consultant Cardiologist', 'so' => 'Dhakhtarka Wadnaha'],
                'phone' => '+252 61 000 0001',
            ],
            [
                'department_id' => $general->id,
                'name' => ['en' => 'Dr. Sara Mahmood', 'so' => 'Dr. Saara Maxamuud'],
                'slug' => 'dr-sara-mahmood',
                'title' => ['en' => 'General Physician', 'so' => 'Dhakhtarka Guud'],
                'phone' => '+252 61 000 0002',
            ],
            [
                'department_id' => $neurology->id,
                'name' => ['en' => 'Dr. Usman Ali', 'so' => 'Dr. Cismaan Cali'],
                'slug' => 'dr-usman-ali',
                'title' => ['en' => 'Neurologist', 'so' => 'Dhakhtarka Neerfaha'],
                'phone' => '+252 61 000 0003',
            ],
            [
                'department_id' => $pediatrics->id,
                'name' => ['en' => 'Dr. Ayesha Malik', 'so' => 'Dr. Caasho Maalik'],
                'slug' => 'dr-ayesha-malik',
                'title' => ['en' => 'Pediatrician', 'so' => 'Dhakhtarka Carruurta'],
                'phone' => '+252 61 000 0004',
            ],
            [
                'department_id' => $general->id,
                'name' => ['en' => 'Dr. Imran Ahmed', 'so' => 'Dr. Cimraan Axmed'],
                'slug' => 'dr-imran-ahmed',
                'title' => ['en' => 'Orthopedics', 'so' => 'Dhakhtarka Lafaha'],
                'phone' => '+252 61 000 0005',
            ],
            [
                'department_id' => $general->id,
                'name' => ['en' => 'Dr. Hira Fatima', 'so' => 'Dr. Xiira Faadumo'],
                'slug' => 'dr-hira-fatima',
                'title' => ['en' => 'Dermatologist', 'so' => 'Dhakhtarka Maqaarka'],
                'phone' => '+252 61 000 0006',
            ],
            [
                'department_id' => $cardiology->id,
                'name' => ['en' => 'Dr. Bilal Raza', 'so' => 'Dr. Bilaal Risa'],
                'slug' => 'dr-bilal-raza',
                'title' => ['en' => 'Cardiologist', 'so' => 'Dhakhtarka Wadnaha'],
                'phone' => '+252 61 000 0007',
            ],
            [
                'department_id' => $laboratory->id,
                'name' => ['en' => 'Mohammad Sulieman', 'so' => 'Maxamed Suleymaan'],
                'slug' => 'mohammad-sulieman',
                'title' => ['en' => 'Laboratory Manager (Sudan)', 'so' => 'Maamulaha Shaybaarka'],
                'phone' => '+252 61 000 0008',
            ]
        ];

        foreach ($doctors as $docData) {
            Doctor::create($docData);
        }
    }
}
