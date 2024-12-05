<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tender extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $with = ['attachments', 'trackable', 'user'];
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function ($builder) {
            $builder->orderBy('created_at', 'desc');
        });

        static::deleting(function ($query) {
            $query->attachments()->delete();
        });

        static::restoring(function ($query) {
            $query->attachments()->restore();
        });

        static::creating(function ($query) {
            $query->code = generateCode('tender');
            $query->user_id = auth()->id();
        });
    }

    public function attachments()
    {
        return $this->morphMany(Attachments::class, 'source');
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
