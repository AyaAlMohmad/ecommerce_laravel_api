<?php

namespace Database\Seeders;

use App\Models\SubCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SubCategory::create([
            'name' => 'phones',
            'category_id' => '1',
            'user_id'=>'1'
        ]);
        SubCategory::create([
            'name' => 'screen',
            'category_id' => '1',
            'user_id'=>'1'
        ]);
        SubCategory::create([
            'name' => 'men',
            'category_id' => '2',
            'user_id'=>'1'
        ]);

        SubCategory::create([
            'name' => 'women',
            'category_id' => '2',
            'user_id'=>'1'
        ]);
        SubCategory::create([
            'name' => 'kids',
            'category_id' => '2',
            'user_id'=>'1'
        ]);
       
    }
}
