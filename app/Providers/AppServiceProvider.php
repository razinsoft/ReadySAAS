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
        view()->composer('*',function($view){
            $general_settings = GeneralSettingRepository::query()->latest()->first();
            $currency = $general_settings?->defaultCurrency;
            $view->with('general_settings', $general_settings);
            $view->with('currency', $currency);
        });
    }
}
