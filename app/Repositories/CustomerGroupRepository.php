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
        $create = self::create([
            'name' => $request->name,
            'percentage' => $request->percentage,
        ]);

        return $create;
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
