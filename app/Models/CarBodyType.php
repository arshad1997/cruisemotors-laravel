<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class CarBodyType extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function ($builder) {
            $builder->orderBy('created_at', 'desc');
        });

        static::creating(function ($carType) {
            $carType->code = generateCode('car-body-type');
            $carType->slug = Str::slug($carType->name . '-' . strtotime(now())). '-' . rand(1000, 99999);
        });
    }
}
