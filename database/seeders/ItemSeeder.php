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
                'satuan' => 'pcs',
                'description' => 'Nugget ayam beku',
                'photo' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Vanilla Ice Cream',
                'category_id' => 2,
                'stock' => 30,
                'satuan' => 'box',
                'description' => 'Es krim vanilla',
                'photo' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}