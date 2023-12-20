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
        $sales = SaleRepository::query()->where('shop_id', $shop->id)->orderByDesc('id')->where('type', 'Sales')->get();
        return view('sale.index', compact('sales'));
    }
    public function posSale()
    {
        return view('sale.pos');
    }
    public function generateInvoice($id)
    {
        $sale = SaleRepository::find($id);
        return view('sale.invoice', compact('sale'));
    }
    public function salePrint()
    {
        $request = request();
        $shop = auth()->user()?->shop;
        $sales = SaleRepository::query()->orderBy('id', 'DESC')->limit($request->length)->get();
        $generalsettings = GeneralSettingRepository::query()->where('shop_id', $shop->id)->first();
        return view('sale.salePrint', compact('sales', 'generalsettings'));
    }
    public function draft()
    {
        $shop = auth()->user()?->shop;
        $drafts = SaleRepository::query()->where('shop_id', $shop->id)->orderByDesc('id')->where('type', 'Draft')->get();
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
