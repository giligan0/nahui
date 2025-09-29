<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class InterestUser
 *
 * @property $user_id
 * @property $interest_id
 * @property $created_at
 * @property $updated_at
 *
 * @property Interest $interest
 * @property User $user
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class InterestUser extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['user_id', 'interest_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function interest()
    {
        return $this->belongsTo(\App\Models\Interest::class, 'interest_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }
    
}
