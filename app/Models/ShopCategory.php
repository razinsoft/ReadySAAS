<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopCategory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'status' => Status::class,
    ];

    public function shops()
    {
        return $this->hasMany(Shop::class);
    }
}
