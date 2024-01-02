<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Repositories\GeneralSettingRepository;
use App\Repositories\SaleRepository;

class SaleController extends Controller
{
    public function index()
    {
        $sales = SaleRepository::query()->where('shop_id', $this->mainShop()->id)->orderByDesc('id')->where('type', 'Sales')->get();
        return view('sale.index', compact('sales'));
    }
    public function posSale()
    {
        return view('sale.pos');
    }
    public function generateInvoice($id)
    {
        $sale = SaleRepository::find($id);
        $generalsettings = GeneralSettingRepository::query()->where('shop_id', $this->mainShop()->id)->first();
        return view('sale.invoice', compact('sale', 'generalsettings'));
    }
    public function salePrint()
    {
        $request = request();
        $sales = SaleRepository::query()->orderBy('id', 'DESC')->limit($request->length)->get();
        $generalsettings = GeneralSettingRepository::query()->where('shop_id', $this->mainShop()->id)->first();
        return view('sale.salePrint', compact('sales', 'generalsettings'));
    }
    public function draft()
    {
        $drafts = SaleRepository::query()->where('shop_id', $this->mainShop()->id)->orderByDesc('id')->where('type', 'Draft')->get();
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
