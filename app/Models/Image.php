<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $hidden = [
        'id',
        'storage_id',
        'created_at',
        'updated_at',
    ];


    public function storage()
    {
        return $this->belongsTo(Storage::class);
    }
}
