<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductsFilter;

class FiltersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filterRecords = [
            ['id'=>1,'cat_ids'=>'1,2,3,6','filtro_nombre'=>'Fabric','filtro_columna'=>'fabric','status'=>1],
            ['id'=>2,'cat_ids'=>'5,10','filtro_nombre'=>'Sistema','filtro_columna'=>'sistema','status'=>1]
        ];
        ProductsFilter::insert($filterRecords);
    }
}
