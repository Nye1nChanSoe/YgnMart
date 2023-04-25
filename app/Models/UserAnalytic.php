<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserAnalytic extends Model
{
    use HasFactory;

    /** mass assignable */
    protected $guarded = [];

    public function scopeFilter($query, $format = 'day', $unique = false)
    {
        if($unique) {
            $query->select(DB::raw('DATE_FORMAT(date, "%d %b") as day'),
                    DB::raw('COUNT(DISTINCT user_id) as unique_users'),
                    DB::raw('SUM(DISTINCT unique_page_views) as unique_views'))
                ->groupBy('date')
                ->orderBy('date', 'asc');
        } else {
            $query->select(DB::raw('DATE_FORMAT(date, "%d %b") as day'),
                    DB::raw('COUNT(*) as users'),
                    DB::raw('SUM(page_views) as views'))
                ->groupBy('date')
                ->orderBy('date', 'asc');
        }

        return $query;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
