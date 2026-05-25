<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = [
        'name',
        'banner_image',
        'percentage',
        'active_days',
        'active_months',
        'is_active'
    ];

    public static function getCurrentDiscount()
    {
        $today = now();
        $dayName = $today->format('l'); // e.g. "Monday"
        $monthNum = $today->month; // e.g. 5 for May

        return self::where('is_active', true)
            ->where(function($query) use ($dayName, $monthNum) {
                $query->whereNull('active_days')
                      ->orWhere('active_days', 'like', "%$dayName%");
            })
            ->where(function($query) use ($monthNum) {
                $query->whereNull('active_months')
                      ->orWhere('active_months', 'like', "%$monthNum%");
            })
            ->orderBy('percentage', 'desc')
            ->first();
    }
}
