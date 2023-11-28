<?php

namespace App\Repositories;

use App\Http\Requests\WarehouseRequest;
use App\Models\Warehouse;

class WarehouseRepository extends Repository
{
    public static function model()
    {
        return Warehouse::class;
    }

    public static function storeByRequest(WarehouseRequest $request)
    {
        $create = self::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address
        ]);
        
        return $create;
    }

    public static function updateByRequest(WarehouseRequest $request, Warehouse $warehouse)
    {
        $update = self::update($warehouse, [
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
        ]);
        return $update;
    }
}
