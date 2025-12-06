<?php

namespace Database\Factories;

use App\Models\Establishment;
use App\Models\SchoolClass;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProgramFactory extends Factory
{
    public function definition(): array
    {
        $establishment = Establishment::factory();

        return [
            'establishment_id' => $establishment,
            'classe_id' => SchoolClass::factory()->for($establishment),
            'subject_id' => Subject::factory()->for($establishment),
            'hours_per_week' => $this->faker->numberBetween(1, 6),
            'description' => $this->faker->sentence(),
        ];
    }
}
