<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\BrandRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\GeneralSettingRepository;
use App\Repositories\StockCountRepository;
use App\Repositories\WarehouseRepository;

class StockCountController extends Controller
{
    public function index()
    {
        $warehouses = WarehouseRepository::getAll();
        $brands = BrandRepository::getAll();
        $categories = CategoryRepository::getAll();
        $general_setting = GeneralSettingRepository::query()->latest()->first();
        $stockCounts = StockCountRepository::query()->orderBy('id', 'desc')->where('user_id', auth()->id())->get();

        return view('stockCount.index', compact('warehouses', 'brands', 'categories', 'stockCounts'));
    }

    public function store(Request $request)
    {
        StockCountRepository::storeByRequest($request);
        return back()->with('success', 'Stock count is successfully added!');
    }
}
