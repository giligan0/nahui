<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvailabilitySlot extends Model
{
    protected $fillable = [
        'accommodation_id', 'start_date', 'end_date', 'status'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class);
    }

    public function scopeForAccommodation($query, $accommodationId)
    {
        return $query->where('accommodation_id', $accommodationId);
    }

    public static function overlaps(int $accommodationId, $startDate, $endDate): bool
    {
        return static::forAccommodation($accommodationId)
            ->where(function($q) use ($startDate, $endDate) {
                $q->where('start_date', '<', $endDate)
                  ->where('end_date', '>', $startDate);
            })
            ->exists();
    }
}
