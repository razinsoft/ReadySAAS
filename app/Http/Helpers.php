<?php

use App\Repositories\GeneralSettingRepository;
use Carbon\Carbon;

function dateFormat($date)
{
    $shop = auth()->user()?->shop;
    if ($shop) {
        $shopId = $shop->id;
    } else {
        $shopId = auth()->user()?->shop_id;
    }
    if ($shopId) {
        $generalSettings = GeneralSettingRepository::query()->where('shop_id', $shopId)->first();
    } else {
        $generalSettings = GeneralSettingRepository::query()->whereNull('shop_id')->latest()->first();
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
    $shop = auth()->user()?->shop;
    if ($shop) {
        $shopId = $shop->id;
    } else {
        $shopId = auth()->user()?->shop_id;
    }
    if ($shopId) {
        $generalSettings = GeneralSettingRepository::query()->where('shop_id', $shopId)->first();
    } else {
        $generalSettings = GeneralSettingRepository::query()->whereNull('shop_id')->latest()->first();
    }
    $symbol = $generalSettings->defaultCurrency->symbol ?? '$';
    if (isset($generalSettings->currency_position) && ($generalSettings->currency_position->value == "Prefix")) {

        return $symbol . ' ' . number_format($number, 2);
    }

    return number_format($number, 2) . ' ' . $symbol;
}
