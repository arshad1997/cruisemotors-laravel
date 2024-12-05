<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Quotation extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $with = ['items', 'user', 'departureCountry', 'departureState', 'departureCity', 'departurePort', 'pickupCountry', 'pickupState', 'pickupCity', 'pickupPort', 'trackable'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function ($builder) {
            $builder->orderBy('created_at', 'desc');
        });

        static::deleting(function ($quotation) {
            $quotation->items()->delete();
        });

        static::restoring(function ($quotation) {
            $quotation->items()->restore();
        });

        static::creating(function ($query) {
            $query->code = generateCode('quotation');
            $query->user_id = auth()->id();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function departureCountry()
    {
        return $this->belongsTo(State::class, 'departure_country_id');
    }

    public function departureState()
    {
        return $this->belongsTo(State::class, 'departure_state_id');
    }

    public function departureCity()
    {
        return $this->belongsTo(State::class, 'departure_city_id');
    }

    public function departurePort()
    {
        return $this->belongsTo(State::class, 'departure_port_id');
    }

    public function pickupCountry()
    {
        return $this->belongsTo(State::class, 'pickup_country_id');
    }

    public function pickupState()
    {
        return $this->belongsTo(State::class, 'pickup_state_id');
    }

    public function pickupCity()
    {
        return $this->belongsTo(State::class, 'pickup_city_id');
    }

    public function pickupPort()
    {
        return $this->belongsTo(State::class, 'pickup_port_id');
    }

    public function items()
    {
        return $this->hasMany(QuotationItem::class);
    }

    public function trackable()
    {
        return $this->morphMany(StatusTracking::class, 'trackable');
    }
}
