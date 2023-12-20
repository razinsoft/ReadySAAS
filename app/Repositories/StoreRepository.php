<?php

namespace App\Repositories;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreRepository extends Repository
{
    public static function model()
    {
        return Store::class;
    }

    public static function storeByRequest(Request $request)
    {
        return self::create([
            'created_by' => '',
        ]);
    }

    public static function updateByRequest(Request $request, Store $store)
    {

        $update = self::update($store, [
            'name' => $request->name,
        ]);

        return $update;
    }
}
