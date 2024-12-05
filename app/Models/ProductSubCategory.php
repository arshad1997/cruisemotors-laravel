<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ProductSubCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $with = ['thumbnail'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function ($builder) {
            $builder->orderBy('created_at', 'desc');
        });

        static::creating(function ($subCategory) {
            $subCategory->slug = Str::slug($subCategory->name . '-' . strtotime(now())). '-' . rand(1000, 99999);
            $subCategory->code = generateCode('sub_category');
        });
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function thumbnail()
    {
        return $this->belongsTo(Upload::class, 'thumbnail');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }
}
