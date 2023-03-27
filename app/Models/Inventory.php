<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

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
        return $this->belongsTo(Product::class);    
    }
}
