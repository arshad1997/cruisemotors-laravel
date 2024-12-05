<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethod extends Model
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

        static::creating(function ($query) {
            $query->code = generateCode('payment-method');
        });
    }

    public function logo()
    {
        return $this->belongsTo(Upload::class, 'logo');
    }
}
