<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SematanAplikasi>
 */
class SematanAplikasiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'judul_sematan' => $this->faker->sentence(1),
            'url_sematan' => $this->faker->url(),
            'icon' => "<Icon/>"
        ];
    }
}
