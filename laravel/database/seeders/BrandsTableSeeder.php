<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brandRecords = [
            ['id'=>1,'nombre'=>'Samsung','status'=>1],
            ['id'=>2,'nombre'=>'LG','status'=>1],
            ['id'=>3,'nombre'=>'Apple','status'=>1],
            ['id'=>4,'nombre'=>'Honor','status'=>1]
        ];
        Brand::insert($brandRecords);
    }
}
