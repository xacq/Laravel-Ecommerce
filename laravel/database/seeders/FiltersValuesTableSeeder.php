<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductsFiltersValue;

class FiltersValuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filtervalueRecords = [
            ['id'=>1,'filtro_id'=>1,'filtro_value'=>'algodon','status'=>1],
            ['id'=>2,'filtro_id'=>1,'filtro_value'=>'tela','status'=>1],
            ['id'=>3,'filtro_id'=>2,'filtro_value'=>'buchon','status'=>1],
            ['id'=>4,'filtro_id'=>2,'filtro_value'=>'3 GB','status'=>1]
        ];
        ProductsFiltersValue::insert($filtervalueRecords);
    }
}
