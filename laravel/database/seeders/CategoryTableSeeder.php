<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoryRecords = [
            ['id'=>1,
             'parent_id'=>0,
             'section_id'=>1,
             'categoria_nombre'=>'Hombre',
             'categoria_image'=>'',
             'categoria_descuento'=>0,
             'descripcion'=>'',
             'url'=>'hombre',
             'meta_titulo'=>'',
             'meta_descripcion'=>'',
             'meta_palabraclave'=>'',
             'status'=>1
            ],
            ['id'=>2,
             'parent_id'=>0,
             'section_id'=>1,
             'categoria_nombre'=>'Mujer',
             'categoria_image'=>'',
             'categoria_descuento'=>0,
             'descripcion'=>'',
             'url'=>'mujer',
             'meta_titulo'=>'',
             'meta_descripcion'=>'',
             'meta_palabraclave'=>'',
             'status'=>1
            ],
            ['id'=>3,
             'parent_id'=>0,
             'section_id'=>1,
             'categoria_nombre'=>'Niños',
             'categoria_image'=>'',
             'categoria_descuento'=>0,
             'descripcion'=>'',
             'url'=>'niños',
             'meta_titulo'=>'',
             'meta_descripcion'=>'',
             'meta_palabraclave'=>'',
             'status'=>1
            ]

        ];
        Category::insert($categoryRecords);
    }
}
