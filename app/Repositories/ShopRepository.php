<?php

namespace App\Repositories;

use App\Enums\Status;
use Illuminate\Http\Request;
use App\Models\Shop;

class ShopRepository extends Repository
{
    public static function model()
    {
        return Shop::class;
    }

    public static function storeByRequest(Request $request)
    {
        return self::create([
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
