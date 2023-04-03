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

    public function scopeSearch($query, $terms)
    {
        $query->when($terms['search'] ?? false, fn($query, $search) => $query
            ->where(fn($query) => $query
                ->whereHas('order.products', fn($query) => $query
                    ->where('order_code', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('meta_type', 'like', "%{$search}%")
                    ->when(ctype_digit($search), fn($query) => $query
                        ->orWhereRaw('price * order_product.quantity BETWEEN ? AND ?', [$search, $search + 1000])
                    )
                )
                ->orWhere('payment_type', 'like', "%{$search}%")
                ->orWhere('currency', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%")
                ->when(ctype_digit($search), fn($query) => $query
                    ->orWhereRaw('gross_amount - tax BETWEEN ? AND ?', [$search, $search + 1000])
                )
            )
        );

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
