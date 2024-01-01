<?php

namespace Database\Seeders;

use App\Enums\Status;
use App\Models\Shop;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shops = [
            [
                'user_id' => 2,
                'shop_category_id' => 1,
                'name' => 'ReadySOS Shop',
                'status' => Status::ACTIVE->value
            ],
            [
                'user_id' => 2,
                'shop_category_id' => 2,
                'name' => 'Razin Grocery Shop',
                'status' => Status::ACTIVE->value
            ],
            [
                'user_id' => 2,
                'shop_category_id' => 3,
                'name' => 'Razin Pharmacy',
                'status' => Status::ACTIVE->value
            ],
            [
                'user_id' => 2,
                'shop_category_id' => 4,
                'name' => 'Razin Electronics and Hardware shop',
                'status' => Status::ACTIVE->value
            ],
            [
                'user_id' => 2,
                'shop_category_id' => 5,
                'name' => 'Razin Restaurant',
                'status' => Status::ACTIVE->value
            ],
            [
                'user_id' => 2,
                'shop_category_id' => 6,
                'name' => 'Razin Clothing Shop',
                'status' => Status::ACTIVE->value
            ],
        ];

        foreach ($shops as $shop) {
            Shop::create([
                'user_id' => $shop['user_id'],
                'shop_category_id' => $shop['shop_category_id'],
                'name' => $shop['name'],
                'status' => $shop['status'],
            ]);
        }
    }
}
