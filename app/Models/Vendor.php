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


    /**
     *
     */
    public function scopeSearch($query, $terms)
    {
        $query->when($terms['search'] ?? false, fn($query, $search) => $query
            ->where(fn($query) => $query
                ->whereHas('addresses', fn($query) => $query
                    ->where('street', 'like', "%{$search}%")
                    ->orWhere('ward', 'like', "%{$search}%")
                    ->orWhere('township', 'like', "%{$search}%")
                )
                ->orWhere('name', 'like', "%{$search}%")
                ->orWhere('username', 'like', "%{$search}%")
                ->orWhere('role', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('user_status', 'like', "{$search}%")
                ->orWhere('created_at', 'like', "%{$search}%")
                ->orWhere('phone_number', 'like', "%{$search}%")
            )
        );

        return $query;
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
