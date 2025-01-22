<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DeliveryAddress;

class DeliveryAddressTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $deliveryRecords = [
            [
                'id'=>1,
                'user_id'=>1,
                'nombre'=>'Micaela Chaglla',
                'direccion'=>'Ficoa',
                'ciudad'=>'Ambato',
                'estado'=>'Ficoa',
                'pais'=>'Ecuador',
                'pincodigo'=>001,
                'celular'=>'0987441225',
                'status'=>1,
            ],
            [
                'id'=>2,
                'user_id'=>1,
                'nombre'=>'Micaela Chaglla',
                'direccion'=>'Ficoa',
                'ciudad'=>'Ambato',
                'estado'=>'Ficoa',
                'pais'=>'Peru',
                'pincodigo'=>002,
                'celular'=>'0952653254',
                'status'=>1,
            ],
        ];
        DeliveryAddress::insert($deliveryRecords);
    }
}
