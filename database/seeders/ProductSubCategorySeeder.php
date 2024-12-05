<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productSubCategories = [
            ['name' => 'Uncategorized'],
        ];

        $categories = ProductCategory::query()->get();
        foreach ($categories as $category) {
            foreach ($productSubCategories as $productSubCategory) {
                ProductSubCategory::query()->create([
                    'name' => $productSubCategory['name'],
                    'product_category_id' => $category->id,
                ]);
            }
        }
    }
}
