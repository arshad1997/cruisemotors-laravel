<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImage extends Model
{
    use HasFactory, SoftDeletes;

    protected $with = ['image'];

    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function image()
    {
        return $this->belongsTo(Upload::class, 'image_id');
    }
}
