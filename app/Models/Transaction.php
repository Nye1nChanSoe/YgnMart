<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transaction extends Model
{
    use HasFactory;

    public function getNetRevenueAttribute()
    {
        return $this->gross_amount - ($this->tax + $this->other_fees);
    }

    /**
     * Filter the transactions
     */
    public function scopeFilter($query, $format = 'day')
    {
        $query->select(
                DB::raw('DATE_FORMAT(created_at, "%d %b") as day'), 
                DB::raw('SUM(gross_amount) as revenue'))
            ->groupBy(DB::raw('day'))
            ->where('vendor_id', auth()->guard('vendor')->id());
        
        return $query;
    }


    /** relations */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
