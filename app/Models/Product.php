<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;


    /**
     * Common query logic for searching products based on name, meta_type and description
     * 
     * @param QueryBuilder $query to add additional constraints to the query
     * @param string|array $term the search term
     */
    public function scopeFilter($query, $term)
    {
        if($term)
        {
            return $query->where(fn($q) => $q->where('name', 'like', '%'.$term.'%')
                ->orWhere('meta_type', 'like', '%'.$term.'%')
                ->orWhere('description', 'like', '%'.$term.'%')
                ->orWhereHas('categories', fn($q) => $q->where('type', 'like', '%'.$term.'%')
                    ->orWhere('sub_type', 'like', '%'.$term.'%')
                )
            );
        }

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
