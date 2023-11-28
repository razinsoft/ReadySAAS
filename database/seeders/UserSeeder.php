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
        $this->createAdmin();
        $this->createOwner();
        $this->createStore();
    }
    private function createAdmin()
    {
        $userAdmin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);

        $userAdmin->assignRole('admin');
    }
    private function createOwner()
    {
        $customerUser = User::factory()->create([
            'name' => 'Owner',
            'email' => 'owner@example.com',
        ]);

        $customerUser->assignRole('owner');
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
