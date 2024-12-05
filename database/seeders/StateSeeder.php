<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('states')->truncate();
        DB::table('cities')->truncate();
        $path = base_path('public/location-sql-files/states.sql');
        DB::unprepared(file_get_contents($path));
    }
}
