<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductAnalytic>
 */
class ProductAnalyticFactory extends Factory
{
    protected static int $i = 0;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'product_id' => static::$i++ >= 33 ? static::$i = 1 : static::$i,
            'view' => mt_rand(2946, 3250),           // Mersenne Twister algorithm, which is a popular pseudo-random number generator that produces high-quality random numbers with a long period.
            'cart' => mt_rand(1035, 1164),
            'checkout' => mt_rand(416, 485),
            'order' => mt_rand(225, 294),
            'review' => mt_rand(0, 0),
            'quantity' => mt_rand(2623, 2670),
            'revenue' => mt_rand(4042305, 4842305),
        ];
    }
}
