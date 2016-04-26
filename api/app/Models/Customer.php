<?php

namespace App\Models;

use Moloquent;

class Customer extends Moloquent
{
    /**
     * Collection name
     * @var customers
     */
    protected $collection = 'customers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'email',
    ];

    public function features()
    {
        return $this->hasMany('App\Models\Feature');
    }
}
