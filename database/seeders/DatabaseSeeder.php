<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            UserSeeder::class,
            ProductCategorySeeder::class,
            ProductSubCategorySeeder::class,
            CarMakeSeeder::class,
            CountrySeeder::class,
            StateSeeder::class,
            CitySeeder::class,
            PaymentMethodSeeder::class,
            CarBodyTypeSeeder::class,
            CarCategorySeeder::class,
            DocumentServiceSeeder::class,
        ]);
    }
}
