<?php

namespace App\Repositories;

use App\Http\Requests\ExpenseRequest;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseRepository extends Repository
{
    public static function model()
    {
        return Expense::class;
    }
    public static function storeByRequest(ExpenseRequest $request)
    {
        $user = auth()->user();
        $create = self::create([
            'created_by' => $user->id,
            'shop_id' => $user->shop->id,
            'reference_no' => 'er-' . date("Ymd") . '-' . date("his"),
            'expense_category_id' => $request->expense_category_id,
            'warehouse_id' => $request->warehouse_id,
            'amount' => $request->amount,
            'account_id' => $request->account_id,
            'note' => $request->note,
        ]);
        return $create;
    }

    public static function updateByRequest(ExpenseRequest $request, Expense $expense)
    {
        $update = self::update($expense, [
            'expense_category_id' => $request->expense_category_id,
            'warehouse_id' => $request->warehouse_id,
            'amount' => $request->amount,
            'account_id' => $request->account_id,
            'note' => $request->note,
        ]);
        return $update;
    }
}
