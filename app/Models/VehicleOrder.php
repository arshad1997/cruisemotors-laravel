<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $with = ['items', 'country', 'state', 'city', 'port', 'trackable', 'user'];

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
            $query->code = generateCode('order-vehicle');
            $query->user_id = auth()->id();
        });
    }

    public function items()
    {
        return $this->hasMany(VehicleOrderItem::class, 'vehicle_order_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
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
