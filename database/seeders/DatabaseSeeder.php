<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\CategoryType;
use App\Models\CategoryTypes;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**categories */
    private array $foods = ['bakery', 'fish', 'fruits', 'meat', 'pantry staples', 'snacks' ,'seafood', 'seasonings', 'vegetables'];
    private array $beverages = ['alcohol', 'cold drinks', 'coffee', 'dairy', 'h2o', 'juice', 'milk', 'soft drinks', 'tea', 'water'];
    private array $households = ['cleaning', 'paper', 'kitchen', 'personal care', 'medicine'];

    /** products */
    private array $fruits = ['banana', 'apple', 'watermelon', 'orange', 'tangerine', 'onion'];
    private array $alcohols = ['wine', 'beer', 'cocktails', 'vodka', 'rum', 'gin', 'whisky', 'tonic', 'soda', 'gold', 'black', 'white', 'blue', 'fire', 'ice'];
    private array $soft_drinks = ['coke', 'energy drinks', 'milk shake', 'orange juice', 'apple juice', 'vanilla cider', 'apple cide', 'pepsi', '100 plus', 'red bull', 'monster', 'coffee'];
    

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
        User::truncate();
        Category::truncate();
        Product::truncate();

        /** TODO: delete later */
        User::create([
            'name' => 'Nyein Chan Soe',
            'username' => 'admin',
            'role' => 'user',
            'email' => 'admin@email.com',
            'phone_number' => '091231233',
            'password' => 'password',
            'user_status' => 'active',
        ]);

        /** seeding categories */
        foreach($this->foods as $food) 
        {
            Category::factory()->create([
                'type' => 'Food',
                'sub_type' => ucwords($food),
            ]);
        }
        foreach($this->beverages as $beverage) 
        {
            Category::factory()->create([
                'type' => 'Beverages',
                'sub_type' => ucwords($beverage),
            ]);
        }
        foreach($this->households as $household) 
        {
            Category::factory()->create([
                'type' => 'Household',
                'sub_type' => ucwords($household),
            ]);
        }

        /** seeding products */
        foreach($this->fruits as $fruit)
        {
            $name = ucfirst('fresh '.$fruit.' '.rtrim(fake()->sentence(rand(4, 6)), '.'));
            $product = Product::factory()->create([
                'name' => $name,
                'slug' => strtolower(str_replace(' ', '-', $name)),
                'meta_type' => strtolower($fruit),
                'image' => 'images/grocery/'.$fruit.'.jpeg',
            ]);

            $categories = Category::where('sub_type', 'fruits')->get();
            $product->categories()->sync($categories);
        }
        foreach($this->alcohols as $alcohol)
        {
            $name = ucfirst('imported '.$alcohol.' '.rtrim(fake()->sentence(rand(4, 6)), '.'));
            $product = Product::factory()->create([
                'name' => $name,
                'slug' => strtolower(str_replace(' ', '-', $name)),
                'meta_type' => strtolower($alcohol),
                // 'image' => 'images/grocery/'.$alcohol.'.jpeg',
            ]);
            $categories = Category::where('sub_type', 'alcohol')->get();
            $product->categories()->sync($categories);
        }
        foreach($this->soft_drinks as $soft_drink)
        {
            $name = ucfirst($soft_drink.' '.rtrim(fake()->sentence(rand(4, 6)), '.'));
            $product = Product::factory()->create([
                'name' => $name,
                'slug' => strtolower(str_replace(' ', '-', $name)),
                'meta_type' => strtolower($soft_drink),
                // 'image' => 'images/grocery/'.$soft_drink.'.jpeg',
            ]);
            $categories = Category::where('sub_type', 'soft drinks')->get();
            $product->categories()->sync($categories);
        }
    }
}
