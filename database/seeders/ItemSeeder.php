<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('items')->insert([
            [
                'name' => 'Chicken Nugget',
                'category_id' => 1,
                'stock' => 50,
                'minimum_stock' => 10,
                'unit' => 'pcs', 
                'selling_price' => 15000,
                'purchase_price' => 10000,
                'description' => 'Nugget ayam beku',
                'photo' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Vanilla Ice Cream',
                'category_id' => 2,
                'stock' => 30,
                'minimum_stock' => 5,
                'unit' => 'box',   
                'selling_price' => 25000,
                'purchase_price' => 18000,
                'description' => 'Es krim vanilla',
                'photo' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}