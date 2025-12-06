<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * RolesSeeder
 * 
 * This seeder creates basic roles for the application.
 */
class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'superadmin', 'guard_name' => 'web', 'description' => 'Super Administrator'],
            ['name' => 'admin', 'guard_name' => 'web', 'description' => 'Administrator'],
            ['name' => 'censeur', 'guard_name' => 'web', 'description' => 'Censeur'],
            ['name' => 'animateur_pedagogique', 'guard_name' => 'web', 'description' => 'Animateur Pédagogique']
        ];

        foreach ($roles as $role) {
            \App\Models\Role::firstOrCreate(
                ['name' => $role['name']],
                ['guard_name' => $role['guard_name']],
                ['description' => $role['description']]
            );
        }

        $this->command->info('Roles seeded successfully!');
    }
}
