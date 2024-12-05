<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class CarMake extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $with = ['logo'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function ($builder) {
            $builder->orderBy('order', 'asc');
        });

        static::creating(function ($carMake) {
            $carMake->slug = Str::slug($carMake->name . '-' . strtotime(now())). '-' . rand(1000, 99999);
            $carMake->code = generateCode('car-make');
        });
    }

    public function carModels()
    {
        return $this->hasMany(CarModel::class);
    }

    public function carVariants()
    {
        return $this->hasManyThrough(CarVariant::class, CarModel::class);
    }

    public function logo()
    {
        return $this->belongsTo(Upload::class, 'logo');
    }
}
