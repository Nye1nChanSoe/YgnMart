<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Support\Facades\Cache;

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
                ->where('brand', 'like', "%{$search}%")
                ->orWhere('username', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('status', 'like', "{$search}%")
                ->orWhere('created_at', 'like', "%{$search}%")
                ->orWhere('phone_number', 'like', "%{$search}%")
                ->orWhere(function($query) use ($search) {
                    if($search == 'verified') {
                        $query->where('is_verified', true);
                    } else if ($search == 'not verified') {
                        $query->where('is_verified', false);
                    }
                })
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
