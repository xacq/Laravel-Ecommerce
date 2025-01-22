<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Section;

class SectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sectionRecords = [
            ['id'=>1,'nombre'=>'Ropa','status'=>1],
            ['id'=>2,'nombre'=>'Accesorios','status'=>1],
            ['id'=>3,'nombre'=>'Arreglos','status'=>1],
        ];
        Section::insert($sectionRecords);
    }
}
