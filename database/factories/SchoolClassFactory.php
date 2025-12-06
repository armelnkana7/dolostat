<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Establishment;
use Illuminate\Database\Eloquent\Factories\Factory;

class SchoolClassFactory extends Factory
{
    public function definition(): array
    {
        $establishment = Establishment::factory();

        return [
            'establishment_id' => $establishment,
            'department_id' => Department::factory()->for($establishment),
            'name' => $this->faker->word(),
            'level' => $this->faker->randomElement(['1ère', '2e', '3e', '4e', '5e', '6e']),
            'description' => $this->faker->sentence(),
        ];
    }
}
