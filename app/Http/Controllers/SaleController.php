<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Repositories\GeneralSettingRepository;
use App\Repositories\SaleRepository;

class SaleController extends Controller
{
    public function index()
    {
        $shop = auth()->user()?->shop;
        if ($shop) {
            $shopId = $shop->id;
        } else {
            $shopId = auth()->user()?->shop_id;
        }
        $sales = SaleRepository::query()->where('shop_id', $shopId)->orderByDesc('id')->where('type', 'Sales')->get();
        return view('sale.index', compact('sales'));
    }
    public function posSale()
    {
        return view('sale.pos');
    }
    public function generateInvoice($id)
    {
        $sale = SaleRepository::find($id);
        $shop = auth()->user()?->shop;
        if ($shop) {
            $shopId = $shop->id;
        } else {
            $shopId = auth()->user()?->shop_id;
        }
        $generalsettings = GeneralSettingRepository::query()->where('shop_id', $shopId)->first();
        return view('sale.invoice', compact('sale', 'generalsettings'));
    }
    public function salePrint()
    {
        $request = request();
        $shop = auth()->user()?->shop;
        if ($shop) {
            $shopId = $shop->id;
        } else {
            $shopId = auth()->user()?->shop_id;
        }
        $sales = SaleRepository::query()->orderBy('id', 'DESC')->limit($request->length)->get();
        $generalsettings = GeneralSettingRepository::query()->where('shop_id', $shopId)->first();
        return view('sale.salePrint', compact('sales', 'generalsettings'));
    }
    public function draft()
    {
        $shop = auth()->user()?->shop;
        if ($shop) {
            $shopId = $shop->id;
        } else {
            $shopId = auth()->user()?->shop_id;
        }
        $drafts = SaleRepository::query()->where('shop_id', $shopId)->orderByDesc('id')->where('type', 'Draft')->get();
        return view('sale.draft', compact('drafts'));
    }
    public function draftDelete(Sale $sale)
    {
        foreach ($sale->productSales as $draftProduct) {
            $draftProduct->product->update(['qty' => $draftProduct->product->qty + $draftProduct->qty]);
        }
        $sale->productSales()->delete();
        $sale->delete();
        return back()->with('success', 'Draft successfully deleted');
    }
}
