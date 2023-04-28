<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'order_code' => 'c' . Carbon::now()->format('yds') . strtolower(Str::random('3')),
            'user_id' => rand(3, 50),
            'payment_type' => 'cash',
            'total_price' => rand(5740, 13400),
            'description' => 'Payment test description',
        ];
    }
}
