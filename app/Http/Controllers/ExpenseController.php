<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseRequest;
use Illuminate\Http\Request;
use App\Models\Expense;
use App\Repositories\AccountRepository;
use App\Repositories\ExpenseCategoryRepository;
use App\Repositories\ExpenseRepository;
use App\Repositories\WarehouseRepository;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index()
    {
        $request = request();
        $shop = auth()->user()?->shop;
        $hasDate = false;
        $startDate = date('m/d/Y');
        $endDate = date('m/d/Y', strtotime('+8 days'));
        if ($request->start_date && $request->end_date) {
            $startMil = $request->start_date;
            $startSeconds = $startMil / 1000;
            $startDate = date("m/d/Y", $startSeconds);
            $endMil = $request->end_date;
            $endSeconds = $endMil / 1000;
            $endDate = date("m/d/Y", $endSeconds);
            $hasDate = true;
        }
        $expenses = ExpenseRepository::query()->where('shop_id', $shop->id)->when($hasDate, function ($query) use ($startDate, $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        })->get();

        $warehouses =  WarehouseRepository::query()->where('shop_id', $shop->id)->orderByDesc('id')->get();
        $exCategories = ExpenseCategoryRepository::query()->where('shop_id', $shop->id)->orderByDesc('id')->get();
        $accounts = AccountRepository::query()->where('shop_id', $shop->id)->orderByDesc('id')->get();
        return view('expense.index', compact('accounts', 'expenses', 'warehouses', 'exCategories', 'startDate', 'endDate'));
    }

    public function store(ExpenseRequest $request)
    {
        ExpenseRepository::storeByRequest($request);
        return back()->with('success', 'Data is inserted successfully');
    }

    public function update(ExpenseRequest $request, Expense $expense)
    {
        ExpenseRepository::updateByRequest($request, $expense);
        return back()->with('success', 'Data is updated successfully');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return back()->with('success', 'Data is deleted successfully');
    }
}
