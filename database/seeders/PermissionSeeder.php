<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            // Establishment permissions
            'view_establishments',
            'create_establishments',
            'edit_establishments',
            'delete_establishments',

            // Academic Year permissions
            'view_academic_years',
            'create_academic_years',
            'edit_academic_years',
            'delete_academic_years',

            // Department permissions
            'view_departments',
            'create_departments',
            'edit_departments',
            'delete_departments',

            // School Class permissions
            'view_classes',
            'create_classes',
            'edit_classes',
            'delete_classes',

            // Subject permissions
            'view_subjects',
            'create_subjects',
            'edit_subjects',
            'delete_subjects',

            // Program permissions
            'view_programs',
            'create_programs',
            'edit_programs',
            'delete_programs',
            'manage_programs',

            // User permissions
            'view_users',
            'create_users',
            'edit_users',
            'delete_users',

            // Coverage & Reports permissions
            'view_coverage',
            'create_coverage',
            'edit_coverage',
            'delete_coverage',
            'view_reports',
            'export_reports',

            // Role & Permission management
            'manage_roles',
            'manage_permissions',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create roles
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $censor = Role::firstOrCreate(['name' => 'censor', 'guard_name' => 'web']);
        $animator = Role::firstOrCreate(['name' => 'animator', 'guard_name' => 'web']);

        // Assign all permissions to admin
        $admin->syncPermissions(Permission::all());

        // Assign permissions to censor (supervisory role)
        $censorPermissions = [
            'view_establishments',
            'view_academic_years',
            'view_departments',
            'view_classes',
            'create_classes',
            'edit_classes',
            'view_subjects',
            'create_subjects',
            'edit_subjects',
            'view_programs',
            'create_programs',
            'edit_programs',
            'manage_programs',
            'view_users',
            'create_users',
            'edit_users',
            'view_coverage',
            'create_coverage',
            'edit_coverage',
            'delete_coverage',
            'view_reports',
            'export_reports',
        ];
        $censor->syncPermissions(
            Permission::whereIn('name', $censorPermissions)->get()
        );

        // Assign permissions to animator (department-level role)
        $animatorPermissions = [
            'view_classes',
            'view_subjects',
            'view_programs',
            'manage_programs',
            'view_coverage',
            'create_coverage',
            'edit_coverage',
            'view_reports',
            'export_reports',
        ];
        $animator->syncPermissions(
            Permission::whereIn('name', $animatorPermissions)->get()
        );
    }
}
