<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class CarModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $with = ['logo'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function ($builder) {
            $builder->orderBy('created_at', 'desc');
        });

        static::creating(function ($carModel) {
            $carModel->slug = Str::slug($carModel->name . '-' . strtotime(now())). '-' . rand(1000, 99999);
            $carModel->code = generateCode('car-model');
        });
    }

    public function carMake()
    {
        return $this->belongsTo(CarMake::class, 'car_make_id');
    }

    public function carVariants()
    {
        return $this->hasMany(CarVariant::class);
    }

    public function logo()
    {
        return $this->belongsTo(Upload::class, 'logo');
    }
}
