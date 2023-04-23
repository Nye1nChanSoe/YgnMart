<?php

namespace App\Traits;

use App\Models\Product;
use App\Models\ProductAnalytic;

trait ProductAnalyticTrait
{
    /**
     * @param Product $product
     * @param string $increment - The name of the column that should be incremented
     *                            'view'  'cart'  'order'  'review'
     * @param array $data - Optional data to be updated
     */
    public function dailyProductStats(Product $product, string $increment, array $data = [])
    {
        /** get the latest record for the product */
        $latestRecord = ProductAnalytic::where('product_id', $product->id)
            ->orderBy('date', 'desc')
            ->first();

        $today = now()->startOfDay();

        if($latestRecord && $latestRecord->created_at->lt($today))
        {
            /** if the lastest record is from pevious day, insert a new record */
            ProductAnalytic::create([
                'product_id' => $product->id,
                $increment => 1
            ]);
        }
        elseif (!$latestRecord)
        {
            /** if there are no records for the product, insert a new record */
            ProductAnalytic::create([
                'product_id' => $product->id,
                $increment => 1
            ]);
        }
        else
        {
            /** if the lastest record is from today, update the view count */
            if(!empty($data))
            {
                $latestRecord->update($data);
            }

            $latestRecord->increment($increment);
        }
    }
}