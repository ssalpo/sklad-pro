<?php

namespace Database\Seeders;

use App\Models\Nomenclature;
use App\Models\NomenclatureArrival;
use App\Models\Storehouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NomenclatureArrivalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $nomenclature = Nomenclature::withoutGlobalScopes()->findOrFail($i);
            $companyId = 1;

            NomenclatureArrival::create([
                'company_id' => $companyId,
                'storehouse_id' => Storehouse::withoutGlobalScopes()->whereCompanyId($companyId)->inRandomOrder()->first()?->id,
                'nomenclature_id' => $i,
                'quantity' => random_int(15, 40),
                'base_price' => $nomenclature->base_price,
                'price_for_sale' => $nomenclature->price_for_sale
            ]);
        }
    }
}
