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
            $generalSettings = GeneralSettingRepository::query()->whereNull('shop_id')->latest()->first();
            if (mainShop()) {
                $generalSettings = GeneralSettingRepository::query()->where('shop_id', mainShop()->id)->first();
            }
            $currency = $generalSettings?->defaultCurrency;
            $view->with('general_settings', $generalSettings);
            $view->with('currency', $currency);
        });
    }
}
