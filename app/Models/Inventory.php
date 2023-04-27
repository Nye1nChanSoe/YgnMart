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


    /**
     *
     */
    public function scopeSearch($query, $terms)
    {
        $query->when($terms['search'] ?? false, fn($query, $search) => $query
            ->where(fn($query) => $query
                ->whereHas('product', fn($query) => $query
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('meta_type', 'like', "%{$search}%")
                    ->when(ctype_digit($search), fn($query) => $query
                        ->orwhereBetween('price', [$search, $search + 100])
                    )
                )
                ->orWhereHas('product.categories', fn($query) => $query
                    ->where('type', 'like', "%{$search}%")
                    ->orWhere('sub_type', 'like', "%{$search}%")
                )
                ->orWhere('sku', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%")
                ->when(ctype_digit($search), fn($query) => $query
                    ->orwhereBetween('in_stock_quantity', [$search, $search + 100])
                    ->orwhereBetween('minimum_quantity', [$search, $search + 100])
                    ->orwhereBetween('available_quantity', [$search, $search + 100])
                )
            )
        );

        return $query;
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
