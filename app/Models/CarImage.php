<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarImage extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $with = ['image'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function ($builder) {
            $builder->orderBy('created_at', 'desc');
        });
    }

    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id');
    }

    public function image()
    {
        return $this->belongsTo(Upload::class, 'image_id');
    }
}
