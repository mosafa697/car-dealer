<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Normal User',
            'email' => 'norm@e.com',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@e.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);
    }
}
