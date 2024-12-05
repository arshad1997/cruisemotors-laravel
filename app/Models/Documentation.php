<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Documentation extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $with = ['carMake', 'carModel', 'carVariant', 'trackable', 'user', 'serviceItems', 'attachments'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function ($builder) {
            $builder->orderBy('created_at', 'desc');
        });

        static::creating(function ($query) {
            $query->code = generateCode('documentation');
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

    public function carVariant()
    {
        return $this->belongsTo(CarVariant::class, 'car_variant_id');
    }

    public function trackable()
    {
        return $this->morphMany(StatusTracking::class, 'trackable');
    }

    public function serviceItems()
    {
        return $this->hasMany(DocumentationItem::class, 'documentation_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function attachments()
    {
        return $this->morphMany(Attachments::class, 'source');
    }
}
