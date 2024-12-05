<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ProductCategory extends Model
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

        static::creating(function ($category) {
            $category->slug = Str::slug($category->name . '-' . strtotime(now())). '-' . rand(1000, 99999);
            $category->code = generateCode('category');
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
}
