<?php

namespace App\Repositories;

use App\Enums\Status;
use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\User;

class ShopRepository extends Repository
{
    public static function model()
    {
        return Shop::class;
    }

    public static function storeByRequest(Request $request, User $user)
    {
        return self::create([
            'user_id' => $user->id,
            'name' => $request->shop_name,
            'shop_category_id' => $request->shop_category_id,
            'status' => Status::INACTIVE->value,
        ]);
    }

    public static function updateByRequest(Shop $shop, Request $request)
    {
        return self::update($shop, [
            'name' => $request->shop_name,
            'shop_category_id' => $request->shop_category_id,
            'status' => $request->status,
        ]);
    }

    public static function statusChanageByRequest(Shop $shop, $status)
    {
        return self::update($shop, [
            'status' => $status,
        ]);
    }
}
