<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;


    /** relations */
    public function products()
    {
        return $this->belongsToMany(Product::class)->withTimestamps();
    }

    public function categoryType()
    {
        return $this->belongsTo(CategoryType::class);
    }
}
