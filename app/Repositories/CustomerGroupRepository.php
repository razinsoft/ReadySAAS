<?php

namespace App\Repositories;

use App\Models\CustomerGroup;
use Illuminate\Http\Request;

class CustomerGroupRepository extends Repository
{
    public static function model()
    {
        return CustomerGroup::class;
    }
    public static function storeByRequest(Request $request)
    {
        $user = auth()->user();
        return self::create([
            'created_by' => $user->id,
            'shop_id' => $user->shop->id ?? $user->shop_id,
            'name' => $request->name,
            'percentage' => $request->percentage,
        ]);
    }

    public static function updateByRequest(Request $request, CustomerGroup $customergroup)
    {
        $update = self::update($customergroup, [
            'name' => $request->name,
            'percentage' => $request->percentage
        ]);
        
        return $update;
    }
}
