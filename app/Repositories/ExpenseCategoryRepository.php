<?php

namespace App\Repositories;

use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseCategoryRepository extends Repository
{
    public static function model()
    {
        return ExpenseCategory::class;
    }
    public static function storeByRequest(Request $request)
    {
        $user = auth()->user();
        $create = self::create([
            'created_by' => $user->id,
            'shop_id' => $user->shop->id,
            'name' => $request->name,
            'code' => $request->code,
        ]);
        return $create;
    }

    public static function updateByRequest(Request $request, ExpenseCategory $expenseCategory)
    {
        $update = self::update($expenseCategory, [
            'name' => $request->name,
            'code' => $request->code,
        ]);
        return $update;
    }
}
