<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inquiry extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $with = ['trackable', 'user'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function ($builder) {
            $builder->orderBy('created_at', 'desc');
        });

        static::creating(function ($query) {
            $query->code = generateCode('inquiry');
            $query->user_id = auth()->id();
        });
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
