<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rating;

class RatingsTableSedeer extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ratingRecords = [
            [
                'id'=>1,
                'user_id'=>6,
                'product_id'=>19,
                'opiniones'=>'Son flores hermosas, hechas a mano',
                'clasificacion'=>5,
                'status'=>1
            ],
            [
                'id'=>2,
                'user_id'=>6,
                'product_id'=>19,
                'opiniones'=>'Unas flores muy bonitas, excelente servicio',
                'clasificacion'=>5,
                'status'=>1
            ],
            [
                'id'=>3,
                'user_id'=>4,
                'product_id'=>4,
                'opiniones'=>'Son camisetas comodas, y diseños bonitos',
                'clasificacion'=>5,
                'status'=>1
            ]
        ];
        Rating::insert($ratingRecords);
    }
}
