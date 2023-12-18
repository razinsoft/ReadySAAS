<?php

use App\Repositories\GeneralSettingRepository;
use Carbon\Carbon;

function dateFormat($date)
{
    $generalSetting = GeneralSettingRepository::query()->whereNull('shop_id')->latest()->first();
    $format = $generalSetting->date_format->value ?? 'd m Y';
    $date = Carbon::parse($date)->format($format);
    if ($generalSetting->date_with_time->value == 'Enable') {
        $date = Carbon::parse($date)->format($format . ' h:m:s');
    }
    return $date;
}

function numberFormat($number)
{
    $generalSetting = GeneralSettingRepository::query()->whereNull('shop_id')->latest()->first();
    $symbol = $generalSetting->defaultCurrency->symbol ?? '$';
    if (isset($generalSetting->currency_position) && ($generalSetting->currency_position->value == "Prefix")) {

        return $symbol . ' ' . number_format($number, 2);
    }

    return number_format($number, 2) . ' ' . $symbol;
}
