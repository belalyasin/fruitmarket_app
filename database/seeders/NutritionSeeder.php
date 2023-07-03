<?php

namespace Database\Seeders;

use App\Models\Nutrition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NutritionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Nutrition::factory(5)->create();
    }
}
