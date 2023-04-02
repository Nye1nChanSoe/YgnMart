<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductAnalytic extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function scopeFilter($query, $format = 'day')
    {
        $query->select(DB::raw('DATE_FORMAT(date, "%d %b") as day'),
                DB::raw('SUM(view) as view'),
                DB::raw('SUM(cart) as cart'),
                DB::raw('SUM(checkout) as checkout'),
                DB::raw('SUM(`order`) as `order`'),
                DB::raw('SUM(review) as review'),
                DB::raw('SUM(quantity) as quantity'),
                DB::raw('SUM(revenue) as revenue'))
            ->groupBy('day')
            ->orderBy('day', 'asc');

        return $query;
    }

    /** relations */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
