<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $car = Car::create([
            'created_by' => 1,
            'make' => 'Toyota',
            'model' => 'Corolla',
            'year' => 2020,
            'fuel_type' => 'mid',
            'price' => 20000,
        ]);

        $car->features()->create([
            'name' => 'Air Conditioning',
            'description' => 'Automatic climate control with air filtration',
        ]);

        $car->images()->create([
            'image_path' => 'https://example.com/car1.jpg',
        ]);
    }
}
