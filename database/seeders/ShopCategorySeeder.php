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
        $shopCategories = [
            [
                'name' => 'Super Shop or Grocery Shop',
                'primary_color' => '#EF4444',
                'secondary_color' => '#ef444421',
            ],
            [
                'name' => 'Pharmacy',
                'primary_color' => '#4ADE80',
                'secondary_color' => '#4ade8036',
            ],
            [
                'name' => 'Electronics/Hardware/Mobile Shop',
                'primary_color' => '#3a416f',
                'secondary_color' => '#3a416f38',
            ],
            [
                'name' => 'Restaurant',
                'primary_color' => '#E11D48',
                'secondary_color' => '#e11d4824',
            ],
            [
                'name' => 'Clothing Shop',
                'primary_color' => '#141727',
                'secondary_color' => '#14172726',
            ]
        ];
        foreach ($shopCategories as $shopCategory) {
            ShopCategory::create([
                'created_by' => 1,
                'name' => $shopCategory['name'],
                'primary_color' => $shopCategory['primary_color'],
                'secondary_color' => $shopCategory['secondary_color'],
                'description' => fake()->text(80),
                'status' => Status::ACTIVE->value,
            ]);
        }
    }
}
#ef444424