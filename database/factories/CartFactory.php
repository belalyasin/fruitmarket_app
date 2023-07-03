<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cart>
 */
class CartFactory extends Factory
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
            "count"=>$this->faker->randomDigitNotZero(),
            "total"=>$this->faker->randomFloat(),
            "user_id"=>$this->faker->randomDigitNotZero(),
            "product_id"=>$this->faker->randomDigitNotZero(),
        ];
    }
}
