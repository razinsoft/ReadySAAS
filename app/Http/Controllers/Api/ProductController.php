<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function search()
    {
        $request = request();
        $search = $request->search;
        $page = $request->page;
        $take = $request->take;
        $skip = ($page * $take) - $take;

        $productSearch = ProductRepository::search($search);
        $totalProduct = $productSearch->count();
        $hasTakeSkip = false;
        if ($page && $take) {
            $hasTakeSkip = true;
        }

        $products = $productSearch->when($hasTakeSkip, function ($query) use ($skip, $take) {
            $query->skip($skip)->take($take);
        })->get();


        return $this->json('Search Products', [
            'total' => $totalProduct,
            'products' => ProductResource::collection($products),
        ]);
    }

    public function categoryProduct(Category $category)
    {
        $products = $category->product;
        return $this->json('Product list', [
            'products' => ProductResource::collection($products),
        ]);
    }
}
