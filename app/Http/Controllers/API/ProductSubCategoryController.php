<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseAPIController;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use Illuminate\Http\Request;

class ProductSubCategoryController extends BaseAPIController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->doDBTransaction(
            function () {
                return ProductSubCategory::query()->with('category')->get();
            },
            'Product Sub Categories fetched successfully',
            'Failed to fetch product sub categories'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductSubCategory $productSubCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductSubCategory $productSubCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductSubCategory $productSubCategory)
    {
        //
    }

    public function getSubCategoryByCategory(ProductCategory $productCategory)
    {
        return $this->doDBTransaction(
            function () use ($productCategory) {
                return ProductSubCategory::query()->where('product_category_id', $productCategory->id)->get();
            },
            'Product Sub Categories fetched successfully',
            'Failed to fetch product sub categories'
        );
    }
}
