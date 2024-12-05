<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class CarBooking extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function ($builder) {
            $builder->orderBy('created_at', 'desc');
        });

        static::creating(function ($query) {
            $query->code = generateCode('car-booking');
        });
    }

    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
