<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * PermissionsSeeder
 * 
 * Requires: composer require spatie/laravel-permission
 * 
 * This seeder creates permissions and roles using spatie/laravel-permission.
 * It also creates standard roles (superadmin, admin, censeur, animateur_pedagogique).
 */
class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if spatie/laravel-permission is installed
        if (!class_exists(\Spatie\Permission\Models\Permission::class)) {
            $this->command->warn('spatie/laravel-permission is not installed. Skipping PermissionsSeeder.');
            return;
        }

        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Establishments
            'establishment.view',
            'establishment.create',
            'establishment.update',
            'establishment.delete',

            // Academic Years
            'academic_year.view',
            'academic_year.create',
            'academic_year.update',
            'academic_year.delete',

            // Departments
            'department.view',
            'department.create',
            'department.update',
            'department.delete',

            // Classes
            'class.view',
            'class.create',
            'class.update',
            'class.delete',

            // Subjects
            'subject.view',
            'subject.create',
            'subject.update',
            'subject.delete',

            // Programs
            'program.view',
            'program.create',
            'program.update',
            'program.delete',

            // Users
            'user.view',
            'user.create',
            'user.update',
            'user.delete',

            // Reports
            'report.view',
            'report.export',
            'report.pdf',
            'report.excel',

            // Audit
            'audit.view',
        ];

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $superadmin = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'superadmin']);
        $admin = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin']);
        $censeur = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'censeur']);
        $pedagogical = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'animateur_pedagogique']);

        // Assign all permissions to superadmin
        $superadmin->syncPermissions($permissions);

        // Assign admin permissions
        $adminPermissions = [
            'establishment.view',
            'academic_year.view',
            'academic_year.create',
            'academic_year.update',
            'department.view',
            'department.create',
            'department.update',
            'class.view',
            'class.create',
            'class.update',
            'subject.view',
            'subject.create',
            'subject.update',
            'program.view',
            'program.create',
            'program.update',
            'user.view',
            'user.create',
            'user.update',
            'report.view',
            'report.export',
            'report.pdf',
            'report.excel',
        ];
        $admin->syncPermissions($adminPermissions);

        // Assign censeur permissions
        $censeurPermissions = [
            'class.view',
            'subject.view',
            'program.view',
            'user.view',
            'report.view',
            'report.export',
            'report.pdf',
        ];
        $censeur->syncPermissions($censeurPermissions);

        // Assign pedagogical animator permissions
        $pedagogicalPermissions = [
            'class.view',
            'subject.view',
            'program.view',
            'report.view',
        ];
        $pedagogical->syncPermissions($pedagogicalPermissions);

        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $this->command->info('Permissions and roles seeded successfully!');
    }
}
