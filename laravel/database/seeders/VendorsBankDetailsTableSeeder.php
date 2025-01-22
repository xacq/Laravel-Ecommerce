<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VendorsBankDetail;

class VendorsBankDetailsTableSeeder extends Seeder
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
            'cuenta_personal_name'=>'Joselyn Ortega',
            'banco_name'=>'Bancho Pichincha',
            'cuenta_numero'=>'2206645532',
            'banco_ifsc_code'=>'12345'
        ];
        VendorsBankDetail::insert($vendorRecords);
    }
}
