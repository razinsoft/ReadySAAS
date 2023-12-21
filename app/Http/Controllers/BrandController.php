<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Repositories\BrandRepository;

class BrandController extends Controller
{

    public function index()
    {
        $shop = auth()->user()?->shop;
        if ($shop) {
            $shopId = $shop->id;
        } else {
            $shopId = auth()->user()?->shop_id;
        }
        $brands = BrandRepository::query()->where('shop_id', $shopId)->orderByDesc('id')->get();
        return view('brand.index', compact('brands'));
    }

    public function store(BrandRequest $request)
    {
        BrandRepository::storeByRequest($request);
        return back()->with('success', 'Brand is created successfully!');
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return $brand;
    }

    public function update(BrandRequest $request, Brand $brand)
    {
        BrandRepository::updateByRequest($request, $brand);
        return back()->with('success', 'Brand is updated successfully!');
    }

    public function delete(Brand $brand)
    {
        $brand->delete();
        return back()->with('success', 'Brand is deleted successfully!');
    }
}
