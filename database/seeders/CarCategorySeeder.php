<?php

namespace Database\Seeders;

use App\Models\CarCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Normal'],
            ['name' => 'Luxury'],
            ['name' => 'Sports'],
            ['name' => 'Classic'],
            ['name' => 'Vintage'],
            ['name' => 'Others'],
        ];

        foreach ($categories as $category) {
            CarCategory::query()->create($category);
        }
    }
}
