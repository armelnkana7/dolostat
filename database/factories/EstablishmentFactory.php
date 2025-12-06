<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EstablishmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'code' => strtoupper($this->faker->unique()->lexify('???###')),
            'address' => $this->faker->address(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'meta' => [],
        ];
    }
}
