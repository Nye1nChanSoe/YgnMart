<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;


    /**
     *
     */
    public function scopeSearch($query, $terms)
    {
        $query->when($terms['search'] ?? false, fn($query, $search) => $query
            ->where('type', 'like', "%{$search}%")
            ->orWhere('sub_type', 'like', "%{$search}%")
            ->orWhere('description', 'like', "%{$search}%")
        );

        return $query;
    }


    /** relations */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
