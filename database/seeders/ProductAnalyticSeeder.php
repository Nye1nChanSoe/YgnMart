<?php

namespace Database\Seeders;

use App\Models\ProductAnalytic;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductAnalyticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * For March
         */
        $startDate = Carbon::parse('2023-03-01'); 
        $endDate = Carbon::parse('2023-03-31'); 
        $product_id = 1;

        while($startDate->lte($endDate))
        {
            ProductAnalytic::factory(33)->create([
                'date' => $startDate
            ]);
            $startDate->addDay();       // increment the date by one day
        }

    }
}
