<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VendorsBusinessDetail;

class VendorsBusinessDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vendorRecords = [
            'id'=>1,
            'vendor_id'=>1,
            'nombre_tienda'=>'Flore Eternas Shop Joselyn',
            'direccion_tienda'=>'Simon Bolivar',
            'ciudad_tienda'=>'Ambato',
            'estado_tienda'=>'Huachi Loreto',
            'pais_tienda'=>'Ecuador',
            'codigopin_tienda'=>'110001',
            'celular_tienda'=>'0987664352',
            'sitioweb_tienda'=>'no',
            'email_tienda'=>'joselynC@admin.com',
            'address_proof'=>'pasaporte',
            'address_proof_image'=>'test.jpg',
            'business_licencia_numero'=>'12345',
            'usd_moneda'=>'12345',
            'pan_number'=>'12345'
        ];
        VendorsBusinessDetail::insert($vendorRecords);
    }
}
