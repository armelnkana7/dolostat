<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Establishment;
use App\Models\AcademicYear;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create establishment
        $establishment = Establishment::factory()->create([
            'code' => 'EST001',
            'name' => 'Établissement Principal',
        ]);

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $censorRole = Role::firstOrCreate(['name' => 'censor', 'guard_name' => 'web']);
        $animatorRole = Role::firstOrCreate(['name' => 'animator', 'guard_name' => 'web']);

        // Create academic year
        $academicYear = AcademicYear::firstOrCreate(
            ['establishment_id' => $establishment->id, 'title' => '2024-2025'],
            [
                'start_date' => '2024-09-01',
                'end_date' => '2025-06-30',
                'is_active' => true,
            ]
        );

        // Create department
        $department = Department::firstOrCreate(
            ['establishment_id' => $establishment->id, 'name' => 'Département Généraliste'],
            ['description' => 'Département généraliste']
        );

        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@dolostat.test'],
            [
                'name' => 'Administrateur Système',
                'username' => 'admin',
                'password' => Hash::make('password123'),
                'establishment_id' => $establishment->id,
                'academic_year_id' => $academicYear->id,
            ]
        );
        $admin->assignRole($adminRole);

        // Create censor user
        $censor = User::firstOrCreate(
            ['email' => 'censor@dolostat.test'],
            [
                'name' => 'Censeur Pédagogique',
                'username' => 'censor',
                'password' => Hash::make('password123'),
                'establishment_id' => $establishment->id,
                'academic_year_id' => $academicYear->id,
            ]
        );
        $censor->assignRole($censorRole);

        // Create animator user
        $animator = User::firstOrCreate(
            ['email' => 'animator@dolostat.test'],
            [
                'name' => 'Animateur Département',
                'username' => 'animator',
                'password' => Hash::make('password123'),
                'establishment_id' => $establishment->id,
                'academic_year_id' => $academicYear->id,
                'department_id' => $department->id,
            ]
        );
        $animator->assignRole($animatorRole);
    }
}
