<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
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
            "name"=>$this->faker->name(),
            "price"=>$this->faker->randomFloat(),
            "rate"=>$this->faker->randomElement(["0","1","2","3","4","5"]),
            "description"=>$this->faker->word(),
            "isFavorite"=>$this->faker->boolean(),
            "sub__category_id"=>$this->faker->randomDigitNotZero(),
        ];
    }
}
