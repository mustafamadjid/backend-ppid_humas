<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProfilPpid>
 */
class ProfilPpidFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'deskripsi_profil'=>$this->faker->sentence(4),
            'visi_ppid'=>$this->faker->sentence(2),
            'misi_ppid'=>$this->faker->sentence(2),
            'tugas_ppid'=>$this->faker->sentence(2),
            'fungsi_ppid'=>$this->faker->sentence(2),
        ];
    }
}


