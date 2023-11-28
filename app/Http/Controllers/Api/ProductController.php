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

        $products = ProductRepository::search($search);
        return $this->json('Search Products', [
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
