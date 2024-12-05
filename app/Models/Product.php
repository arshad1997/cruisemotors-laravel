<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $with = ['images', 'subCategory', 'category', 'carMake', 'carModel', 'carVariant'];
    protected $appends = ['is_in_wishlist', 'is_in_cart'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function ($builder) {
            $builder->orderBy('created_at', 'desc');
        });

        static::deleting(function ($product) {
            $product->images()->delete();
        });

        static::restoring(function ($product) {
            $product->images()->restore();
        });

        static::creating(function ($product) {
            $product->slug = Str::slug($product->name . '-' . strtotime(now())). '-' . rand(1000, 99999);
            $product->code = generateCode('product');
        });
    }

    public function subCategory()
    {
        return $this->belongsTo(ProductSubCategory::class, 'product_sub_category_id');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function getIsInWishlistAttribute()
    {
        return Wishlist::query()->where('product_id', $this->id)->where('user_id', auth()->id())->exists();
    }

    public function getIsInCartAttribute()
    {
        return Cart::query()
            ->where('product_id', $this->id)
            ->where('status', true)
            ->where('user_id', auth()->id())
            ->exists();
    }

    public function carMake()
    {
        return $this->belongsTo(CarMake::class, 'car_make_id');
    }

    public function carModel()
    {
        return $this->belongsTo(CarModel::class, 'car_model_id');
    }

    public function carVariant()
    {
        return $this->belongsTo(CarModel::class, 'car_variant_id');
    }
}
