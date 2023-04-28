<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    private array $vendors = [
        'tastetemptations_ygn_outlet' =>'Taste Temptations',
        'beveragebliss' =>'Beverage Bliss',
        'kitchengourmet' =>'Kitchen Gourmet',
        'yangon_pantrypalace' =>'Pantry Palace',
        'household_harmony' =>'Household Harmony',
        'dinede_lights' =>'Dine Delights',
        'sip_savor' =>'Sip Savor',
        'ygn_satisfysupplies' =>'Satisfy Supplies',
        'tastetraders' =>'Taste Traders',
        'rangoon_homesolutions' =>'Home Solutions',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->vendors as $username => $brand)
        {
            Vendor::factory()->create([
                'username' => $username,
                'brand' => $brand,
                'email' => str_replace(' ', '', $brand) . '@email.com',
            ]);
        }
    }
}
