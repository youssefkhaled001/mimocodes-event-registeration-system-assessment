<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'description' => fake()->text(500),
            'location' => fake()->city().', '.fake()->country(),
            'capacity' => fake()->numberBetween(10, 1000),
            'price' => fake()->randomFloat(2, 10, 1000),
            'date_time' => fake()->dateTimeBetween('+1 week', '+3 months'),
            'status' => fake()->randomElement(['published', 'draft', 'cancelled', 'completed']),
        ];
    }
}
