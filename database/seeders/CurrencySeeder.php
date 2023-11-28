<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Repositories\CurrencyRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencys = [
            [
                'name' => 'US Dollar',
                'code' => 'USD',
                'symbol' => '$'
            ],
            [
                'name' => 'Euro',
                'code' => 'EURO',
                'symbol' => '€'
            ],
            [
                'name' => 'Taka',
                'code' => 'TAKA',
                'symbol' => '৳'
            ]
        ];
        foreach($currencys as $currency){
            CurrencyRepository::create($currency);
        }
    }
}
