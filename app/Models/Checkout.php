<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasFactory;

    /** allows mass assignable */
    protected $guarded = [];

    /** relations */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
