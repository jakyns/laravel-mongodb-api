<?php

namespace App\Models;

use Moloquent;

class Feature extends Moloquent
{
    /**
     * Collection name
     * @var features
     */
    protected $collection = 'features';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'display_name', 'description',
    ];

    public function customers()
    {
        return $this->belongsTo('App\Models\Customer');
    }
}
