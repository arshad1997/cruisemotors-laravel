<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfferVehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $with = ['items', 'trackable', 'user'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function ($builder) {
            $builder->orderBy('created_at', 'desc');
        });

        static::deleting(function ($query) {
            $query->items()->delete();
        });

        static::restoring(function ($query) {
            $query->items()->restore();
        });

        static::creating(function ($query) {
            $query->code = generateCode('offer-vehicle');
            $query->user_id = auth()->id();
        });
    }

    public function items()
    {
        return $this->hasMany(OfferVehicleItem::class, 'offer_vehicle_id');
    }

    public function port()
    {
        return $this->belongsTo(Port::class);
    }

    public function trackable()
    {
        return $this->morphMany(StatusTracking::class, 'trackable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
