<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\NewsletterSubscriber;

class NewsletterSubscriberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subscribeeRecords = [
            [
                'id'=>1,
                'email'=>'rocio55@gmail.com',
                'status'=>1
            ],
            [
                'id'=>2,
                'email'=>'mario_g12@gmail.com',
                'status'=>1
            ]
        ];
        NewsletterSubscriber::insert($subscribeeRecords);
    }
}
