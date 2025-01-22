<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Coupon;

class CouponsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $couponRecords = [
            [
                'id' => 1,
                'vendor_id' => 0,
                'cupon_opcion' => 'Manual',
                'cupon_codigo' => 'test10',
                'categorias' => '1',
                'users' => '',
                'cupon_tipo' => 'soltera',
                'amount_tipo' => 'Porcentaje',
                'amount' => 10,
                'fecha_caducidad' => '2024-08-26', // Cambiado a YYYY-MM-DD
                'status' => 1
            ],
            [
                'id' => 2,
                'vendor_id' => 3,
                'cupon_opcion' => 'Manual',
                'cupon_codigo' => 'test20',
                'categorias' => '1',
                'users' => '',
                'cupon_tipo' => 'soltero',
                'amount_tipo' => 'Porcentaje',
                'amount' => 20,
                'fecha_caducidad' => '2024-08-26', // Cambiado a YYYY-MM-DD
                'status' => 1
            ]
        ];
        
        Coupon::insert($couponRecords);
    }
}
