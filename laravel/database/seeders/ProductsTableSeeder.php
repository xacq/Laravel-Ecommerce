<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productRecords = [
            ['id'=>1,
            'section_id'=>2,
             'category_id'=>5,  
             'brand_id'=>1,
             'vendor_id'=>1,
             'admin_id'=>0,
             'admin_tipo'=>'vendedor',
             'producto_nombre'=>'Flod Z5',
             'producto_codigo'=>'121212',
             'producto_color'=>'negro',
             'producto_precio'=>1000,
             'producto_descuento'=>10,
             'producto_peso'=>500,
             'producto_image'=>'',
             'producto_video'=>'',
             'descripcion'=>'',
             'meta_titulo'=>'',
             'meta_descripcion'=>'',
             'meta_palabraclave'=>'',
             'es_destacada'=>'Si',
             'status'=>1,
            ],
            ['id'=>2,
                'section_id'=>3,
                'category_id'=>11,  
                'brand_id'=>0,
                'vendor_id'=>0,
                'admin_id'=>1,
                'admin_tipo'=>'administrador',
                'producto_nombre'=>'Ramo Buchon',
                'producto_codigo'=>'RBJ01',
                'producto_color'=>'rojo',
                'producto_precio'=>45,
                'producto_descuento'=>0,
                'producto_peso'=>30,
                'producto_image'=>'',
                'producto_video'=>'',
                'descripcion'=>'',
                'meta_titulo'=>'',
                'meta_descripcion'=>'',
                'meta_palabraclave'=>'',
                'es_destacada'=>'Si',
                'status'=>1,
            ]
        ];
        Product::insert($productRecords);
    }
}
