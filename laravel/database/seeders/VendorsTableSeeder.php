<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vendor;

class VendorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vendorRecords = [
            ['id'=>1,
            'nombre'=>'Joselyn',
            'direccion'=>'Simon Bolivar',
            'ciudad'=>'Ambato','estado'=>
            'Huachi Loreto',
            'pais'=>'Ecuador',
            'codigopin'=>'110001',
            'celular'=>'0983224564',
            'email'=>'joselynC@admin.com',
            'status'=>0]
        ];
        Vendor::insert($vendorRecords);
    }
}
