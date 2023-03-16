<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, SoftDeletes, HasApiTokens;

    protected $fillable = [
        'name',
        'last_names',
        'email',
        'address',
        'identification',
        'rfc',
        'phone',
    ];

    protected $dates = [
        'verified'
    ];

    protected $hidden = [
        'password',
        'identification',
    ];

    public function storages()
    {
        return $this->hasMany(Storage::class);
    }

    public function contracts()
    {
        return $this->belongsToMany(Storage::class)->orderByPivot("id", "DESC")->withPivot(['start_date', 'end_date', 'total']);
    }
}
