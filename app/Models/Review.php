<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Review extends Model
{
    use HasFactory;

    /**
    * to select reviews from the review table 
    * even if there are no reviews it will return back a table like this
    * 
    * --------------------
    * |  star  |  count  |
    * --------------------
    * |   1    |    0    |
    * |   2    |    0    |
    * |   3    |    0    |
    * |   4    |    0    |
    * |   5    |    0    |
    * ---------------------
    */
    public function scopeTotalProductRatings($query, $product)
    {
        $ratings = DB::table(DB::raw('(SELECT 1 AS stars UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5) AS stars_table'))
            ->leftJoin('reviews', function($join) use ($product) {
                $join->on('stars_table.stars', '=', 'reviews.rating')
                    ->where('reviews.product_id', '=', $product->id);
            })
            ->select(DB::raw('stars_table.stars, COALESCE(COUNT(reviews.rating), 0) AS count'))
            ->groupBy('stars_table.stars')
            ->get();

        return $ratings;
    }


    /** relations */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class)->withDefault();
    }
}
