<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, HasRoles, HasApiTokens, SoftDeletes;

    protected $guarded = ['id'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function thumbnail()
    {
        return $this->belongsTo(Media::class, 'thumbnail_id');
    }

    public function holiday()
    {
        return $this->hasMany(Holiday::class);
    }
    public function coupons()
    {
        return $this->hasMany(Coupon::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }
}
