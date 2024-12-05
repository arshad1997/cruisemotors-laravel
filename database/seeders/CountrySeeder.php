<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('countries')->truncate();
        DB::table('states')->truncate();
        DB::table('cities')->truncate();
        $path = base_path('public/location-sql-files/countries.sql');
        DB::unprepared(file_get_contents($path));
    }
}
