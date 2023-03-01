<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $hidden = [
        "id",
        'service_id',
        'deleted_at',
        'created_at',
        'updated_at',
        'pivot',
    ];

    public function storages()
    {
        return $this->belongsToMany(Storage::class, 'storage_service');
    }
}
