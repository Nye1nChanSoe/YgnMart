<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [];

    /**
     * The attributes that are not mass assignable
     * Set guarded to empty so the user's attributes are mass assignable
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


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


    /**
     * Accessors and Mutators
     * Encrypt the password at the last stage
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }


    /** relations */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function checkout()
    {
        return $this->hasOne(Checkout::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
