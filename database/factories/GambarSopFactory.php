<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GambarSop>
 */
class GambarSopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'path_gambar' => 'gambar_sop_beranda/image.png',
            'order' => $this->faker->randomDigitNotNull(),
        ];
    }
}
