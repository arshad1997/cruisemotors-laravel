<?php

namespace Database\Seeders;

use App\Models\CarBodyType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarBodyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['name' => 'Sedan'],
            ['name' => 'Compact Sedan'],
            ['name' => 'Hatchback'],
            ['name' => 'Compact Hatchback'],
            ['name' => 'Sub Compact Hatchback'],
            ['name' => 'SUV'],
            ['name' => 'Compact SUV'],
            ['name' => 'MPV'],
            ['name' => 'Crossover'],
            ['name' => 'Coupe'],
            ['name' => 'Convertible'],
            ['name' => 'Wagon'],
            ['name' => 'Station Wagon'],
            ['name' => 'High Roof'],
            ['name' => 'Single Cabin'],
            ['name' => 'Van'],
            ['name' => 'Micro Van'],
            ['name' => 'Min Van'],
            ['name' => 'Truck'],
            ['name' => 'Minivan'],
            ['name' => 'Pickup'],
            ['name' => 'Bus'],
            ['name' => 'Others'],
        ];

        foreach ($types as $type) {
            CarBodyType::query()->create($type);
        }
    }
}
