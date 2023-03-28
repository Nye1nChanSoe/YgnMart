<?php

namespace App\Models;

use App\Events\UpdateDefaultAddress;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getFullAddressAttribute()
    {
        return "{$this->street}, {$this->ward}, {$this->township}";
    }

    /** relations */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** override boot method to listen for when a default address is saved */
    protected static function boot()
    {
        parent::boot();

        /** 
         * Createss an event listener that listens for the saved event on this Address model 
         * When an address is saved, the closure function is executed
         */
        static::saved(function($address) {
            if($address->is_default) {
                /** fires a new event with the saved address as a parameter, 
                 * will be picked up the UpdateDefaultAddressListener 
                 * */
                event(new UpdateDefaultAddress($address));
            }
        });
    }
}
