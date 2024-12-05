<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class CarCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function ($builder) {
            $builder->orderBy('created_at', 'desc');
        });

        static::creating(function ($carCategory) {
            $carCategory->code = generateCode('car-category');
            $carCategory->slug = Str::slug($carCategory->name . '-' . strtotime(now())). '-' . rand(1000, 99999);
        });
    }
}
