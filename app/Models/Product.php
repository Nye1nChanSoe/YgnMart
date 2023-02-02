<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    
    /** relations */
    public function categories()
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
