<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Place
 *
 * @property $id
 * @property $name
 * @property $place_category_id
 * @property $description
 * @property $address_id
 * @property $is_public
 * @property $is_managed
 * @property $managing_org_id
 * @property $hours
 * @property $accessibility_notes
 * @property $entrance_fee
 * @property $currency
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 *
 * @property Address $address
 * @property Organization $organization
 * @property PlaceCategory $placeCategory
 * @property Event[] $events
 * @property Stop[] $stops
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Place extends Model
{
    use SoftDeletes;

    protected $perPage = 20;

    protected $casts = [
    'imagenes' => 'array',
];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'place_category_id', 'description', 'address_id', 'is_public', 'is_managed', 'managing_org_id', 'hours', 'accessibility_notes', 'entrance_fee', 'currency', 'imagenes'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function address()
    {
        return $this->belongsTo(\App\Models\Address::class, 'address_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organization()
    {
        return $this->belongsTo(\App\Models\Organization::class, 'managing_org_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function placeCategory()
    {
        return $this->belongsTo(\App\Models\PlaceCategory::class, 'place_category_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events()
    {
        return $this->hasMany(\App\Models\Event::class, 'id', 'place_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stops()
    {
        return $this->hasMany(\App\Models\Stop::class, 'id', 'place_id');
    }

}
