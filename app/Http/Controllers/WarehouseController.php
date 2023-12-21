<?php

namespace App\Http\Controllers;

use App\Http\Requests\WarehouseRequest;
use App\Models\Warehouse;
use App\Repositories\WarehouseRepository;

class WarehouseController extends Controller
{

    public function index()
    {
        $shop = auth()->user()?->shop;
        if ($shop) {
            $shopId = $shop->id;
        } else {
            $shopId = auth()->user()?->shop_id;
        }
        $warehouses = WarehouseRepository::query()->where('shop_id', $shopId)->orderByDesc('id')->get();
        return view('warehouse.index', compact('warehouses'));
    }

    public function store(WarehouseRequest $request)
    {
        WarehouseRepository::storeByRequest($request);
        return back()->with('success', 'Warehouse is created successfully!');
    }

    public function update(WarehouseRequest $request, Warehouse $warehouse)
    {
        WarehouseRepository::updateByRequest($request, $warehouse);
        return back()->with('success', 'Warehouse is updated successfully');
    }

    public function delete(Warehouse $warehouse)
    {
        $warehouse->delete();
        return back()->with('success', 'Warehouse is deleted successfully');
    }
}
