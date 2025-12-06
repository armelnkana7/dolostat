<?php

namespace Database\Factories;

use App\Models\Establishment;
use Illuminate\Database\Eloquent\Factories\Factory;

class AcademicYearFactory extends Factory
{
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-1 year', 'now');

        return [
            'establishment_id' => Establishment::factory(),
            'title' => $this->faker->numerify('####-####'),
            'start_date' => $startDate,
            'end_date' => (clone $startDate)->modify('+9 months'),
            'is_active' => false,
        ];
    }

    public function active(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => true,
        ]);
    }
}
