<?php

use App\Repositories\GeneralSettingRepository;
use Carbon\Carbon;

function mainShop()
{
    return auth()->user()?->userShop?->shop;
}
function dateFormat($date)
{
    $generalSettings = GeneralSettingRepository::query()->whereNull('shop_id')->latest()->first();
    if (mainShop()) {
        $generalSettings = GeneralSettingRepository::query()->where('shop_id', mainShop()->id)->first();
    }
    $format = $generalSettings->date_format->value ?? 'd-m-Y';
    $date = Carbon::parse($date)->format($format);

    if ($generalSettings->date_with_time->value == 'Enable') {
        $date = Carbon::parse($date)->format($format . ' h:m:s');
    }
    return $date;
}

function numberFormat($number)
{
    $generalSettings = GeneralSettingRepository::query()->whereNull('shop_id')->latest()->first();
    if (mainShop()) {
        $generalSettings = GeneralSettingRepository::query()->where('shop_id', mainShop()->id)->first();
    }
    $symbol = $generalSettings->defaultCurrency->symbol ?? '$';
    if (isset($generalSettings->currency_position) && ($generalSettings->currency_position->value == "Prefix")) {

        return $symbol . ' ' . number_format($number, 2);
    }

    return number_format($number, 2) . ' ' . $symbol;
}
