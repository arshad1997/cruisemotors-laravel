<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productCategories = [
            ['name'=>'Accessories'],
            ['name'=>'Service Kit'],
            ['name'=>'Spare Parts'],
        ];

        foreach ($productCategories as $productCategory) {
            ProductCategory::query()->create($productCategory);
        }
    }
}
