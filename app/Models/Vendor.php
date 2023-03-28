<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticable;

class Vendor extends Authenticable
{
    use HasFactory;

    protected $guarded = [];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    /** relations */
    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
