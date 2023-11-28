<?php

namespace Database\Seeders;

use App\Models\GeneralSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GeneralSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GeneralSetting::create([
            'site_title' => 'Ready POS',
            'currency_id' => 1,
            'currency_position' => 'Prefix',
            'date_format' => 'd m Y',
            'date_with_time' => 'Enable',
            'address' => fake()->address(),
            'email' => fake()->email(),
            'phone' => fake()->phoneNumber(),
            'developed_by' => 'Razinsoft',
            'direction' => 'ltr',
            'lang' => 'en',
        ]);
    }
}
