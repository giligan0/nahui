<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarRental extends Model
{
    protected $fillable = [
        'rental_date',
        'dropoff_location',
        'total_cost',
        'status',
        'payment_method',
        'rental_duration',
        'car_model',
        'description',
    ];
}
