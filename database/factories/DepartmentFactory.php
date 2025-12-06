<?php

namespace Database\Factories;

use App\Models\Establishment;
use Illuminate\Database\Eloquent\Factories\Factory;

class DepartmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'establishment_id' => Establishment::factory(),
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
        ];
    }
}
