<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    protected $fillable = [
        'transport_status',
        'departure_time',
        'waiting_location',
        'transport_type',
        'organization_id',
        'ticket_price',
        'travel_duration',
    ];
}
