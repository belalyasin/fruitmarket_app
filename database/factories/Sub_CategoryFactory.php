<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sub_Category>
 */
class Sub_CategoryFactory extends Factory
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
            "title"=>$this->faker->name,
            "discount"=>$this->faker->randomDigitNotNull(),
            "description"=>$this->faker->word(),
            "category_id"=>$this->faker->randomDigitNotZero(),
        ];
    }
}
