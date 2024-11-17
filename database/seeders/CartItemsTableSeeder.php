<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CartItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cart_items')->insert([
            [
                'cart_id' => 1,
                'product_id' => 1,
                'quantity' => 2,
                'price' => 100.00,
            ],
            [
                'cart_id' => 1,
                'product_id' => 2,
                'quantity' => 1,
                'price' => 150.00,
            ],
        ]);
    }
}
