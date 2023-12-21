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
    private function createStore()
    {
        $staffUser = User::factory()->create([
            'name' => 'Store',
            'email' => 'store@example.com',
            'shop_id' => 1,
        ]);

        $staffUser->assignRole('store');
    }
}
