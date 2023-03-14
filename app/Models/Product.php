<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // For Future References 
    // https://laravel.com/docs/10.x/queries#logical-grouping
    // https://laravel.com/docs/10.x/queries#advanced-where-clauses
    // https://laravel.com/docs/10.x/eloquent-relationships#querying-relationship-existence
    // https://laravel.com/docs/10.x/collections#method-when

    /**
     * Common query logic for searching products based on name, meta_type and description
     * 
     * @param Illuminate\Database\Query\Builder $query query builder instance to add additional constraints to the query
     * @param array $term the search term
     */
    public function scopeFilter($query, $terms)
    {
        $terms = array_map(fn($term) => str_replace('-', '', $term), $terms);

        $query->when($terms['search'] ?? false, fn($query, $search) => $query
            ->where(fn($query) => $query
                ->where('name', 'like', "%{$search}%")
                ->orWhere('meta_type', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhereHas('categories', fn($query) => $query          /** categories is the name of the relationship defined */
                    ->where('type', 'like', "%{$search}%")
                    ->orWhere('sub_type', 'like', "%{$search}%")
                )
            )
        );

        $query->when($terms['category'] ?? false, fn($query, $category) => $query
            ->whereHas('categories', fn($query) => $query
                ->where('type', 'like', "%{$category}%")
                ->orWhere('sub_type', 'like', "%{$category}%")
            )
        );
    }
    
    /** relations */
    public function categories()
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity')->withTimestamps();
    }
}
