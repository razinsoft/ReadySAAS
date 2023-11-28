<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RolePermissionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(UnitSeeder::class);
        $this->call(CurrencySeeder::class);
        $this->call(GeneralSettingSeeder::class,);
        

        if (app()->environment('local')) {
            $this->call([
                CustomerGroupSeeder::class,
                CustomerSeeder::class,
                CurrencySeeder::class,
                BrandSeeder::class,
                TaxSeeder::class,
                WarehouseSeeder::class,
                SupplierSeeder::class,
                CouponSeeder::class,
                CategorySeeder::class,
            ]);
        }

        $this->installPassportClient();
    }

    private function installPassportClient()
    {
        $this->command->warn('Installing passport client');
        Artisan::call('passport:install');
        Artisan::call('storage:link');
        $this->command->info('Passport client installed');
    }
}
