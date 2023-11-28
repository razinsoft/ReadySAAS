<?php

namespace App\Repositories;

use App\Http\Requests\SaleRequest;
use App\Models\ProductSale;

class ProductSaleRepository extends Repository
{
    public static function model()
    {
        return ProductSale::class;
    }

    public static function storeByRequest(SaleRequest $request, $sale)
    {
        $products = ProductRepository::query()->whereIn('id', $request->product_ids)->get();
        foreach ($products as $key => $product) {
            $productTax = 0;

            if ($product->tax) {
                $productTax = $product->price * $product->tax->rate / 100;
            }

            self::create([
                'sale_id' => $sale->id,
                'product_id' => $product->id,
                'qty' => $request->qty[$key],
                'discount' => 0,
                'tax_rate' => $product->tax?->rate,
                'tax' => $productTax,
                'total' => ($product->price + $productTax) * $request->qty[$key],
            ]);
        }
        
        return $sale;
    }
}
