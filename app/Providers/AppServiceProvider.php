<?php

namespace App\Providers;

use App\Repositories\CurrencyRepository;
use App\Repositories\GeneralSettingRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('*', function ($view) {
            $shop = auth()->user()?->shop;
            if ($shop) {
                $generalSettings = GeneralSettingRepository::query()->where('shop_id', $shop->id)->first();
            } else {
                $generalSettings = GeneralSettingRepository::query()->whereNull('shop_id')->latest()->first();
            }
            $currency = $generalSettings?->defaultCurrency;
            $view->with('general_settings', $generalSettings);
            $view->with('currency', $currency);
        });
    }
}
