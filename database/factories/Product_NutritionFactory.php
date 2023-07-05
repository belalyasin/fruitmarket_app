<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product_Nutrition>
 */
class Product_NutritionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            "product_id" => $this->faker->randomDigitNotZero(),
            "nutrition_id" => $this->faker->randomDigitNotZero(),
        ];
    }
}
