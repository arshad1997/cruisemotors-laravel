<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'RTA Certificates',
                'cost' => 190,
                'status' => true,
            ],
            [
                'name' => 'Traffic Certificates',
                'cost' => 299,
                'status' => true,
            ],
            [
                'name' => 'ABC Certificates',
                'cost' => 99,
                'status' => true,
            ],
        ];

        foreach ($services as $service) {
            \App\Models\DocumentService::query()->create($service);
        }
    }
}
