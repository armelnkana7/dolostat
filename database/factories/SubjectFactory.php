<?php

namespace Database\Factories;

use App\Models\Establishment;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubjectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'establishment_id' => Establishment::factory(),
            'name' => $this->faker->word(),
            'code' => strtoupper($this->faker->unique()->lexify('???')),
            'description' => $this->faker->sentence(),
        ];
    }
}
