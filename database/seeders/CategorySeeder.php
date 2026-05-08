<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Frozen Food',
                'description' => 'Produk makanan beku',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ice Cream',
                'description' => 'Produk es krim',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
