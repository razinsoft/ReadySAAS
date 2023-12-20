<?php

namespace App\Http\Controllers;

use App\Repositories\ExpenseRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ProductSaleRepository;
use App\Repositories\PurchaseRepository;
use App\Repositories\SaleRepository;
use App\Repositories\TransactionRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $shop = auth()->user()?->shop;
        $totalSales = SaleRepository::query()->where('shop_id', $shop->id)->whereMonth('created_at', date('m'))->sum('grand_total');
        $totalPurchase = PurchaseRepository::query()->where('shop_id', $shop->id)->whereMonth('created_at', date('m'))->sum('grand_total');
        $totalpaidAmount = PurchaseRepository::query()->where('shop_id', $shop->id)->whereMonth('created_at', date('m'))->sum('paid_amount');
        $monthlyTotalProductSales = ProductSaleRepository::query()->whereMonth('created_at', date('m'))->get();
        $monthlyExpenses = ExpenseRepository::query()->where('shop_id', $shop->id)->whereMonth('created_at', date('m'))->get();
        $totalPurchaseDue = $totalPurchase - $totalpaidAmount;
        $monthlyProfit = 0;
        foreach ($monthlyTotalProductSales as $productSales) {
            $monthlyProfit += ($productSales->product->price - $productSales->product->cost) * $productSales->qty;
        }

        $sales = ProductRepository::query()->where('shop_id', $shop->id)->take(5)->get();
        $purchases = ProductRepository::query()->where('shop_id', $shop->id)->skip(5)->take(5)->get();
        $transactions = TransactionRepository::query()->where('shop_id', $shop->id)->latest()->take(5)->get();

        return view('dashboard.index', compact('totalSales', 'totalPurchase', 'totalPurchaseDue', 'monthlyProfit', 'sales', 'purchases', 'transactions', 'monthlyExpenses'));
    }
}
