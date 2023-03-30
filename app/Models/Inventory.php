<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getInStockAttribute()
    {
        return $this->available_quantity > 200;
    }

    public function getLowStockAttribute()
    {
        return $this->available_quantity > 0 && $this->available_quantity <= 200;
    }

    public function getOutOfStockAttribute()
    {
        return $this->available_quantity <= 0;
    }


    /** relatins */
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function product()
    {
        /**
         * each product can relate with many inventory records since many vendors
         * can sell the same product with different variants such as price, color...`
         */
        return $this->hasOne(Product::class);    
    }
}
