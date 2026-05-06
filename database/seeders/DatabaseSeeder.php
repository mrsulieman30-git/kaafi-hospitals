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
        $patientRole = Role::create(['name' => 'Patient']); // Added missing Patient role

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
        $images = [
            'https://images.pexels.com/photos/5215024/pexels-photo-5215024.jpeg?auto=compress&cs=tinysrgb&w=800',
            'https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'https://images.pexels.com/photos/5327656/pexels-photo-5327656.jpeg?auto=compress&cs=tinysrgb&w=800',
            'https://images.unsplash.com/photo-1537368910025-700350fe46c7?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
        ];

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
                'title' => ['en' => 'Laboratory Manager', 'so' => 'Maamulaha Shaybaarka'],
                'phone' => '+252 61 000 0008',
            ]
        ];

        foreach ($doctors as $index => $docData) {
            $docData['image_url'] = $images[$index % count($images)];
            Doctor::create($docData);
        }

        // 5. Blog Posts
        $this->call(MedicalPostSeeder::class);
    }
}
