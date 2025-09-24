<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = [
        'name',
        'type',
        'contact_info',
        'address',
        'website',
    ];
}
