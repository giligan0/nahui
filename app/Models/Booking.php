<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Observers\BookingObserver;

class Booking extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'accommodation_id',
        'start_date',
        'end_date',
        'guests',
        'total_price',
        'currency',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'total_price' => 'decimal:2',
    ];

    public static function boot()
    {
        parent::boot();
        static::observe(BookingObserver::class);
    }

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookingDays()
    {
        return $this->hasMany(BookingDay::class);
    }
}
