<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\CategoryType;
use App\Models\CategoryTypes;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /** category_types */
    private array $categoryTypes = ['food', 'beverages', 'households'];

    /**categories */
    private array $foods = ['bakery', 'fish', 'fruits', 'meat', 'pantry staples', 'snacks' ,'seafood', 'seasonings', 'vegetables'];
    private array $beverages = ['alcohol', 'cold drinks', 'coffee', 'dairy', 'h2o', 'juice', 'milk', 'soft drinks', 'tea', 'water'];
    private array $households = ['cleaning', 'paper', 'kitchen', 'personal care', 'medicine'];

    /** products */
    private array $fruits = ['banana', 'apple', 'watermelon', 'orange', 'tangerine', 'onion'];
    private array $alcohols = ['wine', 'beer', 'cocktails', 'vodka', 'rum', 'gin', 'whisky'];
    private array $soft_drinks = ['coke', 'energy drinks', 'milk shake'];
    

    public function run()
    {
        /**
         * Warning:
         * Truncate a Foreign Key Constrained table  
         * To work around this, use either of these solutions. Both present risks of damaging the data integrity.
         * SET FOREIGN_KEY_CHECKS=1 is not necessary No, you don't. The setting is only valid during the connection. 
         * As soon as you disconnect, the next connection will have it set back to 1
         * 
         * This is just to populate a few records to the database for testing purposes.
         */
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');    


        /** to avoid unique items collision when seeding again */
        CategoryType::truncate();
        Category::truncate();
        Product::truncate();


        /** seeding categoryTypes */
        foreach($this->categoryTypes as $categoryType)
        {
            CategoryType::create([
                'type' => $categoryType
            ]);
        }

        /** seeding categories */
        foreach($this->foods as $food) 
        {
            Category::factory()->create([
                'name' => ucwords($food),
                'category_type_id' => CategoryType::find(1),
            ]);
        }
        foreach($this->beverages as $beverage) 
        {
            Category::factory()->create([
                'name' => ucwords($beverage),
                'category_type_id' => CategoryType::find(2),
            ]);
        }
        foreach($this->households as $household) 
        {
            Category::factory()->create([
                'name' => ucwords($household),
                'category_type_id' => CategoryType::find(3),
            ]);
        }

        /** seeding products */
        foreach($this->fruits as $fruit)
        {
            $name = ucfirst('fresh '.$fruit.' '.fake()->sentence(rand(6, 10)));
            $product = Product::factory()->create([
                'name' => $name,
                'slug' => strtolower(str_replace(' ', '-', $name)),
                'meta_type' => strtolower($fruit),
                'image' => 'images/grocery/'.$fruit.'.jpeg',
            ]);

            $categories = Category::where('name', 'fruits')->get();
            $product->categories()->sync($categories);
        }
        foreach($this->alcohols as $alcohol)
        {
            $name = ucfirst('imported '.$alcohol.' '.fake()->sentence(rand(6, 10)));
            $product = Product::factory()->create([
                'name' => $name,
                'slug' => strtolower(str_replace(' ', '-', $name)),
                'meta_type' => strtolower($alcohol),
                // 'image' => 'images/grocery/'.$alcohol.'.jpeg',
            ]);
            $categories = Category::where('name', 'alcohol')->get();
            $product->categories()->sync($categories);
        }
        foreach($this->soft_drinks as $soft_drink)
        {
            $name = ucfirst($soft_drink.' '.fake()->sentence(rand(6, 10)));
            $product = Product::factory()->create([
                'name' => $name,
                'slug' => strtolower(str_replace(' ', '-', $name)),
                'meta_type' => strtolower($soft_drink),
                // 'image' => 'images/grocery/'.$soft_drink.'.jpeg',
            ]);
            $categories = Category::where('name', 'soft drinks')->get();
            $product->categories()->sync($categories);
        }
    }
}
