<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Product::create([
        'name' => 'Xiaomi redmi s2',
        'description' => 'Ram 32GB Camera 8Mp',
        'price' => '55.00',
        'sub_category_id' => '1',
        'user_id'=>'1'
       ]);
       Product::create([
        'name' => 'Samsung Note20',
        'description' => 'Ram 32GB Camera 12 MP + 64 MP',
        'price' => '120.00',
        'sub_category_id' => '1',
        'user_id'=>'1'
       ]);
       Product::create([
        'name' => 'Men Jacket',
        'description' => 'Mens Lined Shirt Jacket',
        'price' => '34',
        'sub_category_id' => '3',
        'user_id'=>'1'
       ]);
       Product::create([
        'name' => 'Women Dress',
        'description' => 'Summer Casual Long Dress.',
        'price' => '1200',
        'sub_category_id' => '4',
        'user_id'=>'1'
       ]);
       Product::create([
        'name' => 'women T-Shirt',
        'description' => 'White T-shirt for women.',
        'price' => '1200',
        'sub_category_id' => '4',
        'user_id'=>'1'
       ]);
    }
}
