<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaleRequest;
use App\Http\Resources\BrandResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CustomerGroupResource;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SaleResource;
use App\Http\Resources\TaxResource;
use App\Http\Resources\WarehouseResource;
use App\Models\GeneralSetting;
use App\Repositories\BrandRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CustomerGroupRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\ProductRepository;
use App\Repositories\SaleRepository;
use App\Repositories\TaxRepository;
use App\Repositories\WarehouseRepository;

class PosController extends Controller
{
    public function pos()
    {
        $customers = CustomerRepository::query()->where('shop_id', $this->mainShop()->id)->orderByDesc('id')->get();
        $customerGroups = CustomerGroupRepository::query()->where('shop_id', $this->mainShop()->id)->orderByDesc('id')->get();
        $warehouses = WarehouseRepository::query()->where('shop_id', $this->mainShop()->id)->orderByDesc('id')->get();
        $taxes = TaxRepository::query()->where('shop_id', $this->mainShop()->id)->orderByDesc('id')->get();
        $products = ProductRepository::query()->where('shop_id', $this->mainShop()->id)->orderByDesc('id')->whereNotNull('is_featured')->get();
        $brands = BrandRepository::query()->where('shop_id', $this->mainShop()->id)->orderByDesc('id')->get();
        $categories = CategoryRepository::query()->where('shop_id', $this->mainShop()->id)->orderByDesc('id')->get();
        $currency = GeneralSetting::where('shop_id', $this->mainShop()->id)->first()?->defaultCurrency?->symbol ?? '$';

        return $this->json('Pos data', [
            'customers' => CustomerResource::collection($customers),
            'customerGroups' => CustomerGroupResource::collection($customerGroups),
            'warehouses' => WarehouseResource::collection($warehouses),
            'categories' => CategoryResource::collection($categories),
            'taxes' => TaxResource::collection($taxes),
            'featuredProducts' => ProductResource::collection($products),
            'brands' => BrandResource::collection($brands),
            'currency' => $currency
        ]);
    }
    public function store(SaleRequest $request)
    {
        $sale = SaleRepository::storeByRequest($request);
        $message = 'Product successfull sold';
        if ($request->type == 'Draft') {
            $message = 'Product successfull drafted';
        }
        return $this->json($message, [
            'sale' => SaleResource::make($sale),
        ]);
    }
    public function details($id)
    {
        $sale = SaleRepository::query()->where('id', $id)->first();
        $products = [];
        foreach ($sale->productSales as $productSales) {
            $products[] = ProductResource::make($productSales->product);
        }
        return $this->json('Product successfull drafted', [
            'products' => $products,
        ]);
    }
}
