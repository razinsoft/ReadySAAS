<?php

namespace Database\Seeders;

use App\Enums\Status;
use App\Models\ShopCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShopCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shopCategories = ['General Store', 'Clothing Store', 'Hardware Store', 'Electronics Store', 'Sports Store'];
        foreach ($shopCategories as $shopCategory) {
            ShopCategory::create([
                'created_by' => 1,
                'name' => $shopCategory,
                'description' => fake()->text(80),
                'status' => Status::ACTIVE->value,
            ]);
        }
    }
}
