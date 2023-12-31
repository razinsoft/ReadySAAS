<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createSuperAdmin();
        $this->createAdmin();
        $this->groceryShopOwner();
        $this->pharmacyOwner();
        $this->electronicsShopOwner();
        $this->restaurantOwner();
        $this->clothingOwner();
        $this->createStore();
    }
    private function createSuperAdmin()
    {
        $userAdmin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
        ]);

        $userAdmin->assignRole('super admin');
    }
    private function createAdmin()
    {
        $userAdmin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);
        $userAdmin->assignRole('admin');
    }
    private function groceryShopOwner()
    {
        $userAdmin = User::factory()->create([
            'name' => 'Grocery Shop Owner',
            'email' => 'groceryshop@example.com',
        ]);
        $userAdmin->assignRole('admin');
    }
    private function pharmacyOwner()
    {
        $userAdmin = User::factory()->create([
            'name' => 'Pharmacy Owner',
            'email' => 'pharmacy@example.com',
        ]);
        $userAdmin->assignRole('admin');
    }
    private function electronicsShopOwner()
    {
        $userAdmin = User::factory()->create([
            'name' => 'Electronics Shop Owner',
            'email' => 'electronics@example.com',
        ]);
        $userAdmin->assignRole('admin');
    }
    private function restaurantOwner()
    {
        $userAdmin = User::factory()->create([
            'name' => 'Restaurant Owner',
            'email' => 'restaurant@example.com',
        ]);
        $userAdmin->assignRole('admin');
    }
    private function clothingOwner()
    {
        $userAdmin = User::factory()->create([
            'name' => 'Clothing Shop Owner',
            'email' => 'clothing@example.com',
        ]);
        $userAdmin->assignRole('admin');
    }
    private function createStore()
    {
        $staffUser = User::factory()->create([
            'name' => 'Store',
            'email' => 'store@example.com',
        ]);
        $staffUser->assignRole('store');
    }
}
