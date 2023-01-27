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
    public function definition()
    {
        $name = fake()->sentence(rand(6, 10));
        return [
            'name' => $name,
            'slug' => strtolower(str_replace(' ', '-', $name)),
            'meta_type' => fake()->word(),
            'price' => rand(1000, 25000),
            'description' => fake()->paragraphs(3, true),
        ];
    }
}
