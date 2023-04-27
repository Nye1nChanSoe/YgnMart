<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{

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
        Vendor::truncate();
        Inventory::truncate();

        User::create([
            'name' => 'Nyein Chan Soe',
            'username' => 'nye1n_chan',
            'role' => 'admin',
            'email' => 'admin@email.com',
            'phone_number' => '091231233',
            'password' => 'password',
        ]);

        Vendor::create([
            'username' => 'ygn_mart_official',
            'brand' => 'Yangon Mart',
            'email' => 'vendor@ygnmart.com',
            'phone_number' => '0951260235',
            'password' => 'password',
            'is_verified' => true,
        ]);


        $this->call([
            CustomerSeeder::class,
            VendorSeeder::class,
            ProductSeeder::class,
            ProductAnalyticSeeder::class,
            // UserAnalyticSeeder::class,
        ]);
    }
}
