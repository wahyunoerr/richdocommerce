<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name' => 'Smartphone X',
                'description' => 'Smartphone terbaru dengan fitur canggih.',
                'price' => 3500000,
                'stok' => 100,
                'image' => 'smartphone.jpg',
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kaos Polos',
                'description' => 'Kaos polos nyaman untuk sehari-hari.',
                'price' => 50000,
                'stok' => 200,
                'image' => 'kaos.jpg',
                'category_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Keripik Kentang',
                'description' => 'Cemilan renyah dan gurih.',
                'price' => 15000,
                'stok' => 300,
                'image' => 'keripik.jpg',
                'category_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
