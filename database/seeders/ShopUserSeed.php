<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShopUserSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::find(2);
        $staff = User::find(3);
        $admin->shopUser()->attach(1);
        $staff->shopUser()->attach(1);
    }
}
