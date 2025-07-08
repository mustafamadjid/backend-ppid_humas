<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DeskripsiHalamanDokumen>
 */
class DeskripsiHalamanDokumenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'deskripsi' => $this->faker->sentence(4),
            'kategori_dokumen' => 'informasi publik'
        ];
    }
}
