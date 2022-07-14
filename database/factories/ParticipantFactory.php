<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Participant>
 */
class ParticipantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'phone' => fake()->numberBetween(10000000000, 99999999999),
            'dozens' => $this->generateRandomDozens(),
            'points' => 0,
            'update_number' => 0,
            'active' => true,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' // password
        ];
    }

    private function generateRandomDozens(): array
    {
        $dozens = [];

        for ($i = 1; $i <= 10; $i++) {
            array_push($dozens, $this->faker->numberBetween(1, 60));
        }

        return $dozens;
    }
}
