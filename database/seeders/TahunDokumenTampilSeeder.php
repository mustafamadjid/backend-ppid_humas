<?php

namespace Database\Seeders;

use App\Models\TahunDokumenTampil;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TahunDokumenTampilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TahunDokumenTampil::create([
            'tahun_dokumen' => 2025
        ]);
    }
}
