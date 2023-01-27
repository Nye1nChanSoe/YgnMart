<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**categories */
    protected array $foods = ['bakery', 'fish', 'fruits', 'meat', 'pantry staples', 'snacks' ,'seafood', 'seasonings', 'vegetables'];
    protected array $beverages = ['alcohol', 'cold drinks', 'coffee', 'dairy', 'h2o', 'juice', 'milk', 'soft drinks', 'tea', 'water'];
    protected array $households = ['cleaning', 'paper', 'kitchen', 'personal care', 'medicine'];

    /** products */
    protected array $fruits = ['banana', 'apple', 'watermelon', 'orange', 'tangerine', 'onion'];
    protected array $alcohols = ['wine', 'beer', 'cocktails', 'vodka', 'rum', 'gin', 'whisky'];
    protected array $soft_drinks = ['coke', 'energy drinks', 'milk shake'];
    

    public function run()
    {
        /** to avoid unique items collision  */
        Category::truncate();
        Product::truncate();

        foreach($this->foods as $food) 
        {
            Category::factory()->create([
                'type' => 'food',
                'name' => ucwords($food),
                'slug' => strtolower(str_replace(' ', '_', $food))
            ]);
        }
        foreach($this->beverages as $beverage) 
        {
            Category::factory()->create([
                'type' => 'beverages',
                'name' => ucwords($beverage),
                'slug' => strtolower(str_replace(' ', '_', $beverage))
            ]);
        }
        foreach($this->households as $household) 
        {
            Category::factory()->create([
                'type' => 'households',
                'name' => ucwords($household),
                'slug' => strtolower(str_replace(' ', '_', $household))
            ]);
        }


        foreach($this->fruits as $fruit)
        {
            $name = ucfirst('fresh '.$fruit.' '.fake()->sentence(rand(6, 10)));
            Product::factory()->create([
                'name' => $name,
                'slug' => strtolower(str_replace(' ', '-', $name)),
                'meta_type' => strtolower($fruit),
                'image' => 'images/grocery/'.$fruit.'.jpeg',
            ]);
        }
        foreach($this->alcohols as $alcohol)
        {
            $name = ucfirst('imported '.$alcohol.' '.fake()->sentence(rand(6, 10)));
            Product::factory()->create([
                'name' => $name,
                'slug' => strtolower(str_replace(' ', '-', $name)),
                'meta_type' => strtolower($alcohol),
                // 'image' => 'images/grocery/'.$alcohol.'.jpeg',
            ]);
        }
        foreach($this->soft_drinks as $soft_drink)
        {
            $name = ucfirst($soft_drink.' '.fake()->sentence(rand(6, 10)));
            Product::factory()->create([
                'name' => $name,
                'slug' => strtolower(str_replace(' ', '-', $name)),
                'meta_type' => strtolower($soft_drink),
                // 'image' => 'images/grocery/'.$soft_drink.'.jpeg',
            ]);
        }
    }
}
