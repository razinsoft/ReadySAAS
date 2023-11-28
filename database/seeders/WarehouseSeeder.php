<?php

namespace Database\Seeders;

use App\Models\Warehouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Warehouse::create([
            'name' => 'warehouse 1',
            'phone' => '25477888',
            'email' => 'warehouse1@gmail.com',
            'address' => 'test'
        ]);
    }
}
