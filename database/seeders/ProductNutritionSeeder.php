<?php

namespace Database\Seeders;

use App\Models\Product_Nutrition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductNutritionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Product_Nutrition::factory(5)->create();
    }
}
