<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingDay extends Model
{
    public $timestamps = false; // managed by booking

    protected $fillable = [
        'booking_id', 'accommodation_id', 'day'
    ];

    protected $casts = [
        'day' => 'date'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class);
    }
}
