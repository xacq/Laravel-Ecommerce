<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductsAttribute;

class ProductsAttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productAttributesRecords = [
            [
                'id'=>1,
                'product_id'=>2,
                'tamano'=>'small',
                'precio'=>27,
                'stock'=>10,
                'referencia'=>'CAH01-R',
                'status'=>1,
            ],
            [
                'id'=>2,
                'product_id'=>3,
                'tamano'=>'pequeno',
                'precio'=>28,
                'stock'=>10,
                'referencia'=>'AS01-R',
                'status'=>1,
            ],
            [
                'id'=>3,
                'product_id'=>4,
                'tamano'=>'grande',
                'precio'=>18,
                'stock'=>10,
                'referencia'=>'CD01-R',
                'status'=>1,
            ]
        ];
        ProductsAttribute::insert($productAttributesRecords);
    }
}
