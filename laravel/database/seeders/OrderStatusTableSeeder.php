<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OrderStatus;

class OrderStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orderStatusRecords = [
            ['id'=>1,'nombre'=>'Nuevo','status'=>1],
            ['id'=>2,'nombre'=>'Pendiente','status'=>1],
            ['id'=>3,'nombre'=>'Cancelado','status'=>1],
            ['id'=>4,'nombre'=>'En proceso','status'=>1],
            ['id'=>5,'nombre'=>'Enviado','status'=>1],
            ['id'=>6,'nombre'=>'Enviado parcialmente','status'=>1],
            ['id'=>7,'nombre'=>'Delivery','status'=>1],
            ['id'=>8,'nombre'=>'Delivery parcialmente','status'=>1],
            ['id'=>9,'nombre'=>'Pagado','status'=>1],
        ];
        OrderStatus::insert($orderStatusRecords);
    }
}
