<?php

namespace Database\Seeders;

use App\Models\Storehouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StorehousesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 3; $i++) {
            Storehouse::create([
                'company_id' => 1,
                'name' => 'Склад  ' . $i,
            ]);
        }
    }
}
