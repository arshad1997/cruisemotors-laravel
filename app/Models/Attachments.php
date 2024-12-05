<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachments extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $with = ['file'];

    public function source()
    {
        return $this->morphTo();
    }

    public function file()
    {
        return $this->belongsTo(Upload::class, 'file_id');
    }

    public function statusTracking()
    {
        return $this->morphMany(StatusTracking::class, 'trackable');
    }
}
