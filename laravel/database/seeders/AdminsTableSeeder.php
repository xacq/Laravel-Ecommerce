<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRecords = [
            ['id' =>2, 
            'nombre'=>'Joselyn',
            'tipo'=>'vendedor',
            'vendor_id'=>1,
            'celular'=>'0983224564',
            'email'=>'joselynC@admin.com',
            'password'=>'$2a$12$Y/5z0LT6EhZ1z/nkgaadTuMWWtcQOGDzafx0Hn1l.DbQyGzSvH.fa',
            'imagen'=>'',
            'status'=>0]
        ];
        Admin::insert($adminRecords);
    }
}
