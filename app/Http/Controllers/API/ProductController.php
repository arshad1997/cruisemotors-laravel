<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseAPIController;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends BaseAPIController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->doDBTransaction(
            function () {
                if (isset(request()->noPagination)) {
                    return Product::query()->get();
                }
                return Product::query()->paginate(20);
            },
            'Products fetched successfully',
            'Failed to get products',
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'thumbnail' => 'nullable|image',
            'name' => 'required|string',
            'product_category_id' => 'required|exists:product_categories,id',
            'product_sub_category_id' => 'nullable|exists:product_sub_categories,id',
            'car_make_id' => 'required|exists:car_makes,id',
            'car_model_id' => 'required|exists:car_models,id',
            'car_variant_id' => 'nullable|exists:car_variants,id',
            'sku' => 'nullable|string',
            'short_description' => 'required|string',
            'long_description' => 'nullable|string',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'opening_stock' => 'nullable|numeric',
            'is_featured' => 'nullable|boolean',
            'is_published' => 'nullable|boolean',
            'images' => 'required|array|min:1',
            'images.*' => 'required|image',
        ]);
        return $this->doDBTransaction(
            function () use ($request) {
                $product = Product::query()->create($request->except('images'));
                if ($request->hasFile('images')) {
                    $order = 0;
                    foreach ($request->file('images') as $image) {
                        $imageId = uploadMedia($image, 'products');

                        if ($order === 0) {
                            $product->update(['thumbnail' => $imageId]);
                        }

                        $product->images()->create([
                            'image_id' => $imageId,
                            'order' => $order,
                        ]);

                        $order++;
                    }
                }

                return $product;
            },
            'Product created successfully',
            'Failed to create product',
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return $this->doDBTransaction(
            function () use ($product) {
                return Product::query()->find($product->id);
            },
            'Product detail fetched successfully',
            'Failed to get product details',
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }

    /**
     * Get product by category
     */

    public function getProductByCategory($name)
    {
        return $this->doDBTransaction(
            function () use ($name) {
                $categoryName = strtolower(str_replace('-', ' ', $name));
                $category = ProductCategory::query()->whereRaw("lower(name)='$categoryName'")->first();
                if (!$category) {
                    return throw new \Exception('Category not found');
                }

                return Product::query()->where('product_category_id', $category->id)->paginate(20);
            },
            'Products fetched successfully',
            'Failed to get product by category',
        );
    }

    public function updateWishlist(Product $product)
    {
        return $this->doDBTransaction(
            function () use ($product) {
                $product = Product::query()->find($product->id);
                if (!$product) {
                    throw new \Exception('Product not found');
                }

                $user = auth()->user();
                $wishlistItem = $user->wishlist()->where('product_id', $product->id)->first();
                if ($wishlistItem) {
                    $wishlistItem->delete();
                } else {
                    $user->wishlist()->create(['product_id' => $product->id]);
                }
                return $user->wishlist;
            },
            'Wishlist updated successfully',
            'Failed to update wishlist'
        );
    }

    public function getWishlist()
    {
        return $this->doDBTransaction(
            function () {
                return auth()->user()->wishlist;
            },
            'Wishlist fetched successfully',
            'Failed to get wishlist',
        );
    }
}
