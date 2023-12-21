<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaxRequest;
use Illuminate\Http\Request;
use App\Models\Tax;
use App\Repositories\TaxRepository;

class TaxController extends Controller
{
    public function index()
    {
        $shop = auth()->user()?->shop;
        if ($shop) {
            $shopId = $shop->id;
        } else {
            $shopId = auth()->user()?->shop_id;
        }
        $taxs = TaxRepository::query()->where('shop_id', $shopId)->orderByDesc('id')->get();
        return view('tax.index', compact('taxs'));
    }

    public function store(TaxRequest $request)
    {
        TaxRepository::storeByRequest($request);
        return back()->with('success', 'Tax is created successfully!');
    }

    public function update(TaxRequest $request, Tax $tax)
    {
        TaxRepository::updateByRequest($request, $tax);
        return back()->with('success', 'Tax is updated successfully!');
    }

    public function delete(Tax $tax)
    {
        $tax->delete();
        return back()->with('success', 'Tax is deleted successfully!');
    }
}
