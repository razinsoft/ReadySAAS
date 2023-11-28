<?php

namespace App\Repositories;

use App\Http\Requests\CurrencyRequest;
use App\Models\Currency;

class CurrencyRepository extends Repository
{
    public static function model()
    {
        return Currency::class;
    }

    public static function storeByRequest(CurrencyRequest $request)
    {
        $create = self::create([
            'name' => $request->name,
            'symbol' => $request->symbol,
            'code' => $request->code
        ]);

        return $create;
    }

    public static function updateByRequest(CurrencyRequest $request, Currency $currency)
    {
        $update = self::update($currency, [
            'name' => $request->name,
            'symbol' => $request->symbol,
            'code' => $request->code
        ]);
        
        return $update;
    }
}
