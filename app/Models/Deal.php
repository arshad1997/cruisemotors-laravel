<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Deal extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $with = ['carMake', 'carModel', 'trackable'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function ($builder) {
            $builder->orderBy('created_at', 'desc');
        });

        static::creating(function ($query) {
            $query->code = generateCode('deal');
            $query->user_id = auth()->id();
        });
    }

    public function carMake()
    {
        return $this->belongsTo(CarMake::class, 'car_make_id');
    }

    public function carModel()
    {
        return $this->belongsTo(CarModel::class, 'car_model_id');
    }

    public function trackable()
    {
        return $this->morphMany(StatusTracking::class, 'trackable');
    }
}
