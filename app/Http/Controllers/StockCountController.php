<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\BrandRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\StockCountRepository;
use App\Repositories\WarehouseRepository;

class StockCountController extends Controller
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
        $brands = BrandRepository::query()->where('shop_id', $shopId)->orderByDesc('id')->get();
        $categories = CategoryRepository::query()->where('shop_id', $shopId)->orderByDesc('id')->get();
        $stockCounts = StockCountRepository::query()->where('shop_id', $shopId)->orderByDesc('id')->get();

        return view('stockCount.index', compact('warehouses', 'brands', 'categories', 'stockCounts'));
    }

    public function store(Request $request)
    {
        StockCountRepository::storeByRequest($request);
        return back()->with('success', 'Stock count is successfully added!');
    }
}
