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
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'type' => $this->faker->randomElement(['jpo', 'salon']),
            'date' => $this->faker->dateTimeBetween('now', '+6 months'),
            'location' => $this->faker->city(),
            'subjects' => $this->faker->words(3, true),
            'requirements' => $this->faker->sentence(),
            'guides' => $this->faker->sentence(),
        ];
    }

    public function salon()
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'salon',
        ]);
    }

    public function jpo()
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'jpo',
        ]);
    }

    public function past()
    {
        return $this->state(fn (array $attributes) => [
            'date' => $this->faker->dateTimeBetween('-6 months', '-1 day'),
        ]);
    }
}
