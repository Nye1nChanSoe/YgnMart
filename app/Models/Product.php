<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /** mass assignable */
    protected $guarded = [];

    /**
     * Common query logic for searching products based on name, meta_type and description
     * 
     * @param Illuminate\Database\Query\Builder $query query builder instance to add additional constraints to the query
     * @param array $term the search term
     */
    public function scopeFilter($query, $terms)
    {
        // For Future References 
        // https://laravel.com/docs/10.x/queries#logical-grouping
        // https://laravel.com/docs/10.x/queries#advanced-where-clauses
        // https://laravel.com/docs/10.x/eloquent-relationships#querying-relationship-existence
        // https://laravel.com/docs/10.x/collections#method-when
        // ctype_digit($value) - Returns true if every character in the string text is a decimal digit
        
        $query->when($terms['search'] ?? false, fn($query, $search) => $query
            ->where(fn($query) => $query
                ->where('name', 'like', "%{$search}%")
                ->orWhere('meta_type', 'like', "%{$search}%")
                ->when(ctype_digit($search), fn($query) => $query
                    ->orwhereBetween('price', [$search, $search + 100])
                )
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhereHas('categories', fn($query) => $query          /** categories is the name of the relationship defined */
                    ->where('type', 'like', "%{$search}%")
                    ->orWhere('sub_type', 'like', "%{$search}%")
                )
                ->orWhereHas('inventory.vendor', fn($query) => $query
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                )
            )
        );

        $query->when($terms['category'] ?? false, fn($query, $category) => $query
            ->whereHas('categories', fn($query) => $query
                ->where('type', 'like', "%{$category}%")
                ->orWhere('sub_type', 'like', "%{$category}%")
            )
        );

        return $query;
    }


    /**
     * get all the related products of the specified product except the product itself
     * 
     * @param Illuminate\Database\Query\Builder $query query builder instance to add additional constraints to the query
     * @param Product $relateProduct the base product you want to relate with other products 
     * @param int $limit set the return result set limit
     * @param boolean $intRandomOrder the result set is returned in random order or not
     */
    public function scopeRelatedProducts($query, $relateProduct, $limit = 10, $inRandomOrder = true)
    {
        $query = $query->whereHas('categories', function ($query) use ($relateProduct) {
            $query->whereHas('products', function($query) use ($relateProduct) {
                $query->where('id', '=', $relateProduct->id);
            });
        })
        ->where('id', '<>', $relateProduct->id);

        if($inRandomOrder) 
        {
            $query = $query->inRandomOrder();
        }

        return $query->take($limit);
    }
    
    /** relations */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity')->withTimestamps();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function analytic()
    {
        return $this->hasMany(ProductAnalytic::class);
    }
}
