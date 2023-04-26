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
        $startDate = Carbon::parse('2023-03-25'); 
        $endDate = Carbon::parse('2023-04-2'); 

        $createdAt = Carbon::parse('2023-03-25 00:00:00');

        while($startDate->lte($endDate))
        {
            ProductAnalytic::factory(33)->create([
                'date' => $startDate,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
            $startDate->addDay();       // increment the date by one day
            $createdAt->addDay();
        }

    }
}
