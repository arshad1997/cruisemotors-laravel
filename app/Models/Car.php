<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Car extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $with = ['carMake', 'carModel', 'carVariant', 'images', 'carBodyType', 'carCategory', 'attachments'];
    protected $appends = ['is_booked', 'booked_code'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function ($builder) {
            $builder->orderBy('created_at', 'desc');
        });

        static::creating(function ($carMake) {
            $carMake->slug = Str::slug($carMake->name . '-' . strtotime(now())). '-' . rand(1000, 99999);
//            $carMake->code = generateCode('car');
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

    public function carBodyType()
    {
        return $this->belongsTo(CarBodyType::class, 'car_body_type_id');
    }

    public function carCategory()
    {
        return $this->belongsTo(CarCategory::class, 'car_category_id');
    }

    public function attachments()
    {
        return $this->morphMany(Attachments::class, 'source');
    }

    public function images()
    {
        return $this->hasMany(CarImage::class, 'car_id');
    }

    public function getIsBookedAttribute()
    {
        return CarBooking::query()->where('car_id', $this->id)->where('user_id', auth()->id())->exists();
    }

    public function getBookedCodeAttribute()
    {
        $carBooking = CarBooking::query()->where('car_id', $this->id)->where('user_id', auth()->id())->first();
        return $carBooking ? $carBooking->code : '';
    }

}
