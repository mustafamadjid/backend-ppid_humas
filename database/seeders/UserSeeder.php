<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'username' => 'superadmin',
                'email' => 'superadmin',
                'password' => Hash::make('superadmin123'),
                'role' => 'superadmin'
            ],
            [
                'username' => 'admin',
                'email' => 'admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin'
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
