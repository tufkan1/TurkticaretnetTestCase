<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('orders')->insert([
            [
                'user_id' => 1,
                'total_amount' => 350.00,
                'status' => 'pending',
            ],
            [
                'user_id' => 2,
                'total_amount' => 150.00,
                'status' => 'completed',
            ],
        ]);
    }
}
