<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'name' => $this->faker->sentence($nbWords = 2, $variableNbWords = false),
            'description' => $this->faker->text(100),
            'completed' => $this->faker->boolean,
            'tag' => $this->faker->randomElement(['TAG1', 'TAG2', 'TAG3']),
            'created_at' => $this->faker->dateTimeBetween('-1 years', 'now', 'America/Sao_Paulo'),
        ];
    }
}
