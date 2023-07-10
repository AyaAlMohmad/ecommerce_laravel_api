<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'electronic',
            'user_id'=>'1'
        ]);

        Category::create([
            'name' => 'clothes',
            'user_id'=>'1'
        ]);
        Category::create([
            'name' => 'cars',
            'user_id'=>'1'
        ]);
    }
}
