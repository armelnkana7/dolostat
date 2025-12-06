<?php

namespace Database\Factories;

use App\Models\Program;
use App\Models\User;
use App\Models\Establishment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WeeklyCoverageReport>
 */
class WeeklyCoverageReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'establishment_id' => Establishment::factory(),
            'program_id' => Program::factory(),
            'recorded_by_user_id' => User::factory(),
            'nbr_hours_done' => $this->faker->numberBetween(0, 20),
            'nbr_lesson_done' => $this->faker->numberBetween(0, 30),
            'nbr_lesson_dig_done' => $this->faker->numberBetween(0, 15),
            'nbr_tp_done' => $this->faker->numberBetween(0, 10),
            'nbr_tp_dig_done' => $this->faker->numberBetween(0, 8),
        ];
    }
}
