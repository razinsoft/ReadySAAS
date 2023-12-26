<?php

namespace App\Models;

use App\Enums\IsHas;
use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'status' => Status::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shopCategory()
    {
        return $this->belongsTo(ShopCategory::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(ShopSubscription::class);
    }

    public function currentSubscriptions()
    {
        return $this->subscriptions()->latest()->where('is_current' , IsHas::YES->value)->first();
    }

    public function staffs()
    {
        return $this->hasMany(ShopUser::class);
    }
}
