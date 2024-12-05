<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentationItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $with = ['documentService'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function ($builder) {
            $builder->orderBy('created_at', 'desc');
        });
    }

    public function documentService()
    {
        return $this->belongsTo(DocumentService::class, 'document_service_id');
    }

    public function documentationAndCertificate()
    {
        return $this->belongsTo(Documentation::class, 'documentation_and_certificate_id');
    }
}
