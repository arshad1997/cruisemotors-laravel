<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfferVehicleItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $with = ['carMake', 'carModel'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function ($builder) {
            $builder->orderBy('created_at', 'desc');
        });
    }

    public function offerVehicle()
    {
        return $this->belongsTo(OfferVehicle::class, 'offer_vehicle_id');
    }

    public function carMake()
    {
        return $this->belongsTo(CarMake::class);
    }

    public function carModel()
    {
        return $this->belongsTo(CarModel::class);
    }
}
